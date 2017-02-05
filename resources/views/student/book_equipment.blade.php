@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
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
                            {{ $equipment->max_reservation_time}} hr(s)<br>
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
                        <h5>Maximum reservation time: {{ $equipment->max_reservation_time }}hr(s)</h5>
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
                                <tr>
                                    <td>9:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:00 - 9:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:10 - 9:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:20 - 9:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:30 - 9:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:40 - 9:40">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:50 - 10:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:00 - 10:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:10 - 10:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:20 - 10:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:30 - 10:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:40 - 10:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="10:50 - 11:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>11:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:00 - 11:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:10 - 11:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:20 - 11:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:30 - 11:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:40 - 11:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="11:50 - 12:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>12:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:00 - 12:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:10 - 12:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:20 - 12:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:30 - 12:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:40 - 12:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="12:50 - 01:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>13:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:00 - 13:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:10 - 13:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:20 - 13:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:30 - 13:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:40 - 13:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="13:50 - 14:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>14:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:00 - 14:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:10 - 14:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:20 - 14:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:30 - 14:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:40 - 14:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="14:50 - 15:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>15:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:00 - 15:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:10 - 15:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:20 - 15:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:30 - 15:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:40 - 15:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="15:50 - 16:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>16:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:00 - 16:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:10 - 16:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:20 - 16:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:30 - 16:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:40 - 16:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="16:50 - 17:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>17:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:00 - 17:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:10 - 17:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:20 - 17:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:30 - 17:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:40 - 17:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="17:50 - 18:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>18:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:00 - 18:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:10 - 18:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:20 - 18:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:30 - 18:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:40 - 18:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="18:50 - 19:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>19:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:00 - 19:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:10 - 19:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:20 - 19:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:30 - 19:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:40 - 19:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="19:50 - 20:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>20:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:00 - 20:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:10 - 20:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:20 - 20:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:30 - 20:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:40 - 20:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="20:50 - 21:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>21:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:00 - 21:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:10 - 21:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:20 - 21:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:30 - 21:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:40 - 21:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="21:50 - 22:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>22:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:00 - 22:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:10 - 22:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:20 - 22:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:30 - 22:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:40 - 22:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="22:50 - 23:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>23:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:00 - 23:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:10 - 23:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:20 - 23:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:30 - 23:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:40 - 23:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="23:50 - 24:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>24:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="0:00 - 00:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="00:10 - 00:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="00:20 - 00:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="00:30 - 00:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="00:40 - 00:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="00:50 - 01:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:00 - 01:10">
                                                :01 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:10 - 01:20">
                                                :01 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:20 - 01:30">
                                                :01 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:30 - 01:40">
                                                :01 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:40 - 01:50">
                                                :01 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="01:50 - 02:00">
                                                :05 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:00 - 2:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:10 - 2:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:20 - 2:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:30 - 2:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:40 - 2:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="02:50 - 3:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:00 - 3:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:10 - 3:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:20 - 3:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:30 - 3:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:40 - 3:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="03:50 - 4:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:00 - 4:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:10 - 4:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:20 - 4:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:30 - 4:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:40 - 4:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="04:50 - 5:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:00 - 5:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:10 - 5:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:20 - 5:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:30 - 5:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:40 - 5:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="05:50 - 6:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:00 - 6:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:10 - 6:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:20 - 6:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:30 - 6:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:40 - 6:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="06:50 - 7:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:00 - 7:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:10 - 7:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:20 - 7:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:30 - 7:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:40 - 7:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="07:50 - 8:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:00 - 8:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:10 - 8:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:20 - 8:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:30 - 8:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:40 - 8:40">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="08:50 - 9:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9:00</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:00 - 9:10">
                                                :00 - 10
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:10 - 9:20">
                                                :10 - 20
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:20 - 9:30">
                                                :20 - 30
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:30 - 9:40">
                                                :30 - 40
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:40 - 9:50">
                                                :40 - 50
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="09:50 - 10:00">
                                                :50 - 00
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-default book-now" data-id="{{ $equipment->id }}" id="book-now">Book Now</button>
                    </div>
                </div>
            {{-- </div> --}}
            <script>
                $(function() {
                    var index = 1;
                    var checkbox = $('div.checkbox input[type="checkbox"]');
                    checkbox.each(function(index, el) {
                        var _this = $(this);
                        _this.attr('id', index);
                        @if(count($equipmentBookings) > 0 && !is_null($equipmentBookings))
                        @foreach($equipmentBookings as $booking)
                    @if (count($booking->time_slot) > 0)
                    @foreach($booking->time_slot_id as $slot)
                    var slot = "{{ $slot }}"
                    if (slot === _this.attr('id')) {
                        _this.attr({'checked': true, 'disabled': true});
                        _this.parent().css('text-decoration', 'line-through')
                    }
                    @endforeach
                    @endif
                    @endforeach
                    @endif
                    index ++;
                    });
                });
            </script>
            <script type="text/javascript">
            $(function () {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                var myDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds());

                console.log(moment(myDate).format('YYYY-MM-DD HH:mm'));


                var currentDate = moment(today).format('YYYY-MM-DD ddd');
                $(document).find('span#time').text(currentDate);

                var newUrl = window.location.href.split('?');;
                var url = window.location.href;

                if (newUrl[1] != undefined) {
                    var newDate =  newUrl[1].split('=');
                    $(document).find('span#time').text(moment(newDate[1]).format('YYYY-MM-DD ddd'));
                }

                $('#datetimepicker1').datepicker({
                    todayHighlight: true,
                    startDate: today,
                    dateFormat: 'yyy-dd-mm',
                }).on("changeDate", function (e) {
                    var currentDate = moment(e.date).format('YYYY-MM-DD');
                    $(document)
                      .find('span#time')
                      .text(moment(e.date)
                      .format('MM.DD.YYYY ddd'));
                      //$(document).find('span#time').text(currentDate);

                      var url = window.location.href;  
                        if (url.indexOf('?') > -1) {
                            splitUrl = url.split('?');
                            url = location.href.replace(splitUrl[1], "date="+currentDate);
                        } else{
                           url += '?date='+moment(e.date).format('YYYY-MM-DD')
                        }
                        window.location.href = url;
                  });
            });
        </script>
            <style type="text/css">
                .radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
                    position: inherit;
                }
                table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                    vertical-align: middle;
                }
            </style>
        </div>
    </div>
</div>
@include('student.booking_detail_modal')
@endsection