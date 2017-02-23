<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Cloudder;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\LabUser;
use Carbon\Carbon;
use LabEquipment\Equipment;
use LabEquipment\Booking;
use LabEquipment\Training;
use Illuminate\Http\Request;

class EquipmentController extends Controller 
{
    public function deleteEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if ($equipment->count() > 0) {
            $equipment->status = 0;
            $equipment->forceDelete();

            return response()->json(['message' => 'deleted']);
        }
        return response()->json(['message' => 'Error deleting equipment']);
    }

    public function getLabUsersBySession(Request $request, $id)
    {
       $users = [];
       $response = [];
       $bookingMode = is_null($request->get('mode'))? 'daytime': 'nighttime';

       $labUser = $request->prof;
       $session = $request->session;

       $equipmentBookings = Booking::findOneByEquipmentUser($id,  $labUser);

        if ($equipmentBookings->count() > 0) {
            foreach($equipmentBookings as $index => $booking) {
                $users[$index] = $booking->user_id;
            }

            $equipmentAmount = (int) ($booking->equipment->price_per_unit_time);
            $labEquipment = [
                'lab_prof' => Lab::findOneById($labUser)->title, 
                'equipment_amount' => $equipmentAmount
            ];
            $uniqueUsers = array_unique($users); // get the unique user_id

            $dt = new \DateTime($session);
            $days = $this->getMonthDays($session);
            $monthEnd = date('Y-m-d h:i:s', strtotime($session. '+'.($days - 1).'days'));

            foreach ($uniqueUsers as $userId) {
                $user = User::findOneById($userId);
                $userbookings = Booking::where('user_id', $user->id)
                    ->where('status', '>=', 1)
                    ->where('equipment_id', $id)
                    ->where('timezone_flag', '=', trim($bookingMode))
                    ->where('cancelled_time_slot', '!=', NULL)
                    ->whereBetween('booking_date', array($dt, $monthEnd))
                    ->get();

                $sumSlot = 0;

                if ($userbookings->count() > 0 ) {
                    foreach($userbookings as $index => $booking) {
                        $sumSlot += count($booking->cancelled_time_slot) * 10;
                    }

                    $userbookings = null;

                    array_push($response, [
                        'name' => $user->name,
                        'total_time_booked' => $sumSlot,
                    ]);
                }
                $sumSlot = 0;// set slot back to 0
            }

            return response()->json([$labEquipment, $response], 200);
        }
    }

    public function getEquipmentLabUsage(Request $request, $id)
    {
        $equipment = Equipment::findOneById($id);

        $nightBooking = [];
        $dayBooking = [];

        if ($equipment->count() > 0) {
            $totalCharge = (int) ($equipment->price_per_unit_time);
            //get daytime bookings
            $dayTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('cancelled_time_slot', '!=', NULL)
                ->where('status', '>=', 1)
                //->whereIn('timezone_flag', ['daytime', 'nighttime'])
                ->get();

            // get distinct day bookings
                $collection = collect($dayTimeBookings);
                $unique = $collection->unique('lab_id');
                $unique->values()->all();
                $dayTimeBookings = $unique->values()->all();

            if (count($dayTimeBookings) > 0) {
                foreach($dayTimeBookings as $booking) {
                    $bookings = Booking::orderBy('id', 'desc')
                        ->where('lab_id', $booking->lab_id)
                        ->where('status', '>=', 1)
                        //->where('timezone_flag', 'daytime')
                        ->where('cancelled_time_slot', '!=', NULL)
                        ->get();

                    array_push($dayBooking, $this->calculateDayBooking($bookings));
                }
            }

            //get nighttime bookings
            // $nightTimeBookings = Booking::orderBy('id', 'desc')
            //     ->where('equipment_id', $equipment->id)
            //     ->where('cancelled_time_slot', '!=', NULL)
            //     ->where('status', '>=', 1)
            //     ->where('timezone_flag', 'nighttime')
            //     ->get();

            // // get distinct night bookings
            //     $collection = collect($nightTimeBookings);
            //     $unique = $collection->unique('lab_id');
            //     $unique->values()->all();
            //     $nightTimeBookings = $unique->values()->all();

            // if (count($nightTimeBookings) > 0) {
            //     foreach ($nightTimeBookings as $booking) {
            //        $bookings = Booking::orderBy('id', 'desc')
            //             ->where('lab_id', $booking->lab_id)
            //             ->where('status', '>=', 1)
            //             ->where('timezone_flag', 'nighttime')
            //             ->where('cancelled_time_slot', '!=', NULL)
            //             ->get();

            //         array_push($nightBooking, $this->calculateNightBooking($bookings));
            //     }
            // }
        }

        // dump($dayBooking); exit;

        //$newArray = $this->mergeMultiArray($dayBooking, $nightBooking);

        return response()->json($dayBooking);
    }

    public function getLabUsersBySessionAndEquipment(Request $request, $id) 
    {
        $equipment = Equipment::findOneById($id);
        $session = $request->session;

        $nightBooking = [];
        $dayBooking = [];

        if ($equipment->count() > 0) {
            $totalCharge = (int) ($equipment->price_per_unit_time);
            //get daytime bookings
            $dt = new \DateTime($session);

            $days = $this->getMonthDays($session);

            $monthEnd = date('Y-m-d h:i:s', strtotime($session. '+'.($days - 1).'days'));

            $dayTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('status', '>=', 1)
                ->where('timezone_flag', 'daytime')
                ->where('cancelled_time_slot', '!=', NULL)
                ->whereBetween('booking_date', array($dt, $monthEnd))
                ->get();


            // get distinct day bookings
                $collection = collect($dayTimeBookings);
                $unique = $collection->unique('lab_id');
                $unique->values()->all();
                $dayTimeBookings = $unique->values()->all();

            if (count($dayTimeBookings) > 0) {
                foreach($dayTimeBookings as $booking) {
                    $bookings = Booking::orderBy('id', 'desc')
                        ->where('lab_id', $booking->lab_id)
                        ->where('status', '>=', 1)
                        ->where('timezone_flag', 'daytime')
                        ->where('cancelled_time_slot', '!=', NULL)
                        ->get();

                    array_push($dayBooking, $this->calculateDayBooking($bookings));
                }
            }

            //get nighttime bookings
            $nightTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('status', '>=', 1)
                ->where('timezone_flag', 'nighttime')
                ->where('cancelled_time_slot', '!=', NULL)
                ->whereBetween('booking_date', array($dt, $monthEnd))
                ->get();

                // get distinct night bookings
                $collection = collect($nightTimeBookings);
                $unique = $collection->unique('lab_id');
                $unique->values()->all();
                $nightTimeBookings = $unique->values()->all();

            if (count($nightTimeBookings) > 0) {
                foreach ($nightTimeBookings as $booking) {
                    $bookings = Booking::orderBy('id', 'desc')
                        ->where('lab_id', $booking->lab_id)
                        ->where('status', '>=', 1)
                        ->where('timezone_flag', 'nighttime')
                        ->where('cancelled_time_slot', '!=', NULL)
                        ->get();

                    array_push($nightBooking, $this->calculateNightBooking($bookings));
                }
            }
        }

         $newArray = $this->mergeMultiArray($dayBooking, $nightBooking);

        return response()->json($newArray);
    }

    public function getLabUsers(Request $request, $id, $labUser)
    {
        $users = [];
        $response = [];

        $bookingMode = is_null($request->get('mode'))? 'daytime': 'nighttime';

        $equipmentBookings = Booking::findOneByEquipmentUser($id, $labUser);

        if ($equipmentBookings->count() > 0) {
            foreach($equipmentBookings as $index => $booking) {
                $users[$index] = $booking->user_id;
            }

            $equipmentAmount = (int) ($booking->equipment->price_per_unit_time);
            $labEquipment = [
                'lab_prof' => Lab::findOneById($labUser)->title,
                'equipment_amount' => $equipmentAmount
            ];
            $uniqueUsers = array_unique($users); // get the unique user_id

            foreach ($uniqueUsers as $userId) {
                $user = User::findOneById($userId);
                $userbookings = Booking::where('user_id', $user->id)
                    ->where('status', '>=', 1)
                    ->where('equipment_id', $id)
                    ->where('timezone_flag','=', trim($bookingMode))
                    ->get();

                $sumSlot = 0;

                if ($userbookings->count() > 0 ) {
                    foreach($userbookings as $index => $booking) {
                        $sumSlot += count($booking->cancelled_time_slot) * 10;
                    }

                    array_push($response, [
                        'name' => $user->name,
                        'total_time_booked' => $sumSlot,
                        //'lab_prof' => $userbookings[$index]->lab->title,
                    ]);
                }
                $userbookings = null;
                $sumSlot = 0;// set slot back to 0
            }

            return response()->json([$labEquipment, $response], 200);
        }
    }

    public function TrainingUsers(Request $request, $id)
    {
        $students = [];
        $equipment = Equipment::FindOneById($id);

        if (count($equipment) > 0) {
            $user =  User::findOneAdminById($equipment->user_id);
            $labProfessor = $user->name;

            $trainings = Training::where('equipment_id', $equipment->id)
                ->distinct()
                ->get();

            if (count($trainings) > 0) {
                foreach($trainings as $index => $training) {
                    $student = User::findOneByIdWithRole($training->user_id);
                    if ($student->count() > 0) {
                        $students[$index] = $student;
                        $students[$index]['lab_prof'] = $training->lab->title;
                    }
                }
            }
            return response()->json([$labProfessor, $students], 200);
        }

        return response()->json([
            'message' => 'No students available for training under this equipment',
        ]);
    }

    public function EquipmentUsers(Request $request, $id)
    {
        $students = [];
        $equipment = Equipment::FindOneById($id);

        if (count($equipment) > 0) {
            $user =  User::FindOneById($equipment->user_id);
            $labProfessor = $user->name;

            $bookings = Booking::where('status', 1)
                ->where('timezone_flag', NULL)
                ->where('equipment_id', $equipment->id)
                ->distinct()
                ->get();

            if (count($bookings) > 0) {
                foreach($bookings as $index => $booking) {
                    $students[$index] = $booking->user;
                    $students[$index]['lab_prof'] = $booking->lab->title;
                }
            }
            return response()->json([$labProfessor, $students], 200);
        }

        return response()->json([
            'message' => 'No requesters for this equipment',
        ]);

    }

    public function validateDate($date) 
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);

        return $d && $d->format('Y-m-d') === $date;
    }

    public function bookEquipment(Request $request, $id)
    {
        $bookingDate = $request->query->get('date');

        if ($bookingDate != '' && !$this->validateDate($bookingDate)) {
            abort(404, 'Invalid date format');
        }

        $date = new \DateTime($bookingDate);
        $bookingDate = date_format($date, 'Y-m-d');

        $decodedId = base64_decode($id);
        $equipment = Equipment::find($decodedId);
        $equipmentBookings = Booking::findBy([
            ['equipment_id', '=', $decodedId],
            //['booking_date', '=', $bookingDate],
            ['status', '=', 1],
        ]);

        if (count($equipment) > 0) {
            return view('student.book_equipment', 
                compact('equipment', 'equipmentBookings')
            );
        }
        abort(404);
    }

    public function createEquipment(Request $request)
    {
        $equipment = Equipment::create([
            'title' => $request->title,
            'model_no' => $request->model_no,
            'maker' => $request->maker,
            'time_unit' => $request->time_unit,
            'max_reservation_time' => $request->reservation_time,
            'price_per_unit_time' => $request->price_per_unit,
            'availability' => $request->availability,
            'equipment_photo' => $this->handleCloudinaryFileUpload($request),
            'user_id' => Auth::user()->id,
        ]);

        if (count($equipment) > 0) {
            return response()->json([
                'message' => 'Equipment was created successfully',
                'equipment' => $equipment,
            ]);
        }

        return response()->json([
            'message' => 'Error creating Lab'
        ]);
    }

    public function updateEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if (count($equipment) > 0) {
            $equipment->title = $request->title;
            $equipment->model_no = $request->model_no;
            $equipment->maker = $request->maker;
            $equipment->time_unit = $request->time_unit;
            $equipment->max_reservation_time = $request->reservation_time;
            $equipment->price_per_unit_time = $request->price_per_unit;
            $equipment->availability = $request->availability;
            if (!is_null($request->file('photo'))) {
                $equipment->equipment_photo = $this->handleCloudinaryFileUpload($request);
            }
        }

        $equipment->save();

        if (count($equipment) > 0) {
            return response()->json([
                'message' => 'Equipment was updated successfully',
                'equipment' => $equipment,
            ]);
        }

        return response()->json([
            'message' => 'Error creating Equipment'
        ]);
    }

    public function editEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);
        $labs = Lab::findAll();

        if (count($equipment) > 0) {
            return view('admin.manage_equipment.edit_equipment', 
                compact('equipment', 'labs')
            );
        }

        abort(404);
    }

    /**
     * This method upload image to cloudinary.
     *
     * @param $request
     *
     * @return picture url
     */
    public function handleCloudinaryFileUpload($request)
    {
        $avatar = $request->file('photo');
        $avatar = Cloudder::upload($avatar, null, [
            'format' => 'jpg',
            'crop'   => 'fill',
            'width'  => 250,
            'height' => 250,
        ]);

        return  Cloudder::getResult()['url'];
    }

    public function getMonthDays($date)
    {
        $explodeDate = explode('-', $date);
        //$days = cal_days_in_month(CAL_GREGORIAN, $explodeDate[1], $explodeDate[0]);
        $days = date('t', mktime(0, 0, 0, $explodeDate[1], 1, $explodeDate[0])); 

        return $days;
    }

    protected function calculateNightBooking($bookings)
    {
        $totalHourByNight = 0;
        $totalNightCharge = 0;

        foreach($bookings as $book) {
            $totalHourByNight += (int) (count($book->cancelled_time_slot) * 10);
            $totalNightCharge += (int) (($book->equipment->price_per_unit_time / 10) * 10);
            $nightTimeBookingProf = $book->lab->title;
            $nightTimeBookingProfId = $book->lab->id;
            $equipmentId = $book->equipment_id;
        }

        return [
            'night_equipment_id' => $equipmentId,
            'night_lab_prof' => $nightTimeBookingProf,
            'night_lab_prof_id' => $nightTimeBookingProfId,
            'total_charge_by_night' => $totalNightCharge,
            'total_hour_by_night' => ($totalHourByNight / 60),
        ];
    }

    protected function calculateDayBooking($bookings)
    {
        // Day booking
        $totalHourByDay = 0;
        $totalDayCharge = 0;

        //Night booking
        $totalHourByNight = 0;
        $totalNightCharge = 0;

        foreach($bookings as $book) {
            //echo $book->timezone_flag . "\n";
            if ($book->timezone_flag == 'daytime') {
                $totalHourByDay += (int) (count($book->cancelled_time_slot) * 10);
                $totalDayCharge += (int) (($book->equipment->price_per_unit_time / 10) * 10);
                $dayTimeBookingProf = $book->lab->title;
                $dayTimeBookingProfId = $book->lab->id;
                $equipmentId = $book->equipment_id;
            } else {
                $totalHourByNight += (int) (count($book->cancelled_time_slot) * 10);
                $totalNightCharge += (int) (($book->equipment->price_per_unit_time / 10) * 10);
                $nightTimeBookingProf = $book->lab->title;
                $nightTimeBookingProfId = $book->lab->id;
                $equipmentId = $book->equipment_id;
            }
        }

        return [
            'day_equipment_id' => $equipmentId,
            'day_lab_prof' => @$dayTimeBookingProf ,
            'day_lab_prof_id' => @$dayTimeBookingProfId,
            'total_charge_by_day' => $totalDayCharge,
            'total_hour_by_day' => ($totalHourByDay / 60),
            'night_equipment_id' => $equipmentId,
            'night_lab_prof' => @$nightTimeBookingProf,
            'night_lab_prof_id' => @$nightTimeBookingProfId,
            'total_charge_by_night' => $totalNightCharge,
            'total_hour_by_night' => ($totalHourByNight / 60),
        ];
    }

    protected function mergeMultiArray($dayBooking, $nightBooking)
    {
        $i = 0;
        $newArray = [];

        if (count($dayBooking) > 0 || count($nightBooking) > 0) {
            if (count($dayBooking) > count($nightBooking)) {
                foreach($dayBooking as $key => $booking) {
                    //if (is_array($booking) && is_array(@$nightBooking[$i])) {
                        //print_r($dayBooking); print_r($nightBooking); exit;
                        if (count($booking) > 0 && count(@$nightBooking[$i]) > 0) {
                            $newArray[] = array_merge(@$booking, @$nightBooking[$i]);
                        } else {
                            $newArray[] = @$booking;
                        }
                    //}
                    $i++;
                }
            } else {
                foreach($nightBooking as $key => $booking) {
                    //if (is_array($booking) && is_array(@$dayBooking[$i])) {
                        if (count($booking) > 0 && count(@$dayBooking[$i]) > 0) {
                            $newArray[] = array_merge(@$booking, @$dayBooking[$i]);
                        } else {
                            $newArray[] = @$booking;
                        }
                    //}
                    $i++;
                }
            }
        }

        return $newArray;
    }
}
