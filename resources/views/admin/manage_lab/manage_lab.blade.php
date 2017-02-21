<form class="form-horizontal" id="manage_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Lab Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Lab Name">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab">Save</button>
        </div>
    </div>
</form>
