<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use Illuminate\Support\Facades\Auth;
use Image;
use Storage;

class AssetController extends Controller
{
    

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
        $assets = Asset::all();
        return view('admin.asset.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = (object) [
            'title' => 'Asset New'
        ];
        return view('admin.asset.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('image')->isValid()){

            $imagePath = $request->file('image')->store('public');

            $thumbnail = Image::make(Storage::get($imagePath))->resize(200,150)->encode();

            $fileName = explode('/',$imagePath)[1];
            $fileName = explode('.',$imagePath)[0];
            $fileExtension = explode('.',$imagePath)[1];
            $thumbnailPath = Storage::put($fileName.'-extension.'.$fileExtension, $thumbnail);
        }


        // $asset = new asset;
        // $this->validate($request, [
        //         'name'=>'required|unique:assets',
        //         'file'=>'required'
        //     ]);
        
        // // resize to 200x200
        // $thumbnail_path = null;
        // $image_path = null;

        // $asset->name = $request->name;
        // $asset->thumbnail_path = $request->thumbnail_path;
        // $asset->image_path = $request->image_path;
        // $asset->created_by = Auth::user()->email;
        // $asset->updated_by = Auth::user()->email;
        // $insert = $asset->save();
        // session()->flash('message', 'Inserted successfully');
        // return redirect('admin/asset');
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
            'title' => 'Asset Edit'
        ];
        $asset = Asset::find($id);
        return view('admin.asset.edit', compact('page', 'asset'));
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
        $asset = Asset::find($id);
        $this->validate($request, [
                'name'=>'required',
            ]);
        // validate unique ga
        $asset->name = $request->name;
        $asset->is_active = $request->is_active;
        $asset->updated_by = Auth::user()->email;
        $asset->save();
        session()->flash('message', 'Updated successfully');
        return redirect('admin/asset');
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
