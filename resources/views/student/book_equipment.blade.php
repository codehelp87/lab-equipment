@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			{{-- @include('admin.manage_user_account.logout') --}}
			<h5><a href="{{ route('my_profile') }}" class="pull-left"> << My page </a></h5><br>
			<hr>
			<h5>Book an equipment</h5>
			<table class="table table-responsive" id="book-equipment">
				<tbody>
					@if($equipment->count() > 0)
					<tr id="edit-eqipment{{ $equipment->id }}">
						<td><strong>{{ $equipment->title }}</strong></td>
						<td>{{ $equipment->model_no }}</td>
						<td>{{ $equipment->maker }}</td>
						<td><img src="{{ $equipment->equipment_photo }}" style="width: 50px; height: 50px;"></td>
						<td>
							<Strong>Status</Strong><br>
							<Strong>Max Time(per day)</Strong><br>
						</td>
						<td>
							{{ $equipment->availability == 1? 'Available': 'Unavailable'}}<br>
							{{ $equipment->max_reservation_time}}<br>
						</td>
					</tr>
					@endif
				</tbody>
			</table>
			<hr>
			<h5>Calendar</h5>
			<hr>
			{{-- <div class="container"> --}}
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
						<hr>
						<h5>Daytime (9am - 9pm)</h5>
						<h5>Maximum reservation time: 3hrs</h5>
						<hr>
						<h5>Night Time (9pm - 9am)</h5>
						<h5>Maximum reservation time: Unlimited</h5>
						<hr>
						<h5>Cancellation policy</h5>
						<h5>Before 1hr of reservation</h5>
						<hr>
					</div>
					<div class="col-md-8">
						<h5>You select <span id="time"></span></h5>
						<table class="table table-hover">
							<tbody>
								<?php $count = 0; ?>
								<?php for ($i = 9; $i <= 33; $i++): ?>
								<tr>
								@if ($i <= 24)
								  <td>{{ $i.":00" }}</td>
								@else 
								<td>{{ (int)($i - 24).":00" }}</td>
								@endif
									<td>
										<div class="checkbox">
											<label>
												<input type="checkbox" value="{{ $i }}:00 - {{ $i }}:10">
												:00 - 10
											</label>
										</div>
									</td>
									<td><div class="checkbox">
										<label>
											<input type="checkbox" value="{{ $i }}:10 - {{ $i }}:20">
											:10 - 20
										</label>
									</div></td>
									<td><div class="checkbox">
										<label>
											<input type="checkbox" value="{{ $i }}:20 - {{ $i }}:30">
											:20 - 30
										</label>
									</div></td>
									<td><div class="checkbox">
										<label>
											<input type="checkbox" value="{{ $i }}:30 - {{ $i }}:40">
											:30 - 40
										</label>
									</div></td>
									<td><div class="checkbox">
										<label>
											<input type="checkbox" value="{{ $i }}:40 - {{ $i }}:50">
											:40 - 50
										</label>
									</div></td>
									<td><div class="checkbox">
										<label>
											<input type="checkbox" value="{{ $i }}:50 - {{ $i }}:00">
											:50 - 00
										</label>
									</div></td>
								</tr>
								<?php endfor ?>
							</tbody>
						</table>
						<button type="button" class="btn btn-default book-now" data-id="{{ $equipment->id }}}" id="book-now">Book Now</button>
					</div>
				</div>
			{{-- </div> --}}
		</div>
	</div>
</div>
@include('student.booking_detail_modal')
@endsection