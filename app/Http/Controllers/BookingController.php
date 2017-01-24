<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use LabEquipment\Booking;

class BookingController extends Controller
{
	public function addBooking(Request $request)
	{
		$user = Auth::user();

		$date = new \DateTime($request->booking_date);
		$booking = Booking::create([
			'user_id' => $user->id,
			'equipment_id' => $request->equipment,
			'time_slot' => $request->time_slot,
			'booking_date' => date_format($date, 'Y-m-d H:i:s'),
		]);

		if (count($booking) > 0) {
			return response()->json($booking, 200);
		}

		return response()->json(['message' => 'Error creating booking'], 400);
	}
}
