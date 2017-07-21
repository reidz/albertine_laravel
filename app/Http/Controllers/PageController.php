<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\AssetAssignment;
use App\Asset;
use App\Category;

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

    // param in; category, page
    // default value aja
    public function products()
    {
    	$categories = Category::getByIsActive(1)->get();
    	$defaultCategory = $categories[0];
    	
    	$products = Product::getByCategory($defaultCategory->id)->get();

    	// $assets
    	$page = 0;
    	return view('customer.products', compact('page', 'categories', 'products'));
    }
}
