<h5><strong>Upcoming Booking</strong> <span class="text-danger" style="margin-left: 50px;">Cancellation is allowed until 1hr. before your reservation</span></h5> <br>
 <div class="table-responsive">
<table class="table table-hover table-responsive">
    <tbody>
        @foreach($bookings as $booking)
        <?php 
            //$current = Carbon\Carbon::now(new DateTimeZone('Africa/Lagos'));
            $current = Carbon\Carbon::now(new DateTimeZone('Asia/Seoul'));
            $selectedTimeSlot = $booking->time_slot;

            $lastTimeSelected = $selectedTimeSlot[count($selectedTimeSlot) - 1];
            $hourAndMinute = explode('-', $lastTimeSelected);
            $hm = explode(':', $hourAndMinute[0]);

            $dt = new \DateTime($booking->booking_date);
            $carbon = Carbon\Carbon::instance($dt);
            $carbon->hour = (int) $hm[0];
            $carbon->minute = (int) $hm[1];
            $carbon->second = rand(10, 50);

            $lastBookingTime = round((strtotime($carbon) - strtotime($current)) / 3600, 1);
            $minutes = ($lastBookingTime * 60);
        ?>
        <tr>
            <td><strong>{{ $booking->equipment->title }}</strong></td>
            <td>{{ $booking->equipment->model_no }}</td>
            <td>{{ date_format(new \DateTime($booking->booking_date), 'Y/m/d') }}</td>
            <td>@if ($booking->time_slot != null) {{ implode(' , ', $booking->time_slot) }}
            @endif </td>
            <td>
                @if ($minutes <= 60 && $booking->status == 1)
                <button type="button" class="btn btn-default pull-right cancel-booking inActiveBtn"  id="{{ $booking->id }}" disabled="disabled"> Cancel</button>
                @else
                <?php $bookingSlot = []; if (!is_null($booking->time_slot)) { $bookingSlot = $booking->time_slot; } ?>
                <button type="button" class="btn btn-default pull-right cancel-booking" id="{{ $booking->id }}" data-time-slot="{{ implode(' , ', $bookingSlot) }}" > Cancel</button>
                <?php $bookingSlot = []; ?>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
