<form class="form-horizontal">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" placeholder="Title">
        </div>
    </div>
    <div class="form-group">
        <label for="model_no" class="col-sm-2 control-label">Model No</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model_no" placeholder="Model No">
        </div>
    </div>
     <div class="form-group">
        <label for="assign_user" class="col-sm-2 control-label">Assign User</label>
        <div class="col-sm-10">
            <select name="assign_user" id="assign_user" class="form-control" required="required">
                <option value="0">Choose User</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Save</button>
        </div>
    </div>
</form>