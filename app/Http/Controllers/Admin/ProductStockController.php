<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductStock;
use Illuminate\Support\Facades\Auth;

class ProductStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
    	$productStock = new ProductStock();
    	$productStock->size_id = $request->size_id;
    	$productStock->product_id = $request->product_id;
    	$productStock->stock = $request->stock;
        $productStock->stock_sold = 0;
        $productStock->stock_holding = 0;
    	$productStock->is_active = $request->is_active;
    	$productStock->created_by = Auth::user()->email;
        $productStock->updated_by = Auth::user()->email;

        if($productStock->size_id == null || $productStock->product_id == null ||
        	$productStock->stock == null || $productStock->is_active == null ||
        	$productStock->created_by == null || $productStock->updated_by == null)
        {
        	return 'failed';
        }
        else
        {
        	$productStock->save();
        	return 'success';
        }   
    }

    public function update(Request $request)
    {
    	$productStock = ProductStock::find($request->id);

    	// can't update existing size to another one, add new one and/or inactivate the old one
    	$productStock->stock = $request->stock;
    	$productStock->is_active = $request->is_active;
    	$productStock->updated_by = Auth::user()->email;

    	if($productStock->stock == null || $productStock->is_active == null || 
    		$productStock->updated_by == null)
        {
        	return 'failed';
        }
        else
        {
        	$productStock->save();
    		return 'success';
        }    	
    }

    public function destroy(Request $request)
    {
    	// ProductStock::destroy($request->id);
        return 'success';
    }
}
