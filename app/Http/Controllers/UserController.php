<?php

namespace LabEquipment\Http\Controllers;

use Auth;
//use Grimthorr\LaravelToast\Toast;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\Equipment;
use LabEquipment\Booking;
use LabEquipment\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function confirmTrainingRequest(Request $request)
    {
        $training = null;
        $students = $request->students;

        if (count($students) > 0) {
            foreach($students as $student) {
                $training = Training::create([
                    'user_id' => $student,
                    'date_of_training_session' => $request->booking_date,
                    'location' => $request->location,
                ]);

                $booking = Booking::findOneByStudent($student);
                $booking->destroy($booking->id);

                // Send confirmation email
                $user = User::findOneById($student);
                // send email
                $data = [
                    'name' => $user->name,
                    'email' => $user->email, 
                    'date' => $request->session,
                    'location' => $request->location,
                ];
                $this->sendEmail($data, $user->email);
            }
            
            // marked them as completedly left booking
            if (!is_null($training)) {
                return response()->json($training, 200);
            }

            return response()->json(['message' => 'Error creating training'], 400);
        }
    }

    public function createTrainingRequest(Request $request)
    {
        // // Allow maximum of 5 students per training request
        // $bookings = Booking::where('booking_date', $request->session)->get();

        // if (count($bookings) < 5) {
        // 
        // Check for password
        $newPassword =  $request->new_password;
        $confirmPassword = $request->com_password;

        if ($newPassword !== $confirmPassword) {
            return redirect()
                ->back()
                ->with('message', 'Password mismatched');
        }

        $user = User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Hash::make($request->newPassword),
        ]);

        //Block the account after signup
        //$user->destroy($user->id);

        if (count($user) > 0) {
            $booking = Booking::create([
                'user_id' => $user->id,
                'equipment_id' => $request->equipment,
                'time_slot' => 'nil',
                'booking_date' => $request->session,
                'session' => $request->session
            ]);
        }

        return redirect()->route('training_request_confirmation');
    // }

    }

    protected function sendEmail($data, $email)
    {
        Mail::send('student.email', $data, function ($message) use ($email) {
            $message->from('lab-equipment@domain.com', 'Confirmation Email');
            $message->to($email)->subject('Confirmation Email');
        });
    }

    public function requestForm()
    {
        $labs = Lab::findAll();
        return view('student.request_training', compact('labs'));
    }

    public function changePassword(Request $request, $email)
    {
        $user = User::findOneByEmail($email);
        $oldPassword = $request->c_password;
        $newPassword = $request->new_password;

        if (count($user) > 0) {
            if (\Hash::check($oldPassword, $user->getAuthPassword())) {
                $user->password = bcrypt($newPassword);
                $user->save();
            }

            return response()->json([
                'message' => 'Your password has been updated successfully'
            ]);
        }

        return response()->json(['message' => 'Error updating password']);
    }

    public function viewMyProfile()
    {
        $equipments = Equipment::findAll();
        $bookings =  $this->showMyBookingHistory();

        return view('student.my_profile', compact('equipments', 'bookings'));
    }

    protected function showMyBookingHistory()
    {
        $user = Auth::user();

        return Booking::findOneByEquipment($user->id);
    }

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

    public function gettUserStatus(Request $request, $status)
    {
        if ($status == 0) {
            $users = User::onlyTrashed()->get();
            if ($users->count() > 0) {
                return response()->json($users, 200);
            }
        } else {
            $users = User::FindAll();
            if ($users->count() > 0) {
                return response()->json($users, 200);
            }
        }

        return response()->json(['message' => 'Users not found'], 404);
    }
}
