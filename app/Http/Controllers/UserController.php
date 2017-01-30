<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\LabUser;
use LabEquipment\Equipment;
use LabEquipment\Booking;
use LabEquipment\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function activateUserAccount(Request $request, $hash)
    {
        $email = base64_decode($request->hash);
        $user = User::findOneByEmail($email);

        if (count($user) > 0) {
            $user->status = 1;
            $user->save();
            Auth::login($user);
            return redirect() ->route('dashboard');
        }
        return redirect()->route('request_training');
    }

    public function completeTraining(Request $request)
    {
        $students = $request->students;
        $equipment = $request->equipment;
        $equipmentName = $request->equipment_name;

        // Update the booking
        if (count($students) > 0) {
            foreach($students as $student) {
                $training = Training::where('equipment_id', $equipment)
                    ->where('user_id', $student)
                    ->first();
                // Update user status
                $training->status = 1;
                $training->save();
                // Send confirmation email
                $user = User::findOneById($student);
                // send email
                $data = [
                    'name' => $user->name,
                    'email' => $user->email, 
                    'equipment' => $equipmentName,
                ];
                $this->sendTrainingCompletionEmail($data, $user->email);
            }
        }

        if (!is_null($training)) {
            return response()->json($training, 200);
        }

        return response()->json(['message' => 'Error completing request'], 400);
    }

    public function confirmTrainingRequest(Request $request)
    {
        $students = $request->students;

        if (count($students) > 0) {
            foreach($students as $student) {
                 // Send confirmation email
                $user = User::findOneById($student);
                $getTraining = Training::where('equipment_id', $request->equipment)
                   ->where('user_id', $user->id)
                   ->first();

                if (is_null($getTraining)) {
                    $training = Training::create([
                        'user_id' => $student,
                        'date_of_training_session' => $request->booking_date,
                        'location' => $request->location,
                        'equipment_id' => $request->equipment,
                    ]);
                }
                // send email
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'date' => $request->booking_date,
                    'location' => $request->location,
                ];
                $this->sendEmail($data, $user->email);
            }
            
            // marked them as completedly left booking
            return response()->json(['message' => 'successful'], 200);
        }
    }

    public function createTrainingRequest(Request $request)
    {
        // Check for password
        $newPassword =  $request->new_password;
        $confirmPassword = $request->com_password;

        if ($newPassword !== $confirmPassword) {
            return redirect()
                ->route('request_training')
                ->with('message', 'Password mismatched')
                ->withInput();
        }

        $user = User::findOneByEmail($request->email);

        if ($user instanceof User) {
            return redirect()
                ->route('request_training')
                ->with('message', 'Email already exists')
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($newPassword),
        ]);

        // lab user 
        $lab = Lab::findOneById($request->lab);

        if ($lab->count() > 0) {
            $labUser = LabUser::create([
                'user_id' => $user->id,
                'lab_id' => $lab->id,
            ]);
        }

        if (count($user) > 0) {
            $booking = Booking::create([
                'user_id' => $user->id,
                'equipment_id' => $request->equipment,
                'time_slot' => null,
                'booking_date' => $request->session,
                'session' => $request->session
            ]);
        }

        return redirect()->route('training_request_confirmation');
    }

    protected function sendEmail($data, $email)
    {
        Mail::send('student.email', $data, function ($message) use ($email) {
            $message->from('lab-equipment@domain.com', 'You have registered for equipment');
            $message->to($email)->subject('Training Request');
        });
    }

    protected function sendTrainingCompletionEmail($data, $email)
    {
        Mail::send('student.complete_training_email', $data, function ($message) use ($email) {
            $message->from('lab-equipment@domain.com', 'You have completed your Training');
            $message->to($email)->subject('Training Completion');
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
        $trainings = Training::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $bookings =  $this->showMyBookingHistory();

        return view('student.my_profile', compact('trainings', 'bookings'));
    }

    protected function showMyBookingHistory()
    {
        return Booking::findOneByEquipment(Auth::user()->id);
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
            //if (\Hash::check($oldPassword, $user->getAuthPassword())) {
                $user->name = $name;
                $user->email = $email;
                $user->office_location = $office;
                $user->phone = $phone;

                if ($newPassword != '') {
                    $user->password = bcrypt($newPassword);
                }
                
                $user->save();
            //} 
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

        return view('admin.manage_user_account.update_user_account', 
            compact('user')
        );
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $user = User::findOneById($userId);

        if (!is_null($user)) {
            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->office_location = $request->office;
            $user->student_id = $request->student_id;
            $user->role_id = $request->role;

            $status = $request->status == 0? 0: 1;
            $user->status = $status;
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

            return response()->json($user, 200);
        }
        return response()->json(['message' => 'Error updating user Account'], 400);
    }

    public function gettUserStatus(Request $request, $status)
    {
        if ($status == 0) {
            $users = User::where('status', 0)->get();
            if ($users->count() > 0) {
                return response()->json($users, 200);
            }
        } else {
            $users = User::where('status', 1)->get();
            if ($users->count() > 0) {
                return response()->json($users, 200);
            }
        }

        return response()->json(['message' => 'Users not found'], 404);
    }
}
