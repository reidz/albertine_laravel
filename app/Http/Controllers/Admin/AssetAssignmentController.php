<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetAssignment;
use Illuminate\Support\Facades\Auth;

class AssetAssignmentController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
    	$assetAssignment = new AssetAssignment();
    	$assetAssignment->asset_id = $request->asset_id;
    	$assetAssignment->assignment_id = $request->assignment_id;
    	$assetAssignment->assignment_type = $request->assignment_type;
    	$assetAssignment->weight = $request->weight;
    	$assetAssignment->created_by = Auth::user()->email;
        $assetAssignment->updated_by = Auth::user()->email;

        if($assetAssignment->asset_id == null || $assetAssignment->assignment_type == null ||
        	$assetAssignment->assignment_id == null || $assetAssignment->weight == null ||
        	$assetAssignment->created_by == null || $assetAssignment->updated_by == null)
        {
        	return 'failed';
        }
        else
        {
        	$assetAssignment->save();
    		return 'success';
        }
        
    }

    public function update(Request $request)
    {
    	$assetAssignment = AssetAssignment::find($request->id);

    	$assetAssignment->asset_id = $request->asset_id;
    	$assetAssignment->weight = $request->weight;
    	$assetAssignment->updated_by = Auth::user()->email;

    	if($assetAssignment->asset_id == null || $assetAssignment->id == null || 
    		$assetAssignment->weight == null ||$assetAssignment->updated_by == null)
        {
        	return 'failed';
        }
        else
        {
        	$assetAssignment->save();
    		return 'success';
        }    	
    }

    public function destroy(Request $request)
    {
    	AssetAssignment::destroy($request->id);
        return 'success';
    }
}
