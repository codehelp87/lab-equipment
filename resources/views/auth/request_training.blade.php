@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center">Request a User Training</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal edit_equipment" style="border-bottom: 1px solid #ccc;">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="model" class="col-sm-2 control-label">Student ID#</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Model No" value="" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maker" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required="required" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lab" class="col-sm-2 control-label">Lab</label>
                            <div class="col-sm-10">
                                <select id="lab" name="lab" class="form-control" required="required">
                                    <option value="0">Choose Lab</option>
                                    @if ($labs->count() > 0)
                                    @foreach($labs as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->title }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="equipment" class="col-sm-2 control-label">Equipment</label>
                            <div class="col-sm-10">
                                <select id="equipment" name="equipment" class="form-control" required="required">
                                    <option value="0">Choose equipment</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="session" class="col-sm-2 control-label">Choose a Session</label>
                            <div class="col-sm-10">
                                <select id="session" name="session" class="form-control" required="required">
                                    <option value="0">Choose session</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-large btn-default request-training">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection