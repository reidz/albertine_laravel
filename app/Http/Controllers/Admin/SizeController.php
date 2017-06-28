<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    private $sizeMetricOptions = ['EU'=>'EU', 'US'=>'US', 'UK' => 'UK,AU,NZ','JP' => 'JP',]; 

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
        $sizes = Size::all();
        return view('admin.size.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $page = (object) [
       'title' => 'Size New'
       ];
       $sizeMetricOptions = $this->sizeMetricOptions;
       return view('admin.size.create', compact('page', 'sizeMetricOptions'));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size = new Size;
        $this->validate($request, [
            'size_metric'=>'required',
            'size_value'=>'required|unique:sizes,size_value,NULL,NULL,size_metric,'.$request->size_metric
            ]);
        // those 2 NULLs no idea what is that

        $size->size_metric = $request->size_metric;
        $size->size_value = $request->size_value;
        $size->created_by = Auth::user()->email;
        $size->updated_by = Auth::user()->email;
        $insert = $size->save();
        
        return redirect('admin/size');
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
        abort(404, 'Not implemented');
        // THIS IS FUNCTIONING BUT JUST DONT MAKE IT UPDATABLE
        // $page = (object) [
        //     'title' => 'Size Edit'
        // ];
        // $size = Size::find($id);
        // $sizeMetricOptions = $this->sizeMetricOptions;
        // return view('admin.size.edit', compact('page', 'size', 'sizeMetricOptions'));
        // THIS IS FUNCTIONING BUT JUST DONT MAKE IT UPDATABLE
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
        // THIS IS FUNCTIONING BUT JUST DONT MAKE IT UPDATABLE
        // $size = size::find($id);
        // $this->validate($request, [
        //     'size_metric'=>'required',
        //     'size_value'=>'required|unique:sizes,size_value,NULL,NULL,size_metric,'.$request->size_metric
        //     ]);
        // $size->size_metric = $request->size_metric;
        // $size->size_value = $request->size_value;
        // $size->updated_by = Auth::user()->email;
        // $size->save();
        // session()->flash('message', 'Updated successfully');
        // return redirect('admin/size');
        // THIS IS FUNCTIONING BUT JUST DONT MAKE IT UPDATABLE
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
