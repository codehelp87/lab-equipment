<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use LabEquipment\Equipment;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function editUserInfo(Request $request, $email)
    {
        $name = $request->name;
        $email = $request->email;
        $office = $request->office;
        $phone = $request->phone;
        $oldPassword = $request->c_password;
        $newPassword = $request->new_password;
        // use the email address to find the record
        $user = User::findOneByEmail($email);

        if (count($user) > 0) {
            if (\Hash::check($oldPassword, $user->getAuthPassword())) {
                $user->name = $name;
                $user->email = $email;
                $user->office_location = $office;
                $user->phone = $phone;
                $user->password = bcrypt($newPassword);
                $user->save();
            } 
            return response()->json(['message' => 'Record updated successfully']);
        }
        return response()->json(['message' => 'Error updating record']);
    }

    public function editUserAccount(Request $request, $userId)
    {
        $user = User::findOneByIdWithTrashed($userId);

        if (is_null($user)) {
            return response()->json(['message' => 'Account De-activated'], 200);
        }
        //return response()->json($user, 200);
        return view('admin.manage_user_account.update_user_account', 
            compact('user')
        );
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $user = User::findOneByIdWithTrashed($userId);

        if (!is_null($user)) {
            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->office_location = $request->office;
            $user->student_id = $request->student_id;
            $user->role_id = $request->role;

            $status = $request->status == 0? $user->destroy($user->id): $user->restore();

            $user->save();

            // For Equipment
            $equipments = $request->equipment;
            $equipmentId = $request->equipment_id;
            $equipmentIds = explode('##', $equipmentId);

            if (count($equipments) > 0) {
                foreach($equipments as $index => $equipment) {
                    $labEquipment = Equipment::findOneByIdWithTrashed($equipmentIds[$index]);
                    if ($equipments[$index] == 0) {
                        $labEquipment->destroy($labEquipment->id);
                    } else {
                        $labEquipment->restore();
                    }
                }
            }

            return response()->json(['message' => 'User Account updated successfully'], 200);
        }
        return response()->json(['message' => 'Error updating user Account'], 400);
    }
}
