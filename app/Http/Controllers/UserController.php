<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function editUserInfo(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $office = $request->office;
        $phone = $requst->phone;
        $oldPassword = $request->c_password;
        $newPassword = $request->new_password;
        // use the email address to find the record
        $user = User::findOneByEmail($email);

        if (count($user) > 0) {
            if (Hash::check($oldPassword, $user->getAuthPassword())) {
                $user->name = $name;
                $user->email = $email;
                $user->office = $office;
                $user->phone = $phone;
                $user->password = $newPassword;
                $user->save();
            } 
            return response()->json(['message' => 'Record updated successfully']);
        }
        return response()->json(['message' => 'Error updating record']);
    }
}
