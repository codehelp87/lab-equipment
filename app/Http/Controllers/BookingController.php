<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Carbon\Carbon;
use LabEquipment\Booking;
use LabEquipment\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BookingController extends Controller
{
	const NIGHT_BOOKING = 72;
	const MORNING_BOOKING = 72;
	const MAX_NIGHT_TO_DAY_MIN = 143;
	const NIGHT_TO_DAY_MIN = 72; // 72 to 143

	use \LabEquipment\Http\Controllers\CurrentDateTrait;

	public function checkEquipmentBooking(Request $request)
	{
		//call the check booking
		Artisan::call('booking:check', []);

		return response()->json(['message' => 'done'], 200);
	}

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
		$current = $this->getNow();

		$totalEquipmentBooking = 0;
		$timezoneFlag = 'nighttime';

		$equipment = Equipment::findOneById($request->equipment);

		$bookings = Booking::where('equipment_id', $request->equipment)
		    ->where('time_slot_id', '!=', NULL)
		    ->where('timezone_flag', 'daytime') // newly added
		    ->get();

		$timeSlot = $request->time_slot_id;
		$date = new \DateTime($request->booking_date);

		if ($bookings->count() > 0) {
			foreach($bookings as $booking) {
				$totalEquipmentBooking += (int) (count($booking->cancelled_time_slot) * 10);
			}
		}

		if ($equipment->count() > 0) {
			$maxTimeInMinutes = (int) ($equipment->max_reservation_time * 60);
			if ($maxTimeInMinutes == $totalEquipmentBooking) {
				$maxTime = (int)($maxTimeInMinutes / 60);
				return response()->json([
					'message' => 'Maximum hour of ' .$maxTime. ' booking exceeded for this Equipment'
				], 400);
			}

            $timeSlotId = $request->time_slot_id;
            $timeSlot = $request->time_slot;

			foreach($request->time_slot as $index => $slot) {
				// if the student selects yesterday date and today's date but he'/he boking extends till tomorrow
	            // carbon should add one more day to the date selected
	            $currentTimezone = $current->timezoneName;

	            $bookingDate = Carbon::instance($date);
	            $bookingDate->timezone = $currentTimezone;
	            $getTime = $this->getHourAndMinutes($slot);

	            $bookingDate->hour = (int) $getTime[0];
                $bookingDate->minute = (int) $getTime[1];
                $bookingDate->second = rand(10, 30);
	            $diffInDays = $bookingDate->diffInDays($current);

	            $diffInHours = $bookingDate->diffInHours($current);

	            if (
	            	$timeSlotId[$index] >= static::NIGHT_TO_DAY_MIN && 
	            	$timeSlotId[$index] <= static::MAX_NIGHT_TO_DAY_MIN && 
	            	$diffInHours > 6) {
	            	$bDate = $bookingDate->addDays(1);
	            	$timezoneFlag = 'nighttime';
	            } elseif ($timeSlotId[$index] >= static::NIGHT_TO_DAY_MIN && 
	            	$timeSlotId[$index] <= static::MAX_NIGHT_TO_DAY_MIN && 
	            	$diffInHours <= 6) {
	            	$timezoneFlag = 'nighttime';
	            } else {
	            	$timezoneFlag = 'daytime';
	            }

	            //Switch date format
	            $bookingDate = date_format($bookingDate, 'Y-m-d');

				$booking = Booking::create([
					'user_id' => Auth::user()->id,
					'equipment_id' => $request->equipment,
					'time_slot' => [$timeSlot[$index]],
					'booking_date' => $bookingDate,
					'session' => $bookingDate,
					'time_slot_id' => [$timeSlotId[$index]],
					'timezone_flag' => $timezoneFlag,
					'cancelled_time_slot' => [$timeSlot[$index]],
				]);
			}

			$bookings = Booking::where('equipment_id', $request->equipment)
			    ->where('user_id', Auth::user()->id)
		        ->where('time_slot_id', '!=', NULL)
		        ->get();

			if (count($bookings) > 0) {
				return response()->json($bookings, 200);
			}
		}

		return response()->json(['message' => 'Error creating booking'], 400);
	}

	public function getHourAndMinutes($time)
    {
        $splitTime = explode('-', $time);
        $getHourAndMinutes = explode(':', $splitTime[0]);

        return $getHourAndMinutes;
    }
}
