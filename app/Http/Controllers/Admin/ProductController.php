<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Colour;
use App\Category;
use App\Asset;
use App\AssetAssignment;
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
        $categories = Category::getByIsActive(true)->get();
        $productOptions = [];
        foreach ($categories as $product) {
            $productOptions[$product->id] = $product->name;
        }

        return array("categoryOptions"=>$productOptions);
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
                'name'=>'required|unique:products',
                'currency'=>'required',
                'amount'=>'required|numeric',
                'status'=>'required',
            ]);
        $product->category_id = $request->category;
        $product->type = $request->type;
        $product->name = $request->name;
        $product->currency = $request->currency;
        $product->amount = $request->amount;
        $product->status = $request->status;
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

        $assetAssignments = AssetAssignment::assignmentId($product->id)->get();
        $assets = Asset::all();

        $categoryOptions = $this->prepareOptions()['categoryOptions'];
        $typeOptions = $this->typeOptions;
        $currencyOptions = $this->currencyOptions;
        $statusOptions = $this->statusOptions;

        return view('admin.product.edit', compact('page', 'product', 'assetAssignments', 'assets',
                                                    'categoryOptions', 'typeOptions', 
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
        // $category = Category::find($id);
        // $this->validate($request, [
        //         'name'=>'required',
        //         'is_active'=>'required'
        //     ]);
        // $category->name = $request->name;
        // $category->is_active = $request->is_active;
        // $category->updated_by = Auth::user()->email;
        // $category->save();
        // session()->flash('message', 'Updated successfully');
        // return redirect('admin/category');
        return $request->all();
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
