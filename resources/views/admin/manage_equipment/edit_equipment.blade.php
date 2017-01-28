<form class="form-horizontal edit_equipment" id="{{ $equipment->id }}" style="border-bottom: 1px solid #ccc;">
<h4 style="padding: 20px;">Edit | {{ $equipment->title }} </h4>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Title of Equipment</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title of Equipment" value="{{ $equipment->title }}" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="model" class="col-sm-2 control-label">Model No</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model_no" name="model_no" placeholder="Model No" value="{{ $equipment->model_no }}" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="maker" class="col-sm-2 control-label">Maker</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="maker" name="maker" placeholder="Maker" value="{{ $equipment->maker }}" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="time_unit" class="col-sm-2 control-label">Time Unit</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="time_unit" name="time_unit" placeholder="Time Unit" required="required" value="{{ $equipment->time_unit }}">
        </div>
    </div>
    <div class="form-group">
        <label for="reservation_time" class="col-sm-2 control-label">Max Reservation Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="reservation_time" name="reservation_time" placeholder="Max Reservation Time" required="required" value="{{ $equipment->max_reservation_time }}">
        </div>
    </div>
    <div class="form-group">
        <label for="price_per_unit" class="col-sm-2 control-label">Price per unit Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="price_per_unit" name="price_per_unit" placeholder="Price per unit Time" required="required" value="{{ $equipment->price_per_unit_time }}">
        </div>
    </div>
    <div class="form-group">
        <label for="availability" class="col-sm-2 control-label">Availability</label>
        <div class="col-sm-10">
            <select name="availability" id="availability" class="form-control" required="required">
                <option value="">Availability</option>
                @if ($equipment->availability == 1)
                    <option value="1" selected="selected">Available</option>
                @else
                    <option value="1">Available</option>
                @endif
                @if ($equipment->availability == 0)
                    <option value="0" selected="selected">Unavailable</option>
                @else
                    <option value="0">Unavailable</option>
                @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="assign_lab" class="col-sm-2 control-label">Assign to Lab</label>
        <div class="col-sm-10">
            <select name="assign_lab" id="assign_lab" name="assign_lab" class="form-control" required="required">
                <option value="0">Choose Lab</option>
                @if ($labs->count() > 0)
                @foreach($labs as $lab)
                @if ($equipment->lab->id == $lab-> id)
                <option value="{{ $lab->id }}" selected="selected">{{ $lab->title }}</option>
                @else
                <option value="{{ $lab->id }}">{{ $lab->title }}</option>
                @endif
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="photo" class="col-sm-2 control-label">Photo</label>
        <div class="col-sm-10">
            <input type="file" name="photo" id="photo" class="form-control" value="" required="required">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default edit-equipment">Save</button>
            <button type="submit" class="btn btn-large btn-default cancel-edit-equipment" id="{{ $equipment->id }}">Cancel</button>
        </div>
    </div>
</form>