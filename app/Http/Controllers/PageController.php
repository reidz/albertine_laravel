<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\AssetAssignment;
use App\Asset;
use App\Cart;
use App\City;
use App\Category;
use App\ProductStock;
use App\Province;
use Illuminate\Support\Facades\DB;
use Session;

class PageController extends Controller
{
    public function index()
    {
    	// get prduct mana aja yg featured
    	$products = Product::isFeatured()->take(4)->get();
    	$assetAssignments = array();
    	$featuredProducts = array();
    	foreach ($products as $product) {
    		$featuredProduct = new \stdClass();
    		$featuredProduct->product_id = $product->id;
    		// get assetassignment weight 0
    		$assetAssignment = AssetAssignment::assignmentId($product->id)->isMain()->first();
    		$asset = Asset::find($assetAssignment->asset_id);
    		$featuredProduct->thumbnail_path = $asset->thumbnail_path;
    		array_push($featuredProducts, $featuredProduct);
    		array_push($featuredProducts, $featuredProduct);
    	}
    	// return $featuredProducts;
    	return view('customer.index' , compact('featuredProducts'));
    }

    public function collections($requestCategory)
    {
        $numOfItems = 2;

        // default category all
    	// $defaultCategory = $categories[0];

        // get all active categories
        $categories = Category::getByIsActive(1)->getByNameNotIn(array("other"))->get();

        $other = Category::getByName("other")->first();
    	
        // in case category not found in category, treat as all
        $found = false;
        $categoryId = null;
        foreach ($categories as $category)
        {
            if(strtolower($requestCategory)  == strtolower($category->name))
            {
                $found = true;
                $categoryId = $category->id;
            }
        }

        $products = null;

        // enaknya gimana ? kalo !found apa mau dilempar ke 404 aja ?
        // gw pengennya engga sih, treat sama kayak all aja lah ya
        if($requestCategory == 'all' || !$found)
        {
            // get products regardless category
            $products = Product::getByCategoryIdNotIn(array($other->id))->paginate($numOfItems);
        }
        else
        {
            $products = Product::getByCategory($categoryId)->paginate($numOfItems);
        }

        foreach ($products as $key => $product) {
            $assetAssignment = AssetAssignment::assignmentId($product->id)->isMain()->first();
            $asset = Asset::find($assetAssignment['asset_id']);
            $product->thumbnail_path = $asset['thumbnail_path'];
        }

        // return $products;
        return view('customer.collections', compact('categories', 'products'));
    }

    // url-nya apa gini aja ?
    // domain/collections/{category}/{product}
    public function collection($requestCategory, $requestProduct)
    {
        $product = Product::getByName($requestProduct)->firstOrFail();
        $category = Category::findOrFail($product->category_id);

        if($requestCategory != $category->name){
            abort(403, 'Not authorized category and product');
        }

        $assetAssignments = AssetAssignment::assignmentId($product->id)->orderByWeight()->get();
        $productStocks = ProductStock::productId($product->id)->get();

        $recommendations = Product::getByStatus('READY_STOCK')->getByType('SHOES')->take(4)->get();

        return view('customer.collection-detail', compact('category', 'product', 
                                                        'assetAssignments', 'productStocks',
                                                        'recommendations'));
        //return $requestCategory.'-'.$requestProduct.'-'.$category->name;
        // fetch asssetAssignment, order by weight
        // set default highlighted asset, weight 0
    }

    public function addToCart(Request $request, $id, $qty)
    {
        $productStock = ProductStock::find($id);

        $key = 'cart';
        $oldCart = Session::has($key) ? Session::get($key) : null;
        $cart = new Cart($oldCart);

        $cart->add($productStock, $qty);
        $request->session()->put($key, $cart);
        // dd($request->session()->get($key));
        return redirect()->route('customer.view-cart');
    }

    public function viewCart()
    {
        $key = 'cart';
        if(!Session::has($key)){
            return view('customer.view-cart', ['productStocks'=>null]);
        }
        $oldCart = Session::get($key);
        $cart = new Cart($oldCart);
        // return $cart->productStocks;
        return view('customer.view-cart', ['productStocks' => $cart->productStocks, 'grandTotalPrice' => $cart->grandTotalPrice, 'currency' => $cart->currency]);
    }

    public function removeCart(Request $request)
    {
        $id = $request->id;

        $key = 'cart';
        // if(!Session::has($key)){
        //     return view('customer.view-cart', ['productStocks'=>null]);
        // // }
        $oldCart = Session::get($key);
        $cart = new Cart($oldCart);
        $cart->remove($id);
        $request->session()->put($key, $cart);
        return "success";
    }

    public function clearCart(Request $request)
    {
        $key = 'cart';
        $request->session()->pull($key, 'default');
    }

    // public function indexShippingAddress(Request $request)
    // {    
    //     // fetch provinces
    //     // fetch cities

    //     $key = 'cart';
    //     if(!Session::has($key)){
    //         return view('customer.view-cart', ['productStocks'=>null]);
    //     }
    //     $oldCart = Session::get($key);
    //     $cart = new Cart($oldCart);

    //     $options = $this->prepareCityProvinceOptions();
    //     $provinceOptions = $options['provinceOptions'];
    //     $cityOptions = $options['cityOptions'];

    //     return view('customer.shipping-address', compact("provinceOptions", "cityOptions", "cart")); 
    // }

    // private function prepareCityProvinceOptions()
    // {
    //     $provinces = Province::get();
    //     $provinceOptions = [];
    //     foreach ($provinces as $province) {
    //         $provinceOptions[$province->id] = $province->name;
    //     }

    //     $cities = City::get();
    //     $cityOptions = [];
    //     foreach ($cities as $city) {
    //         $cityOptions[$city->id] = $city->name;
    //     }

    //     return array("provinceOptions"=>$provinceOptions, "cityOptions"=>$cityOptions);
    // }    
}