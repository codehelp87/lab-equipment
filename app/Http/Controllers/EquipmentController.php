<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Cloudder;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\LabUser;
use Illuminate\Http\Request;
use LabEquipment\Equipment;

class EquipmentController extends Controller
{
    public function EquipmentUsers(Request $request, $id)
    {
        $students = [];
        $equipment = Equipment::FindOneById($id);

        if (count($equipment) > 0) {
            $user =  User::FindOneById($equipment->user_id);
            $labProfessor = $user->name;

            $bookings = $equipment->bookings;
            if (count($bookings) > 0) {
                foreach($bookings as $index => $booking) {
                    $students[$index] = $booking->user;
                }
            }
            return response()->json([$labProfessor, $students], 200);
        }

        return response()->json([
            'message' => 'No requesters for this equipment',
        ]);

    }

    public function bookEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if (count($equipment) > 0) {
            return view('student.book_equipment', 
                compact('equipment')
            );
        }
        abort(404);
    }

    public function createEquipment(Request $request)
    {
        $equipment = Equipment::create([
            'title' => $request->title,
            'model_no' => $request->model_no,
            'maker' => $request->maker,
            'time_unit' => $request->time_unit,
            'max_reservation_time' => $request->reservation_time,
            'price_per_unit_time' => $request->price_per_unit,
            'lab_id' => $request->assign_lab,
            'availability' => $request->availability,
            'equipment_photo' => $this->handleCloudinaryFileUpload($request),
            'user_id' => Auth::user()->id,
        ]);

        if (count($equipment) > 0) {
            return response()->json([
                'message' => 'Equipment was created successfully',
                'equipment' => $equipment,
            ]);
        }

        return response()->json([
            'message' => 'Error creating Lab'
        ]);
    }

    public function updateEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if (count($equipment) > 0) {
            $equipment->title = $request->title;
            $equipment->model_no = $request->model_no;
            $equipment->maker = $request->maker;
            $equipment->time_unit = $request->time_unit;
            $equipment->max_reservation_time = $request->reservation_time;
            $equipment->price_per_unit_time = $request->price_per_unit;
            $equipment->lab_id = $request->assign_lab;
            $equipment->availability = $request->availability;
            $equipment->equipment_photo = $this->handleCloudinaryFileUpload($request);
        }

        $equipment->save();

        if (count($equipment) > 0) {
            return response()->json([
                'message' => 'Equipment was updated successfully',
                'equipment' => $equipment,
            ]);
        }

        return response()->json([
            'message' => 'Error creating Lab'
        ]);
    }

    public function editEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);
        $labs = Lab::findAll();

        if (count($equipment) > 0) {
            return view('admin.manage_equipment.edit_equipment', 
                compact('equipment', 'labs')
            );
        }

        abort(404);
    }

    /**
     * This method upload image to cloudinary.
     *
     * @param $request
     *
     * @return picture url
     */
    public function handleCloudinaryFileUpload($request)
    {
        $avatar = $request->file('photo');
        $avatar = Cloudder::upload($avatar, null, [
            'format' => 'jpg',
            'crop'   => 'fill',
            'width'  => 250,
            'height' => 250,
        ]);

        return  Cloudder::getResult()['url'];
    }
}
