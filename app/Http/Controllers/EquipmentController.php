<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Cloudder;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\LabUser;
use LabEquipment\Equipment;
use LabEquipment\Booking;
use LabEquipment\Training;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function getLabUsers(Request $request, $id, $lab_user)
    {
        $users = [];
        $response = [];

        $bookings = Booking::findOneByEquipment($id);

        if ($bookings->count() > 0) {
            foreach($bookings as $index => $booking) {
                $users[$index] = $booking->user_id;
            }

            $equipmentAmount = (int) ($booking->equipment->max_reservation_time * 60);
            $labEquipment = ['lab_prof' => User::findOneById($lab_user)->name, 'equipment_amount' => $equipmentAmount];
            ///$equipmentPricePerUnitTime = (int) $booking->equipment->price_per_unit_time;
            $uniqueUsers = array_unique($users); // get the unique user_id

            foreach ($uniqueUsers as $user) {
                $user = User::findOneById($user);
                $userbookings = $user->bookings
                    ->where('status', 1)
                    ->where('equipment_id', $id);
                $sumSlot = 0;
                foreach($userbookings as $index => $booking) {
                    $sumSlot += count($booking->time_slot) * 10;
                }
                array_push($response, [
                    'name' => $user->name,
                    'total_time_booked' => $sumSlot,
                ]);

                $sumSlot = 0;// set slot back to 0
            }

            return response()->json([$labEquipment, $response], 200);
        }
    }

    public function getEquipmentLabUsage(Request $request, $id)
    {
        $equipment = Equipment::findOneById($id);

        $totalHourByDay = 0;
        $totalHourByNight = 0;

        if ($equipment->count() > 0) {
            //$equipmentPricePerUnitTime = $equipment->price_per_unit_time;
            $totalCharge = (int) ($equipment->max_reservation_time * 60);
            //get daytime bookings
            $dayTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('status', 1)
                ->where('timezone_flag', 'daytime')
                ->get();

            if ($dayTimeBookings->count() > 0) {
                foreach($dayTimeBookings as $booking) {
                    $totalHourByDay += (int) (count($booking->time_slot) * 10);
                }
            }

            //get nighttime bookings
            $nightTimeBookings = Booking::orderBy('id', 'desc')
                ->where('equipment_id', $equipment->id)
                ->where('status', 1)
                ->where('timezone_flag', 'nighttime')
                ->get();

            if ($nightTimeBookings->count() > 0) {
                foreach ($nightTimeBookings as $booking) {
                   $totalHourByNight += (int) (count($booking->time_slot) * 10);
                }
            }
        }

        return response()->json([
            'equipment_id' => $equipment->id,
            'lab_prof' => $equipment->user->name,
            'lab_prof_id' => $equipment->user->id,
            'total_charge_by_day' => ($totalCharge * $totalHourByDay),
            'total_charge_by_night' => ($totalCharge * $totalHourByNight),
            'total_hour_by_day' => ($totalHourByDay / 60),
            'total_hour_by_night' => ($totalHourByNight / 60),
        ]);
    }

    public function TrainingUsers(Request $request, $id)
    {
        $students = [];
        $equipment = Equipment::FindOneById($id);

        if (count($equipment) > 0) {
            $user =  User::FindOneById($equipment->user_id);
            $labProfessor = $user->name;

            $trainings = Training::where('equipment_id', $equipment->id)
            ->distinct()
            ->get();

            if (count($trainings) > 0) {
                foreach($trainings as $index => $training) {
                    $students[$index] = $training->user;
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

            $bookings = $equipment->bookings;
            if (count($bookings) > 0) {
                foreach($bookings as $index => $booking) {
                    $students[$index] = $booking->user;
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

        $equipment = Equipment::find($id);
        $equipmentBookings = Booking::findBy([
            ['equipment_id', '=', $id],
            ['booking_date', '=', $bookingDate]
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
            'lab_id' => $request->assign_lab,
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
            $equipment->lab_id = $request->assign_lab;
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
            'message' => 'Error creating Lab'
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
}
