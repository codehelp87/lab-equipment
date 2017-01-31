<?php

namespace LabEquipment\Console\Commands;

use Illuminate\Console\Command;
use LabEquipment\Booking;

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
    protected $description = 'Command description';

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
        $bookings = Booking::where('status', 1)
            ->where('time_slot_id', '!=', NULL)
            ->where('time_slot', '!=', NULL)
            ->orderBy('id', 'desc')
            ->get();

        if ($bookings->count() > 0) {
            print 'I\'m a PHP Dev';
        }
        //
    }
}
