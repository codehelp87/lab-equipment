<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use LabEquipment\Booking;
use LabEquipment\Equipment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
	public function cancelBooking(Request $request, $id)
	{
		$booking = Booking::findOneById($id);

		if ($booking->count() > 0) {
			$booking->status = 0;
			$booking->time_slot = null;
			$booking->time_slot_id = null;
			$booking->save();

			return response()->json($booking, 200);
		}

		return response()->json([
			'message' => 'Booking not found'
		], 404);
	}

	public function addBooking(Request $request)
	{
		$totalEquipmentBooking = 0;

		$user = Auth::user();
		$equipment = Equipment::findOneById($request->equipment);
		$bookings = Booking::where('equipment_id', $request->equipment)->get();

		$timeSlot = $request->time_slot_id;
		$timeZone = $request->timezone;
		//Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString(); 
		$date = new \DateTime($request->booking_date);

		if ($bookings->count() > 0) {
			foreach($bookings as $booking) {
				$totalEquipmentBooking +=  (int) (count($booking->time_slot) * 10);
			}
		}

		if ($equipment->count() > 0) {
			$maxTimeInMinutes = (int) ($equipment->max_reservation_time * 60);

			if ($timeZone == 'daytime') {
				if ($maxTimeInMinutes == $totalEquipmentBooking) {
					return response()->json([
						'message' => 'Maximum number booking exceeded for this Equipment'
					], 400);
				}
			}

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
		}

		return response()->json(['message' => 'Error creating booking'], 400);
	}
}
