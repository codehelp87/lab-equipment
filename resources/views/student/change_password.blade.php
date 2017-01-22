<form class="form-horizontal" id="change_password">
    <input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="c_password" class="col-sm-2 control-label">Enter Current Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Enter Current Password">
        </div>
    </div>
    <div class="form-group">
        <label for="new_password" class="col-sm-2 control-label">Enter New Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="new_password" name= "new_password" placeholder="Enter New Password">
        </div>
    </div>
    <div class="form-group">
        <label for="com_password" class="col-sm-2 control-label">Confirm New Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="com_password" name="com_password" placeholder="Confirm New Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-bio">Save</button>
        </div>
    </div>
</form>