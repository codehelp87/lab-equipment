<h5><strong>Upcoming Booking</strong> <span class="text-danger pull-right">Cancellation is allowed until 1hr. before your reservation</span></h5>
<table class="table table-hover">
    <tbody>
        @if ($bookings->count() > 0)
        <tr>
            <td><strong>{{ $bookings[0]->equipment->title }}</strong></td>
            <td>{{ $bookings[0]->equipment->model_no }}</td>
            <td>{{ date_format(new \DateTime($bookings[0]->booking_date), 'Y/m/d') }}</td>
            <td>@if (@$bookings[0]->time_slot != null) {{ implode(' , ', @$bookings[0]->time_slot) }}
            @endif </td>
            <td><button type="button" class="btn btn-default pull-right cancel-booking" id="{{ $bookings[0]->equipment->id }}"> Cancel</button></td>
        </tr>
        @endif
    </tbody>
</table>