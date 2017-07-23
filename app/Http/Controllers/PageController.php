<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\AssetAssignment;
use App\Asset;
use App\Category;
use Illuminate\Support\Facades\DB;

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
    public function collections($requestCategory)
    {
        $numOfItems = 2;

        // default category all
    	// $defaultCategory = $categories[0];

        // get all active categories
        $categories = Category::getByIsActive(1)->get();
    	
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
            $products = Product::paginate($numOfItems);
        }
        else
        {
            $products = Product::getByCategory($categoryId)->paginate($numOfItems);
        }

        // return $products;
        return view('customer.collections', compact('categories', 'products'));
    }
}
