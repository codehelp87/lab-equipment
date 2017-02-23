<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use LabEquipment\Lab;
use LabEquipment\LabUser;
use LabEquipment\Booking;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function updateLab(Request $request, $id)
    {
        $lab = Lab::find($id);

        if (count($lab) > 0) {
            $lab->title = $request->title;
        }

        $lab->save();

        if (count($lab) > 0) {
            return response()->json([
                'message' => 'Lab was updated successfully',
                'lab' => $lab,
            ]);
        }

        return response()->json([
            'message' => 'Error creating Lab'
        ]);
    }

    public function editLab(Request $request, $id)
    {
        $lab = Lab::find($id);

        if (count($lab) > 0) {
            return view('admin.manage_lab.edit_lab', 
                compact('lab')
            );
        }

        abort(404);
    }

    public function deleteLab(Request $request, $id)
    {
        $lab = Lab::find($id);

        if ($lab->count() > 0) {
            $lab->forceDelete();

            return response()->json(['message' => 'deleted']);
        }
        return response()->json(['message' => 'Error deleting lab']);
    }

    public function getLabEquipments(Request $request, $id) 
    {
        $lab = Lab::findOneById($id);

        if (count($lab) > 0) {
            $equipments = $lab->equipments;
            $LabProfessor = $lab->title ?? 'Nil';
            $professorEmail = $lab->labUser[0]->user->email ?? 'Nil';
            $profDetails = ['name' => $LabProfessor, 'email' => $professorEmail];

            return response()->json([$profDetails, $equipments], 200);
        }

        return response()->json([
            'message' => 'Lab equipments not available'
        ], 200);
    }

    public function createLab(Request $request)
    {
    	$lab = Lab::create([
    		'title' => $request->title,
    		'model_no' => 'model_no',
            'user_id' => Auth::user()->id,
    	]);

    	if (count($lab) > 0) {
    		return response()->json([
    			'message' => 'Lab was created successfully',
                'lab' => $lab,
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
            $labUsers = Booking::where('lab_id', $lab->id)
               ->where('status', '>=', 1)
               ->get();

             $collection = collect($labUsers);
             $unique = $collection->unique('user_id');
             $unique->values()->all();
             $labUsers = $unique->values()->all();

            if (count($labUsers) > 0) {
                foreach ($labUsers as $index => $users) {
                    $labUsers[$index] = $users->user;
                }
            }

            return response()->json($labUsers, 200);
        }

        return response()->json([
            'message' => 'Lab Users not found'
        ], 400);
    }

    public function assignUserToLab(Request $request, $id)
    {
        $lab = Lab::findOneById($id);

        $labUser = LabUser::where('user_id', $request->user)
            ->where('lab_id', $lab->id)
            ->first();

        if (count($labUser) > 0) {
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
