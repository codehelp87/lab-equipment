<?php

namespace LabEquipment\Console\Commands;

use LabEquipment\Booking;
use Illuminate\Console\Command;
use Carbon\Carbon;

class BookingChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This checks booking time and make the them as completed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current = Carbon::now();
        $bookings = Booking::where('status', 1)
            ->where('time_slot_id', '!=', NULL)
            ->where('time_slot', '!=', NULL)
            ->orderBy('id', 'desc')
            ->get();

        if ($bookings->count() > 0) {
            foreach($bookings as $booking) {
                $bookingDate = $booking->booking_date;
                $timeSlot = $booking->time_slot;

                $getTime = $this->getHourAndMinutes($timeSlot);
                $getBookingDate = explode('-', $bookingDate);

                $dt = new \DateTime($booking->booking_date);
                $carbon = Carbon::instance($dt);
                $carbon->hour = (int) $getTime[0];
                $carbon->minute = (int) $getTime[1];
                $carbon->second = rand(10, 50);

                $diffInMinutes = $carbon->diffInMinutes($current);

                $diffInMinutes = (int) ($diffInMinutes - 60);

                if ($diffInMinutes <= 0) {
                    $booking->status = 2;
                    $booking->time_slot = null;
                    $booking->time_slot_id = null;
                    $booking->save();
                    print 'Completed'.$carbon.' # '.$diffInMinutes."\n";
                } else {
                    print 'Uncompleted'.$carbon.' # '.$diffInMinutes."\n";
                }
                 $diffInMinutes = 0;
            }
        }
    }

    public function getHourAndMinutes($time)
    {
        $splitTime = explode('-', $time[0]);
        $getHourAndMinutes = explode(':', $splitTime[1]);

        return $getHourAndMinutes;
    }
}
