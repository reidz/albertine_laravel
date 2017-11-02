<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetAssignment;
use App\Address;
use App\Asset;
use App\Cart;
use App\City;
use App\Order;
use App\OrderItem;
use App\OrderShipping;
use App\Product;
use App\ProductStock;
use App\Province;
use App\Subdistrict;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;

class CheckoutController extends Controller
{
  // hardcoded Jakarta Utara
  private $origin = array(
          "id" => 155,
          "type" => "city",
      );

	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.cart');
    }

    public function indexShippingAddress(Request $request)
    { 
    	$cart = $this->prepareOrderSummary($request, true);

    	$options = $this->prepareOptions();
      $provinceOptions = $options['provinceOptions'];
      $cityOptions = $options['cityOptions'];
      $subdistrictOptions = $options['subdistrictOptions'];

       // fetch first active customer address 
        $address = Address::isMain()->first();

        // return view('customer.shipping-address', compact("provinceOptions", "cityOptions", "subdistrictOptions", "cart", "address"));
        return response()->json(['assetBaseUrl' => asset('storage'),
                              'provinceOptions' => $provinceOptions, 
                                  'cityOptions' => $cityOptions, 
                                  'subdistrictOptions' => $provinceOptions, 
                                  'cart' => $cart, 
                                  'address' => $address]); 
    }

    public function saveShippingAddress(Request $request)
    {
    	$this->validate($request, [
    	    'first_name'=>'required|max:100',
    	    'last_name'=>'required|max:100',
    	    'address'=>'required|max:100',
    	    'city_id'=>'required|numeric|min:1',
    	    'province_id'=>'required|numeric|min:1',
          'subdistrict_id'=>'required|numeric|min:1',
    	    'postal_code'=>'required|numeric',
    	    'phone'=>'required|max:100',
    	    ]);

    	$user_id = Auth::user()->id;

    	// check old then update or 
    	// new then deactivate old create new
    	if($request->my_address == 'new')
    	{
    		$oldAddress = Address::isMain()->first();
    		if($oldAddress)
    		{
    			// deactivate old
    			$oldAddress->is_active = false;
    			$oldAddress->save();
    		}
    		$address = new Address;
    		$address = $this->setAddress($request, $address, $user_id);
    		$insert =  $address->save();
    		// return 'insert new';
    	}
    	else
    	{
    		$address = Address::isMain()->first();
    		$address = $this->setAddress($request, $address, $user_id);
    		$insert =  $address->save();
    		// return 'modify old';
    	}
      $cart = $this->prepareOrderSummary($request, true);
      $address = Address::isMain()->first();
      
      $destination = array(
          "id" => $address->subdistrict_id,
          "type" => "subdistrict",
      );
      $weight = $cart->grandTotalQty * 1000;

      $costs = $this->cost($this->origin, $destination, $weight);
      $deliveryProvider = $costs[0]['name'];
      // return $costs[0]['costs'];
      $shippingOptions = $this->prepareShippingOptions($costs[0]['costs']);

      // save reservation ?

      // return view('customer.shipping-payment', compact("shippingOptions", "cart", "address"));
      return response()->json(['assetBaseUrl' => asset('storage'),
                              'shippingOptions' => $shippingOptions, 
                                  'cart' => $cart, 
                                  'address' => $address]); 
    }

    public function reviewOrder(Request $request)
    {
      $this->validate($request, [
          'shipping'=>'required'
          ]);

      $shippings = explode('#',$request->shipping);
      // CTC#JNE City Courier#9000#1-2#
      // 0 service, 1 description, 2 price, 3 etd, 4 note
      // JNE City Courier (1-2 days) - IDR 9000
      $shippingDescription = $shippings[1].' ('.$shippings[3].' days)'.' - IDR '.$shippings[2];
      $shipping = $request->shipping;

      // revise cart delivery fee with selected fee
      $this->setShippingFee($request, $shippings[2]);
      
      $cart = $this->prepareOrderSummary($request, true);
      $address = Address::isMain()->first();
      
      // return view('customer.review-order', compact("cart", "address", "shipping", "shippingDescription"));
      return response()->json(['assetBaseUrl' => asset('storage'),
                              'cart' => $cart, 
                                  'address' => $address, 
                                  'shipping' => $shipping,
                                  'shippingDescription' => $shippingDescription]); 
    }

    public function confirmOrder(Request $request)
    {
      $cart = $this->prepareOrderSummary($request, true);
      $address = Address::isMain()->first();

      $shippings = explode('#',$request->shipping);
      // CTC#JNE City Courier#9000#1-2#
      // 0 service, 1 description, 2 price, 3 etd, 4 note
      // JNE City Courier (1-2 days) - IDR 9000

      try
      {
        // check stock
        // if stock
        // redirect to page view-cart, state which 1 is out of stock, hope customer pick another 1

        $totalProductPrice = 0;

        foreach ($cart->productStocks as $key => $productStock) 
        {
          $productName = $productStock['productStock']['product']['display_name'].' - '.
                          $productStock['productStock']['product']['colour_name'];

          $productStockCurrent = ProductStock::find($productStock['productStock']['id']);
          
          // stock check
          if($productStockCurrent->stockAvailable - $productStock['qty'] < 0)
          {
            throw new OutofStockException($productName);
          }

          // check sale state
          if($productStock['productStock']['product']['is_sale'] != $productStockCurrent->product->is_sale)
          {
            throw new SaleStateException($productName);
          }

          $priceToCheckSession = -1;
          $priceToCheckDB = -1;
          if($productStock['productStock']['product']['is_sale'])
          {
            $priceToCheckSession = $productStock['productStock']['product']['sale_price'];
            $priceToCheckDB = $productStockCurrent->product->sale_price;
          }
          else
          {
            $priceToCheckSession = $productStock['productStock']['product']['price'];
            $priceToCheckDB = $productStockCurrent->product->price; 
          }

          // check product single price 
          if($priceToCheckSession != $priceToCheckDB)
          {
            throw new ProductPriceChangeException($productName);
          }

          // check product qty * single price
          if($productStock['subTotal'] != ($priceToCheckSession * $productStock['qty']))
          {
            throw new AccumulationProductPriceChangeException($productName);
          }
          else
          {
            $totalProductPrice += ($priceToCheckSession * $productStock['qty']);
          }
        }
        
        // check shipping fee
        $destination = array(
            "id" => $address->subdistrict_id,
            "type" => "subdistrict",
        );
        $weight = $cart->grandTotalQty * 1000;
        $costs = $this->cost($this->origin, $destination, $weight);

        // check shipping fee
        $totalShippingPrice = 0;
        foreach ($costs[0]['costs'] as $key => $cost) {
          if($cost['service'] == $shippings[0])
          {
            if( $cost['cost'][0]['value'] != $cart->shippingFee)
            {
              throw new ShippingPriceChangeException();
            }
            else
            {
              $totalShippingPrice = $cost['cost'][0]['value'];
            }
          }
        }

        // check grand total
        // exclude promo from calculation for now
        $grandTotal = $totalProductPrice + $totalShippingPrice;
        if($grandTotal != $cart->grandTotal)
        {
          throw new GrandTotalException();
        }

        // else
        // ok all checked and sanitized
      }
      catch(SaleStateException $e)
      {
        // redirect to view cart, tell customer which one is out of sync
        // expect customer to remove and rebook
        return 'sale stat -'.$e->getMessage();
        // session()->flash('message', 'Inserted successfully');
      }
      catch(OutofStockException $e)
      {
        // redirect to view cart, tell customer which one is out of stock
        // expect customer to remove and rebook
        return 'out of stock -'.$e->getMessage();
      }
      catch(ProductPriceChangeException $e)
      {
        // redirect to view cart, tell customer which one is price changed
        // expect customer to remove and rebook
        return 'product price change -'.$e->getMessage();
      }
      catch(AccumulationProductPriceChangeException $e)
      {
        // redirect to view cart, tell customer which one is price changed
        // expect customer to remove and rebook
        return 'accumulation product price change -'.$e->getMessage();
      }
      catch(ShippingPriceChangeException $e)
      {
        // redirect to view cart, tell customer shipping price changed
        // expect customer to proceed
        return 'shipping price change -'.$e->getMessage();
      }
      catch(GrandTotalException $e)
      {
        // this is fraud candidate
        // redirect to view cart, tell customer to proceed as usual again
        // expect customer to remove and rebook
        return 'grand total -'.$e->getMessage();
      }

      // 1. update product_stock.holding for each cart->productStocks
      foreach ($cart->productStocks as $key => $productStock) 
      {
        $productStockCurrent = ProductStock::find($productStock['productStock']['id']);
        $productStockCurrent->stock_holding += $productStock['qty'];
        $productStockCurrent->save();
      }

      // 2. insert order, orderItems, orderShipping
      // 2.1 order
      $order = new Order;
      $order->user_id = Auth::user()->id;
      $order->user_first_name =Auth::user()->name;
      $order->user_last_name = Auth::user()->last_name;
      $order->user_email = Auth::user()->email;
      $order->currency = $cart->currency;
      $order->grand_total_qty = $cart->grandTotalQty;
      $order->grand_total_price = $cart->grandTotalPrice;
      $order->shipping_price = $cart->shippingFee;
      $order->promo_price = $cart->promo;
      $order->grand_total = $cart->grandTotal;
      $order->status = 'PAYMENT_CONFIRMATION';
      $order->reason = '';
      $order->created_by = Auth::user()->email;
      $order->updated_by = Auth::user()->email;
      $order->save();

      // 2.2 orderItems
      foreach ($cart->productStocks as $key => $productStock) 
      {
        $orderItem = new OrderItem;
        $orderItem->order_id = $order->id;
        $orderItem->type = 'SHOES';
        $orderItem->product_id = $productStock['productStock']['product_id'];
        $orderItem->name = $productStock['productStock']['product']['name'];
        $orderItem->display_name = $productStock['productStock']['product']['display_name'];
        $orderItem->colour_name = $productStock['productStock']['product']['colour_name'];
        $orderItem->details = $productStock['productStock']['product']['details'];
        $orderItem->currency = $productStock['productStock']['product']['currency'];
        $orderItem->price = $productStock['productStock']['product']['price'];
        $orderItem->is_sale = $productStock['productStock']['product']['is_sale'];
        $orderItem->sale_price = $productStock['productStock']['product']['sale_price'];
        $orderItem->is_featured = $productStock['productStock']['product']['is_featured'];
        $orderItem->is_new = $productStock['productStock']['product']['is_new'];
        $orderItem->size_id = $productStock['productStock']['size']['id'];
        $orderItem->size_metric = $productStock['productStock']['size']['size_metric'];
        $orderItem->size_value = $productStock['productStock']['size']['size_value'];
        $orderItem->count = $productStock['qty'];
        $orderItem->save();
      }

      // 2.3. orderShipping
      $orderShipping = new OrderShipping;
      $orderShipping->order_id = $order->id;
      $orderShipping->first_name = $address->first_name;
      $orderShipping->last_name = $address->last_name;
      $orderShipping->address = $address->address;
      $orderShipping->city_id = $address->city_id;
      $orderShipping->province_id = $address->province_id;
      $orderShipping->subdistrict_id = $address->subdistrict_id;
      $orderShipping->postal_code = $address->postal_code;
      $orderShipping->phone = $address->phone;
      $orderShipping->service = $shippings[0];
      $orderShipping->description = $shippings[1];
      $orderShipping->currency = $order->currency;
      $orderShipping->price = $shippings[2];
      $orderShipping->etd = $shippings[3];
      $orderShipping->note = $shippings[4];
      $orderShipping->total_weight = $cart->grandTotalQty * 1000;
      $orderShipping->receipt_no = null;
      $orderShipping->receipt_note = null;
      $orderShipping->created_by = Auth::user()->email;
      $orderShipping->updated_by = Auth::user()->email;
      $orderShipping->save();

      // 3. email customer
      // 4. email albertine admin


      // return 'sucess-page';
      return response()->json(['route' => 'sucess-page']);
    }

    private function setShippingFee($request, $shippingFee)
    {
      $key = 'cart';
      $oldCart = Session::has($key) ? Session::get($key) : null;
      $cart = new Cart($oldCart);

      $cart->setShippingFee($shippingFee);
      $request->session()->put($key, $cart);
    }

    private function prepareShippingOptions($costs)
    {
      $shippingOptions = [];
      foreach ($costs as $cost ){
        $item = $cost['cost'][0];
          $key = $cost['service'].'#'.$cost['description'].'#'.$item['value'].'#'.$item['etd'].'#'.$item['note'];
          $shippingOptions[$key] = $cost['description'].' '.
                                  '('.$item['etd'].' days) - IDR '.
                                  $item['value'];
      }
      return $shippingOptions;
    }

    private function cost($origin, $destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "origin=".$origin['id'].
                            "&originType=".$origin['type'].
                            "&destination=".$destination['id'].
                            "&destinationType=".$destination['type'].
                            "&weight=".$weight.
                            "&courier=jne",
          // CURLOPT_POSTFIELDS => "origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: "."5ecb3bba224692d4978c7f56d744b6fb"
          ),
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $json = json_decode($response, true);

          return $json['rajaongkir']['results'];
        }
    }

    private function setAddress($request, $address, $user_id)
    {
    	$address->first_name = $request->first_name;
    	$address->last_name = $request->last_name;
    	$address->address = $request->address;
      $address->subdistrict_id = $request->subdistrict_id;
    	$address->city_id = $request->city_id;
    	$address->province_id = $request->province_id;
    	$address->postal_code = $request->postal_code;
    	$address->phone = $request->phone;
    	$address->is_active = true;
    	$address->user_id = $user_id;
    	return $address;
    }

    private function prepareOptions()
    {
        $provinces = Province::get();
        $provinceOptions = [];
        foreach ($provinces as $province) {
            $provinceOptions[$province->id] = $province->name;
        }

        $cities = City::get();
        $cityOptions = [];
        foreach ($cities as $city) {
            $cityOptions[$city->id] = $city->name;
        }

        $subdistricts = Subdistrict::get();
        $subdistrictOptions = [];
        foreach ($subdistricts as $subdistrict) {
            $subdistrictOptions[$subdistrict->id] = $subdistrict->name;
        }

        return array("provinceOptions"=>$provinceOptions, "cityOptions"=>$cityOptions, "subdistrictOptions"=>$subdistrictOptions);
    }

    private function prepareOrderSummary($request, $init)
    {
        $key = 'cart';
        $oldCart = Session::get($key);
        $cart = new Cart($oldCart);

        foreach ($cart->productStocks as $key => $productStock) {
        	$assetAssignment = AssetAssignment::assignmentId($productStock['productStock']['product_id'])->isMain()->first();
        	$asset = Asset::find($assetAssignment->asset_id);     
        	$productStock['productStock']['product']['thumbnail_path'] = $asset->thumbnail_path;
        }

        if($init)
        {
        	$request->session()->put($key, $cart);
        }
        return $cart;
    }      
}

class OutofStockException extends Exception { 
  // public function getCustomMessage(){ return 'out of stock -'.parent::getMessage(); } 
}

class ProductPriceChangeException extends Exception { 
  // public function getCustomMessage(){ return 'product price change -'.parent::getMessage(); 
}

class AccumulationProductPriceChangeException extends Exception { 
  // public function getCustomMessage(){ return 'accumulation product price change -'.parent::getMessage(); 
}

class SaleStateException extends Exception { 
  // public function getCustomMessage(){ return 'sale state -'.parent::getMessage(); 
}

class GrandTotalException extends Exception { 
  // public function getCustomMessage(){ return 'grand total -'.parent::getMessage(); 
}

class ShippingPriceChangeException extends Exception { 
  // public function getCustomMessage(){ return 'shipping price -'.parent::getMessage(); 
}