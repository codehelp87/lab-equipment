<h5><strong>Upcoming Booking</strong> <span class="text-danger pull-right">Cancellation is allowed until 1hr. before your reservation</span></h5> <br>
<table class="table table-hover">
    <tbody>
        @foreach($bookings as $booking)
        <?php 
            $bookingDate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->booking_date);

            $selectedTimeSlot = $booking->time_slot;

            $lastTimeSelected = $selectedTimeSlot[count($selectedTimeSlot) - 1];
            $hourAndMinute = explode('-', $lastTimeSelected);
            $hm = explode(':', $hourAndMinute[0]);
            $bookingDate->addHours($hm[0]);
            $bookingDate->addMinutes($hm[1]);

            $lastBookingTime = $booking->created_at->diffInMinutes($bookingDate); 
            //dump(); exit; 11:10am - 11:20am 10:09am
        ?>
        <tr>
            <td><strong>{{ $booking->equipment->title }}</strong></td>
            <td>{{ $booking->equipment->model_no }}</td>
            <td>{{ date_format(new \DateTime($booking->booking_date), 'Y/m/d') }}</td>
            <td>@if ($booking->time_slot != null) {{ implode(' , ', $booking->time_slot) }}
            @endif </td>
            <td>
                @if ($lastBookingTime >= 60 && $booking->status == 1)
                <button type="button" class="btn btn-default pull-right cancel-booking inActiveBtn" id="{{ $booking->id }}" disabled="disabled"> Cancel</button>
                @endif
                @if($lastBookingTime < 60 && $booking->status == 1)
                <?php $bookingSlot = []; if (!is_null($booking->time_slot)) { $bookingSlot = $booking->time_slot ;} ?>
                <button type="button" class="btn btn-default pull-right cancel-booking" id="{{ $booking->id }}" data-time-slot="{{ implode(' , ', $bookingSlot) }}"> Cancel</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>