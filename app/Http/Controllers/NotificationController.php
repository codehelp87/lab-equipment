<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use Illuminate\Http\Request;
use LabEquipment\Notification;
use LabEquipment\NotifiedUser;

class NotificationController extends Controller
{
	public function addNotification(Request $request)
	{
		if ($request->has('title') && $request->has('content')) {
			$students = User::findAllStudents();

			$notification = Notification::create([
				'title' => $request->title,
				'content' => $request->content,
			]);

			if ($notification->count() > 0) {
				//Loop over the students and add notication to the
				//nofied user table
				foreach($students as $student) {
					NotifiedUser::create([
						'status' => 1,
						'user_id' => $student->id,
						'notification_id' => $notification->id
					]);
				}
				return response()->json(['notification' => $notification], 200);
			}

			return response()->json(['message' => 'Notication cannot be created'], 400);
		}
	}
}
