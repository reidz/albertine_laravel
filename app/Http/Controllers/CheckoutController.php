<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetAssignment;
use App\Address;
use App\Asset;
use App\Cart;
use App\City;
use App\Province;
use Session;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');

    }

    public function indexShippingAddress(Request $request)
    { 
    	$cart = $this->prepareOrderSummary($request, true);

    	$options = $this->prepareCityProvinceOptions();
        $provinceOptions = $options['provinceOptions'];
        $cityOptions = $options['cityOptions'];

       // fetch first active customer address 
        $address = Address::isMain()->first();

        return view('customer.shipping-address', compact("provinceOptions", "cityOptions", "cart", "address")); 
    }

    public function saveShippingAddress(Request $request)
    {
    	$this->validate($request, [
    	    'first_name'=>'required|max:100',
    	    'last_name'=>'required|max:100',
    	    'address'=>'required|max:100',
    	    'city'=>'required|numeric|min:1',
    	    'province'=>'required|numeric|min:1',
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
    		return 'insert new';
    	}
    	else
    	{
    		$address = Address::isMain()->first();
    		$address = $this->setAddress($request, $address, $user_id);
    		$insert =  $address->save();
    		return 'modify old';
    	}
    }

    private function setAddress($request, $address, $user_id)
    {
    	$address->first_name = $request->first_name;
    	$address->last_name = $request->last_name;
    	$address->address = $request->address;
    	$address->city = $request->city;
    	$address->province = $request->province;
    	$address->postal_code = $request->postal_code;
    	$address->phone = $request->phone;
    	$address->is_active = true;
    	$address->user_id = $user_id;
    	return $address;
    }

    private function prepareCityProvinceOptions()
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

        return array("provinceOptions"=>$provinceOptions, "cityOptions"=>$cityOptions);
    }

    private function prepareOrderSummary($request, $init)
    {
    	$key = 'cart';
        if(!Session::has($key)){
            return view('customer.view-cart', ['productStocks'=>null]);
        }

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
