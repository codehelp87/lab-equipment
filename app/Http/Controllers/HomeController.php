<?php

namespace LabEquipment\Http\Controllers;

use Auth;
use Carbon\Carbon;
use LabEquipment\Lab;
use LabEquipment\User;
use LabEquipment\Booking;
use LabEquipment\Training;
use LabEquipment\Equipment;
use LabEquipment\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exitCode = Artisan::call('booking:check', []);

        $userBookings = $this->showMyBookingHistory();

        $users = User::findAllWithTrashed();
        $labs = Lab::findAll();
        $equipments = Equipment::findAll();

        $notifications = Notification::findAll();

        $trainedEquipments = $this->getTrainedEquipments(Auth::user()->id);

        foreach($equipments as $equipment) {
            if (in_array($equipment->id, $trainedEquipments)) {
                // Check for last booking date
                $bookings = Booking::findTotalLabUsage($equipment->id, Auth::user()->id);
                $created = new Carbon(@$bookings[0]->created_at);

                $now = Carbon::now(new DateTimeZone('Africa/Lagos'));
                //$now = Carbon::now(new DateTimeZone('Asia/Seoul'));

                $difference = $created->diff($now)->days;

                if ($difference >= 90) {
                    // deactivate this equipment
                    $training = Training::where('user_id', Auth::user()->id)
                        ->where('equipment_id', $equipment->id)
                        ->first();
                    // Set the status to 0 to deactivate the equipment
                    $training->status = 0;
                    $training->save();
                }
                // End of last booking date
            }
        }

        $trainings = Training::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.admin', compact(
            'users', 'labs', 'equipments', 'userBookings', 'trainings', 'trainedEquipments', 'notifications'
        ));
    }

    protected function showMyBookingHistory()
    {
        return Booking::findOneByEquipment(Auth::user()->id);
    }

    public function getTrainedEquipments($userId)
    {
        $equipmentIds = [];
        $trainedEquipment = Training::getTrainedEquipments($userId);

        foreach ($trainedEquipment as $key => $tEquipment) {
           $equipmentIds[$key] = $tEquipment->equipment_id;
        }

        return $equipmentIds;
    }
}
