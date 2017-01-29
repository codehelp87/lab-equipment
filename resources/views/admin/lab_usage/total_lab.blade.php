<form class="form-horizontal" id="edit-user-account">
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
<table class="table table-responsive">
    <tbody>
        <tr>
            <td>Larry</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Otto</td>
        </tr>
        <tr>
            <td>Larry</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Otto</td>
        </tr>
    </tbody>
</table>
@include('admin.lab_usage.total_lab_modal')