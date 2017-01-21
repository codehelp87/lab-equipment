<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\Lab;
use LabEquipment\LabUser;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function createLab(Request $request)
    {
    	$lab = Lab::create([
    		'title' => $request->title,
    		'model_no' => $request->model_no,
    	]);

    	if (count($lab) > 0) {
    		return response()->json([
    			'message' => 'Lab was created successfully'
    		]);
    	}

    	return response()->json([
    		'message' => 'Error creating Lab'
    	], 400);
    }

    public function getLabUsers(Request $request, $id)
    {
        $lab = Lab::findOneById($id);

        if (count($lab) > 0) {
            $labUsers = [];
            foreach ($lab->labUsers as $index => $users) {
                $labUsers[$index] = $users->user;
            }

            return response()->json($labUsers, 200);
        }

        return response()->json([
            'message' => 'Lab Users not found'
        ], 404);
    }

    public function assignUserToLab(Request $request, $id)
    {
        $lab = Lab::findOneById($id);

        $labUser = LabUser::where('user_id', $request->user)
            ->where('lab_id', $id)
            ->first();

        if ($labUser->count() > 0) {
            return response()->json([
                'message' => 'User has been assigned to Lab before'
            ]); 
        }

        if ($lab->count() > 0) {
            $labUser = LabUser::create([
                'user_id' => $request->user,
                'lab_id' => $id
            ]);

            if ($labUser->count() > 0) {
                return response()->json([
                    'message' => 200,
                ]);
            }
        }

        return response()->json([
            'message' => 'Error Assigning user to Lab'
        ], 400);
    }
}
