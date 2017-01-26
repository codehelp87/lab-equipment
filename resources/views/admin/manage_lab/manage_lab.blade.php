<form class="form-horizontal" id="manage_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
        </div>
    </div>
    <div class="form-group">
        <label for="model_no" class="col-sm-2 control-label">Model No</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model_no" name="model_no" placeholder="Model No">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab">Save</button>
        </div>
    </div>
</form>
<hr>
<h6>Assign user to lab</h6>
<hr>
<form class="form-horizontal" id="assign_user_to_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="assign_user" class="col-sm-2 control-label">Assign User</label>
        <div class="col-sm-10">
            <select name="user" id="user" class="form-control" required="required">
                <option value="">Choose User</option>
                @if ($users->count() > 0)
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="lab" class="col-sm-2 control-label">Choose Lab</label>
        <div class="col-sm-10">
            <select name="lab" id="lab" class="form-control" required="required">
                <option value="">Choose Lab</option>
                @if ($labs->count() > 0)
                @foreach($labs as $lab)
                <option value="{{ $lab->id }}">{{ $lab->title }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab-user">Save</button>
        </div>
    </div>
</form>