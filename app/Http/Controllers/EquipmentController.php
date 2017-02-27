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
                    ->where('cancelled_time_slot', '!=', NULL)
                    ->whereBetween('booking_date', array($dt, $monthEnd))
                    ->get();

                $nightBookingSlot = 0;
                $dayBookingSlot = 0;

                if ($userbookings->count() > 0 ) {
                    foreach($userbookings as $index => $booking) {
                        if ($booking->timezone_flag == 'daytime') {
                            $dayBookingSlot += count($booking->cancelled_time_slot) * 10;
                        } else {
                            $nightBookingSlot += count($booking->cancelled_time_slot) * 10;
                        }
                    }

                    $userbookings = null;

                    array_push($response, [
                        'name' => $user->name,
                        'total_daytime_booked' => $dayBookingSlot,
                        'total_nighttime_booked' => $nightBookingSlot,
                    ]);
                }
                $dayBookingSlot = 0;// set slot back to 0
                $nightBookingSlot = 0;
            }

            return response()->json([$labEquipment, $response], 200);
        }
    }

    public function getLabUsers(Request $request, $id, $labUser)
    {
        $users = [];
        $response = [];

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
                    ->get();

                $nightBookingSlot = 0;
                $dayBookingSlot = 0;

                if ($userbookings->count() > 0 ) {
                    foreach($userbookings as $index => $booking) {
                        if ($booking->timezone_flag == 'daytime') {
                            $dayBookingSlot += count($booking->cancelled_time_slot) * 10;
                        } else {
                            $nightBookingSlot += count($booking->cancelled_time_slot) * 10;
                        }
                    }

                    $userbookings = null;
                    array_push($response, [
                        'name' => $user->name,
                        'total_daytime_booked' => $dayBookingSlot,
                        'total_nighttime_booked' => $nightBookingSlot,
                    ]);
                }
                
                $dayBookingSlot = 0;// set slot back to 0
                $nightBookingSlot = 0;
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
                        ->where('cancelled_time_slot', '!=', NULL)
                        ->get();

                    array_push($dayBooking, $this->calculateBooking($bookings));
                }
            }
        }

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

            $monthEnd = date('Y-m-d', strtotime($session. '+'.($days - 1).'days'));

            $dayTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('status', '>=', 1)
                ->where('cancelled_time_slot', '!=', NULL)
                ->whereBetween('booking_date', array($dt, $monthEnd))
                ->get();

            //get distinct day bookings
                $collection = collect($dayTimeBookings);
                $unique = $collection->unique('lab_id');
                $unique->values()->all();
                $dayTimeBookings = $unique->values()->all();

            if (count($dayTimeBookings) > 0) {
                foreach($dayTimeBookings as $booking) {
                    $bookings = Booking::orderBy('id', 'desc')
                        ->where('lab_id', $booking->lab_id)
                        ->where('status', '>=', 1)
                        ->where('cancelled_time_slot', '!=', NULL)
                        ->get();

                    array_push($dayBooking, $this->calculateBooking($bookings));
                }
            }
        }

        return response()->json($dayBooking);
    }

    public function TrainingUsers(Request $request, $id)
    {
        $students = [];
        $equipment = Equipment::FindOneById($id);

        if (count($equipment) > 0) {
            $user =  User::findOneAdminById($equipment->user_id);
            $labProfessor = $user->name;

            $trainings = Training::where('equipment_id', $equipment->id)
                ->orderBy('id', 'DESC')
                ->distinct()
                ->get();

            if (count($trainings) > 0) {
                foreach($trainings as $index => $training) {
                    $student = User::findOneByIdWithRole($training->user_id);
                    if ($student->count() > 0) {
                        $students[$index] = $student->toArray();
                        $students[$index]['lab_prof'] = $training->lab->title;

                        $students[$index]['action'] = '<input type="checkbox" class="form-control training-requester" data-name=' . urlencode($training->user->name) . ' id="training-requester" value=' . $training->user->id . '>';

                        $completedTrainingRequest = $this->getCompletedTrainingRequest(
                            $equipment->id, $training->user->id
                        );
                        if (!is_null($completedTrainingRequest)) {
                            $students[$index]['accepted'] = true;
                        } else {
                            $students[$index]['accepted'] = false;
                        }

                        $completedTrainingRequest = null;
                    }
                }
            }

            //$sortedStudents = $this->array_sort($students, 'accepted', $order = SORT_DESC);
            $totalStudents = count($students);

            return response()->json(['draw' => 5, 'recordsTotal' => $totalStudents, 'recordsFiltered' => $totalStudents,  'data'  => $students], 200);
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
                ->orderBy('id', 'DESC')
                ->distinct()
                ->get();

            if (count($bookings) > 0) {
                foreach($bookings as $index => $booking) {
                    $students[$index] = $booking->user->toArray();
                    $students[$index]['lab_prof'] = $booking->lab->title;

                    $students[$index]['action'] = '<input type="checkbox" class="form-control training-requester" data-name=' . urlencode($booking->user->name) . ' id="training-requester" value=' . $booking->user->id . '>';

                    $acceptedTrainingRequest = $this->getAcceptedTrainingRequest(
                        $equipment->id, $booking->user->id
                    );
                    if (!is_null($acceptedTrainingRequest)) {
                        $students[$index]['accepted'] = true;
                    } else {
                        $students[$index]['accepted'] = false;
                    }
                    $acceptedTrainingRequest = null;
                }
            }

            //$sortedStudents = $this->array_sort($students, 'accepted', $order = SORT_DESC);
            
            $totalStudents = count($students);
            return response()->json(['draw' => 5, 'recordsTotal' => $totalStudents, 'recordsFiltered' => $totalStudents,  'data'  => $students], 200);
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
        $days = date('t', mktime(0, 0, 0, $explodeDate[1], 1, $explodeDate[0])); 

        return $days;
    }

    protected function calculateBooking($bookings)
    {
        // Day booking
        $totalHourByDay = 0;
        $totalDayCharge = 0;

        //Night booking
        $totalHourByNight = 0;
        $totalNightCharge = 0;

        foreach($bookings as $book) {
            $dayTimeBookingProf = $book->lab->title;
            $dayTimeBookingProfId = $book->lab->id;
            if ($book->timezone_flag == 'daytime') {
                $totalHourByDay += (int) (count($book->cancelled_time_slot) * 10);
                $totalDayCharge += (int) (($book->equipment->price_per_unit_time / 10) * 10);
                $equipmentId = $book->equipment_id;
            } else {
                $totalHourByNight += (int) (count($book->cancelled_time_slot) * 10);
                $totalNightCharge += (int) (($book->equipment->price_per_unit_time / 10) * 10);
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

    protected function getAcceptedTrainingRequest($equipmentId, $userId)
    {
        $acceptedTrainingRequests = Training::where('status', 0)
            ->where('equipment_id', $equipmentId)
            ->where('user_id', $userId)
            ->first();

        return $acceptedTrainingRequests;
    }

    protected function getCompletedTrainingRequest($equipmentId, $userId)
    {
        $completedTrainingRequests = Training::where('status', 1)
            ->where('equipment_id', $equipmentId)
            ->where('user_id', $userId)
            ->first();

        return $completedTrainingRequests;
    }

    protected function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}
