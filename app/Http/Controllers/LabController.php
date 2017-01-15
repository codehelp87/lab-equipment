<?php

namespace LabEquipment\Http\Controllers;

use Illuminate\Http\Request;
use LabEquipment\Lab;

class LabController extends Controller
{
    public function createLab(Request $request)
    {
    	$lab = Lab::create([
    		'title' => $request->title,
    		'model_no' => $request->model_no,
    		'user_id' => $request->user
    	]);

    	if (count($lab) > 0) {
    		return response()->json([
    			'message' => 'Lab was created successfully'
    		]);
    	}

    	return response()->json([
    		'message' => 'Error creating Lab'
    	]);
    }
}
