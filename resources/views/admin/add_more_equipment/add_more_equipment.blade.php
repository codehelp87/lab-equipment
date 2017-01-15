<form class="form-horizontal">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Title of Equipment</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" placeholder="Name" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="model" class="col-sm-2 control-label">Model No</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model" placeholder="Model No" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="maker" class="col-sm-2 control-label">Maker</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="maker" placeholder="Maker" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="time_unit" class="col-sm-2 control-label">Time Unit</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="time_unit" placeholder="Time Unit">
        </div>
    </div>
    <div class="form-group">
        <label for="reservation_time" class="col-sm-2 control-label">Max Reservation Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="reservation_time" placeholder="Max Reservation Time">
        </div>
    </div>
    <div class="form-group">
        <label for="price_per_unit" class="col-sm-2 control-label">Price per unit Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="price_per_unit" placeholder="Price per unit Time">
        </div>
    </div>
    <div class="form-group">
        <label for="availability" class="col-sm-2 control-label">Availability</label>
        <div class="col-sm-10">
            <select name="availability" id="availability" class="form-control" required="required">
                <option value="0">Availability</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="assign_user" class="col-sm-2 control-label">Assign Lab</label>
        <div class="col-sm-10">
            <select name="assign_lab" id="assign_user" class="form-control" required="required">
                <option value="0">Choose Lab</option>
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
            <button type="submit" class="btn btn-large btn-default">Save</button>
        </div>
    </div>
</form>