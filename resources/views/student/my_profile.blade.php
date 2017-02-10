@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('admin.manage_user_account.logout')
            <hr>
            <h5>My Page <a href="/home" class="pull-right"> << Home </a></h5>
            <div class="table-responsive">
                <table class="table table-hover table-responsive">
                    <tbody>
                        <tr>
                            <td>
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <strong>{{ Auth::user()->student_id ?? Auth::user()->student_id ?? 'NIL' }}</strong><br>
                            </td>
                            <td>
                                {{ Auth::user()->email }} <br>
                                {{ Auth::user()->phone ?? Auth::user()->phone ?? 'NIL' }}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                Change Password
                                            </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                @include('student.change_password')
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="book_equipment" id="book_equipment" class="form-control" required="required">
                                            <option value="">Select Equipment</option>
                                            @if ($trainings->count() > 0)
                                            @foreach($trainings as $training)
                                            <option value="{{ base64_encode($training->equipment->id) }}">{{ $training->equipment->model_no }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-default pull-right" id="book-equipment">Book Now</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </p>
                <hr>
                <p>
                    @include('student.partials.upcoming_booking', ['bookings' => $bookings])
                </p>
                <hr>
                <p>
                    <h5><strong>Booking History</strong></h5><br>
                    @if($bookingHistories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                @foreach($bookingHistories as $booking)
                                <tr>
                                    <td><strong>{{ $booking->equipment->title }}</strong></td>
                                    <td>{{ $booking->equipment->model_no }}</td>
                                    <td>{{ date_format(new \DateTime($booking->booking_date), 'Y/m/d') }}</td>
                                    <td>{{ implode(' , ', $booking->cancelled_time_slot) }}</td>
                                    <td>
                                        @if($booking->time_slot == null && $booking->status == 2)
                                        <button type="button" class="btn btn-default pull-right completed"> Completed</button>
                                        @endif
                                        @if($booking->time_slot == null && $booking->status == 0)
                                        <button type="button" class="btn btn-default pull-right cancelled"> Cancelled</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h5>No booking history found</h5>
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endsection