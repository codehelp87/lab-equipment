<?php

namespace LabEquipment\Http\Controllers;

use LabEquipment\User;
use Illuminate\Http\Request;
use LabEquipment\Notification;
use LabEquipment\NotifiedUser;

class NotificationController extends Controller
{
	public function editNotification(Request $request, $id)
    {
        $notification = Notification::find($id);
 
        if (count($notification) > 0) {
            return view('admin.notification.edit_notification', 
                compact('notification')
            );
        }

        abort(404);
    }

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

	public function updateNotification(Request $request, $id)
	{
		$notification = Notification::find($id);

		if ($notification->count() > 0) {
			$notification->title = $request->title;
			$notification->content = $request->content;
			$notification->save();

			return response()->json([
                'message' => 'Notification was updated successfully',
                'notification' => $notification,
            ], 200);
		}

		return response()->json(['message' => 'Notication cannot be updated'], 400);
	}
}
