<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Asset;
use App\AssetAssignment;
use App\Category;
use App\Colour;
use App\Product;
use App\ProductStock;
use App\Size;

class ProductController extends Controller
{
    private $typeOptions = ['SHOES'=>'SHOES', 'UPSELL'=>'UPSELL',];
    private $currencyOptions = ['IDR'=>'IDR'];
    private $yesnoOptions = [1=>'Yes', 0=>'No'];
    private $statusOptions = ['READY_STOCK'=>'READY_STOCK', 'OUT_OF_STOCK'=>'OUT_OF_STOCK', 'INACTIVE' => 'INACTIVE',];


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index' , compact('products'));
    }

    private function prepareOptions()
    {
        $categories = Category::getByIsActive(true)->get();
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->display_name;
        }

        $sizes = Size::get();
        $sizeOptions = [];
        foreach ($sizes as $size) {
            $sizeOptions[$size->id] = $size->size_value;
        }

        return array("categoryOptions"=>$categoryOptions, "sizeOptions"=>$sizeOptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = (object) [
            'title' => 'Product New'
        ];
        $options = $this->prepareOptions();
        $categoryOptions = $options['categoryOptions'];
        $sizeOptions = $options['sizeOptions'];
        $typeOptions = $this->typeOptions;
        $currencyOptions = $this->currencyOptions;
        $yesnoOptions = $this->yesnoOptions;
        $statusOptions = $this->statusOptions;

        return view('admin.product.create', compact('page', 'categoryOptions', 'typeOptions', 'sizeOptions',
                                                    'currencyOptions', 'statusOptions', 'yesnoOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $this->validate($request, [
                'category'=>'required',
                'type'=>'required',
                'name'=>'alpha_dash|required|unique:products',
                'colour_name'=>'alpha|required',
                'currency'=>'required',
                'price'=>'required|numeric',
                'status'=>'required',
                'is_featured'=>'required|numeric',
                'is_sale'=>'required|numeric',
                'sale_price'=>'required|numeric',
                // 'stock' =>'required|numeric',
                'is_new'=>'required|numeric',
            ]);

        $product->category_id = $request->category;
        $product->type = $request->type;
        $product->colour_name = $request->colour_name;
        $product->name = $request->name;
        $product->display_name = $request->display_name;
        $product->currency = $request->currency;
        $product->price = $request->price;
        $product->is_sale = $request->is_sale;
        $product->sale_price = $request->sale_price;
        // $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_featured = $request->is_featured;
        $product->is_new = $request->is_new;
        $product->created_by = Auth::user()->email;
        $product->updated_by = Auth::user()->email;
        $product->save();
        session()->flash('message', 'Inserted successfully');
        // redirect to edit page so user can insert asset assignments
        return redirect('admin/product/'.$product->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404, 'Not implemented');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = (object) [
            'title' => 'Product Edit'
        ];
        $product = Product::find($id);

        $assetAssignments = AssetAssignment::assignmentId($product->id)->orderByWeight()->get();
        $assets = Asset::all();

        $productStocks = ProductStock::productId($id)->get();

        $options = $this->prepareOptions();
        $categoryOptions = $options['categoryOptions'];
        $sizeOptions = $options['sizeOptions'];
        $typeOptions = $this->typeOptions;
        $currencyOptions = $this->currencyOptions;
        $statusOptions = $this->statusOptions;
        $yesnoOptions = $this->yesnoOptions;

        return view('admin.product.edit', compact('page', 'product', 'assetAssignments', 'assets', 'productStocks',
                                                    'categoryOptions', 'typeOptions', 'sizeOptions',
                                                    'currencyOptions', 'statusOptions', 'yesnoOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $this->validate($request, [
                'category'=>'required',
                'type'=>'required',
                'colour_name'=>'alpha|required',
                'name'=>'alpha_dash|required|unique:products,name,'.$id,
                'display_name'=>'required|unique:products,display_name,'.$id,
                'currency'=>'required',
                'price'=>'required|numeric',
                'status'=>'required',
                'is_featured'=>'required|numeric',
                'is_sale'=>'required|numeric',
                'sale_price'=>'required|numeric',
                // 'stock' =>'required|numeric',
                'is_new'=>'required|numeric',
            ]);
        $product->category_id = $request->category;
        $product->type = $request->type;
        $product->colour_name = $request->colour_name;
        $product->name = $request->name;
        $product->display_name = $request->display_name;
        $product->currency = $request->currency;
        $product->price = $request->price;
        $product->is_sale = $request->is_sale;
        $product->sale_price = $request->sale_price;
        // $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_featured = $request->is_featured;
        $product->is_new = $request->is_new;
        $product->updated_by = Auth::user()->email;

        $product->save();
        session()->flash('message', 'Updated successfully');
        return redirect('admin/product/'.$product->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404, 'Not implemented');
    }
}
