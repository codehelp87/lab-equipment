<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use LabEquipment\Booking;

class BookingController extends Controller
{
	const DAY_TO_NIGHT_MAX = 89;
	const NIGHT_TO_DAY_MIN = 90;

	public function addBooking(Request $request)
	{
		$user = Auth::user();

		$date = new \DateTime($request->booking_date);
		$booking = Booking::create([
			'user_id' => $user->id,
			'equipment_id' => $request->equipment,
			'time_slot' => $request->time_slot,
			'booking_date' => date_format($date, 'Y-m-d H:i:s'),
			'session' => date_format($date, 'Y-m-d H:i:s'),
			'time_slot_id' => $request->time_slot_id
		]);

		if (count($booking) > 0) {
			return response()->json($booking, 200);
		}

		return response()->json(['message' => 'Error creating booking'], 400);
	}
}
