<form class="form-horizontal complete-training" id="complete-training">
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
            <table class="table table-responsive" id="display-complete-training">
            <thead>
                <tr>
                    <th>STUDENT ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>LAB</th>
                    <th>ACTION</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            </table>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Send a confirmation email</button>
        </div>
    </div>
</form>
@include('admin.training_completion.training_completion_modal')