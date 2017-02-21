<form class="form-horizontal edit_notification" id="{{ $notification->id }}">
<h5 style="padding-left: 20px;">Edit | {{ $notification->title }} </h5>
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required="required" value="{{ $notification->title }}">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea name="content" id="content" class="form-control" rows="3" required="required" required="required">{{ $notification->content }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="edit-notification">Update</button>
            <button type="submit" class="btn btn-large btn-default close-notification" id="{{ $notification->id }}">Cancel</button>
        </div>
    </div>
</form>