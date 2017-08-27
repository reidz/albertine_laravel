<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetAssignment;
use App\Address;
use App\Asset;
use App\Cart;
use App\City;
use App\Province;
use App\Subdistrict;
use Session;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
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

        return view('customer.shipping-address', compact("provinceOptions", "cityOptions", "subdistrictOptions", "cart", "address")); 
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
      
      // hardcoded Jakarta Utara 
      $origin = array(
          "id" => 155,
          "type" => "city",
      );
      $destination = array(
          "id" => $address->subdistrict_id,
          "type" => "subdistrict",
      );
      $weight = $cart->grandTotalQty * 1000;

      $costs = $this->cost($origin, $destination, $weight);
      $deliveryProvider = $costs[0]['name'];
      // return $costs[0]['costs'];
      $deliveryOptions = $this->prepareDeliveryOptions($costs[0]['costs']);

      return view('customer.shipping-payment', compact("deliveryOptions", "cart", "address"));
    }

    private function prepareDeliveryOptions($costs)
    {
      $deliveryOptions = [];
      foreach ($costs as $cost ){
        $item = $cost['cost'][0];
          $key = $cost['service'].'#'.$cost['description'].'#'.$item['value'].'#'.$item['etd'].'#'.$item['note'];
          $deliveryOptions[$key] = $cost['description'].' '.
                                  '('.$item['etd'].' days) - IDR '.
                                  $item['value'];
      }
      return $deliveryOptions;
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
        	$assetAssignment = AssetAssignment::assignmentId($key)->isMain()->first();
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