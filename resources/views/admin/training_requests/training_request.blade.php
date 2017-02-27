<form class="form-horizontal approve-request" id="approve-request">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Equipment</label>
        <div class="col-sm-4">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="">Select Equipment</option>
                @if($equipments->count() > 0)
                @foreach($equipments as $equipment)
                <option value="{{ $equipment->id }}">{{ $equipment->title }} {{ $equipment->model_no }} </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-responsive" id="display-training-request">
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-sm-2 control-label">Date of Training session</label>
        <div class="col-sm-2">
            <select name="year" id="year" class="form-control" required="required">
                <option value="">Select Year</option>
                <?php 
                  for($y = 2017; $y <= 2017; $y++) {
                    echo '<option value='.$y.'>'.$y.'</option>';
                  }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="month" id="month" class="form-control" required="required">
                <option value="">Select Month</option>
                <?php 
                  for($m = 1; $m <= 12; $m++) {
                    if ($m >= date('m')) {
                        echo '<option value='.$m.'>'.getMonth()[$m].'</option>';
                    }
                  }

                  function getMonth() {
                    return [
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    ];
                  }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="day" id="day" class="form-control" required="required">
                <option value="">Select Day</option>
                <?php 
                  for($d = 1; $d <= 31; $d++) {
                    echo '<option value='.$d.'>'.$d.'</option>';
                  }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="time" id="time" class="form-control" required="required">
                <option value="">Select Time</option>
                <?php 
                  for($t = 1; $t <= 24; $t += 1) {
                    if ($t <= 11) {
                        echo '<option value="'.$t.' :00 am">'.$t.':00 am</option>';
                    } elseif ($t > 11 && $t <= 23) {
                        echo '<option value="'.$t.':00 pm">'.$t.':00 pm</option>';
                    } else {
                        echo '<option value="'.$t.':00 am">'.$t.':00 am</option>';
                    }
                  }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="location" placeholder="Location">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Send a confirmation email</button>
        </div>
    </div>
</form>
@include('admin.training_requests.training_request_modal')