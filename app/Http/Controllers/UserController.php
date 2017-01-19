<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function editUserInfo(Request $request, $email)
    {
        $name = $request->name;
        $email = $email;
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
        $user = User::findOneById($userId);

        if (is_null($user)) {
            return response()->json(['message' => 'Account De-activated'], 200);
        }
        //return response()->json($user, 200);
        return view('admin.manage_user_account.update_user_account', 
            compact('user')
        );
    }
}
