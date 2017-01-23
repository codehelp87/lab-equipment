<?php

namespace LabEquipment\Http\Controllers;

use Illuminate\Http\Request;
use LabEquipment\Booking;

class BookingController extends Controller
{
	public function addBooking(Request $request)
	{
		$user = Auth::user();

		$booking = Booking::create([
			'user_id' => $user,
			'equipment_id' => $request->equipment;
			'time_slot' => $request->time_slot,
			'booking_date' => $request->booking_date,
		]);
	}
}
