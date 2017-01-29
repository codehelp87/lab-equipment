<form class="form-horizontal" id="calculate_lab_usage">
    <div class="form-group">
        <div class="col-sm-4">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="">Select Equipment</option>
                @if($equipments->count() > 0)
                @foreach($equipments as $equipment)
                <option value="{{ $equipment->id }}">{{ $equipment->model_no }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-4">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="">Select booking date</option>
                <?php
                    $year = date('Y');
                    $month = date('M');

                    for ($m = 1; $m <= 12; $m++) {
                        if ($m >= $month) {
                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                            print '<option value='.$year.'-'.$m.'-'.$m.'>'.$year.'.'.$month. '</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
</form>
<table class="table table-responsive display_lab_usage" id="display_lab_usage">
    <thead>
        <tr>
            <th>Lab</th>
            <th>Hours</th>
            <th>Charge</th>
            <th>Lab</th>
            <th>Hours</th>
            <th>Charge</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
@include('admin.lab_usage.total_lab_modal')