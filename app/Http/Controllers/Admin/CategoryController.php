<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private $isActiveOptions = [1 => "Active", 0 => "Inactive",]; 

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
        $categories = Category::all();
        return view('admin.category.home' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = (object) [
            'title' => 'Create Category'
        ];
        $isActiveOptions = $this->isActiveOptions;
        return view('admin.category.create', compact('page', 'isActiveOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $this->validate($request, [
                'name'=>'required|unique:categories',
                'is_active'=>'required'
            ]);
        $category->name = $request->name;
        $category->is_active = $request->is_active;
        $category->created_by = Auth::user()->email;
        $category->updated_by = Auth::user()->email;
        $insert = $category->save();
        session()->flash('message', 'Inserted successfully');
        return redirect('admin/category');
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
            'title' => 'Category Edit'
        ];
        $category = Category::find($id);
        $isActiveOptions = $this->isActiveOptions;
        return view('admin.category.edit', compact('page', 'category', 'isActiveOptions'));
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
        $category = Category::find($id);
        $this->validate($request, [
                'name'=>'required',
                'is_active'=>'required'
            ]);
        $category->name = $request->name;
        $category->is_active = $request->is_active;
        $category->updated_by = Auth::user()->email;
        $category->save();
        session()->flash('message', 'Updated successfully');
        return redirect('admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        
        $category->updated_by = Auth::user()->email;
        $category->save();
        return 'Delete';
    }
}
