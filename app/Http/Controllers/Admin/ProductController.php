<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Colour;
use App\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $typeOptions = ['SHOES'=>'SHOES', 'UPSELL'=>'UPSELL',];
    private $currencyOptions = ['IDR'=>'IDR'];
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
        $categoryOptions = $this->prepareOptions()['categoryOptions'];
        $typeOptions = $this->typeOptions;
        $currencyOptions = $this->currencyOptions;
        $statusOptions = $this->statusOptions;

        return view('admin.product.create', compact('page', 'categoryOptions', 'typeOptions', 
                                                    'currencyOptions', 'statusOptions'));
    }

    private function prepareOptions()
    {
        $categories = Category::getByIsActive(true);
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }

        return array("categoryOptions"=>$categoryOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $options = $this->prepareOptions();
        $categoryOptions = $options['categoryOptions'];
        $typeOptions = $this->typeOptions;
        $currencyOptions = $this->currencyOptions;
        $statusOptions = $this->statusOptions;

        return view('admin.product.edit', compact('page', 'product', 'categoryOptions', 'typeOptions', 
                                                    'currencyOptions', 'statusOptions'));
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
        //
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
