@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @if (Auth::user()->role_id == 2)
        <div class="col-md-10 col-md-offset-1">
            @include('admin.manage_user_account.logout')
            <h4>Admin</h4>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Basic Info
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            @include('admin.basic_info.edit_basic_info')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Training Requests
                        </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            @include('admin.training_requests.training_request')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Training Completion
                        </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            @include('admin.training_completion.complete_training')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Total usage by Lab
                        </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            @include('admin.lab_usage.total_lab')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage user accounts
                        </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            @include('admin.manage_user_account.edit_user_account')
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage Equipments
                        </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                            @include('admin.manage_equipment.manage_equipment')
                            @include('admin.add_more_equipment.add_more_equipment', ['labs' => $labs,
                            'equipments' => $equipments])
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage Lab
                        </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                        <div class="panel-body">
                            @include('admin.manage_lab.manage_lab', ['users' => $users])
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingEight">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Notification
                        </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseEight">
                        <div class="panel-body">
                            @include('admin.notification.add_new_notification')
                        </div>
                    </div>
                </div>
            </div>
            <!-- panel-group -->
        </div>
        @else
        <div class="col-md-8 col-md-offset-2">
            @include('admin.manage_user_account.logout')
            <hr>
            <p>
                <h5>Notifications <a class="pull-right">Read all</a></h5>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard</td>
                            <td>{{ date('Y/m/d') }}</td>
                        </tr>
                        <tr>
                            <td> dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</td>
                            <td>{{ date('Y/m/d') }}</td>
                        </tr>
                        <tr>
                            <td> Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, </td>
                            <td>{{ date('Y/m/d') }}</td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <p>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>{{ Auth::user()-> name }}</strong></td>
                            <td><strong>Lab: {{ $trainings[0]->equipment->user->name }}</strong></td>
                            <td><a  class="pull-right" href="{{ route('my_profile') }}" title="{{ Auth::user()-> name}}"><strong>See my page</strong></a></td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <hr>
            <p>
                @include('student.partials.upcoming_booking', ['bookins' => $bookings])
            </p>
            <hr>
            <p>
                <h5>Book an Equipment</h5>
                <table class="table table-responsive" id="book-equipment">
                    <tbody>
                        @if($trainings->count() > 0)
                        @foreach($trainings as $training)
                        <tr id="edit-eqipment{{ $training->equipment->id }}">
                            <td>{{ $training->equipment->model_no }}</td>
                            <td><img src="{{ $training->equipment->equipment_photo }}" style="width: 50px; height: 50px;"></td>
                            <td>
                                <Strong>Status</Strong><br>
                                <Strong>Unit Time</Strong><br>
                                <Strong>Max Time(per day)</Strong><br>
                            </td>
                            <td>
                                {{ $training->equipment->availability == 1? 'Available': 'Unavailable'}}<br>
                                {{ $training->equipment->price_per_unit_time}}<br>
                                {{ $training->equipment->max_reservation_time}} hr(s)<br>
                            </td>
                            <td>
                                <Strong>Open</Strong><br>
                                <Strong>Cancel</Strong><br>
                            </td>
                            <td>
                                <span>30 minutes before</span><br>
                                <span>1 hour before</span><br>
                            </td>
                            <td><a href="/equipments/{{ $training->equipment->id }}/booking" class="btn btn-default pull-right">Book Now</a></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">
                                <span>Your Lab usage for this month: <strong>2:00</strong></span><br>
                                <span>Your usage for this month <strong>1:00</strong></span><br>
                                <span>You have not used this Equipment for : <strong>10 days</strong><br>(Your account will be blocked in 5 days)</span><br>
                            </td>
                            <td colspan="1"></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </p>
        </div>
        @endif
    </div>
</div>
<!-- container -->
@endsection