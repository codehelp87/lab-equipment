<form class="form-horizontal edit_lab" id="{{ $lab->id }}" style="border-bottom: 1px solid #ccc;">
<h4 style="padding: 20px;">Edit | {{ $lab->title }} </h4>
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Lab Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Lab Name" value="{{ $lab->title }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default edit-lab" id="update-lab" data-id="{{ $lab->id }}">Save</button>
            <button type="submit" class="btn btn-large btn-default close-lab" id="{{ $lab->id }}">Close</button>
        </div>
    </div>
</form>