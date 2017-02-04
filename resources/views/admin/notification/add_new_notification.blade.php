<form class="form-horizontal notification" id="notification">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea name="content" id="content" class="form-control" rows="3" required="required" required="required"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-notification">Publish now</button>
            <a class="btn btn-link admin-notification-list" href="#">See list</a>
        </div>
    </div>
</form>
<table class="table table-hover" id="admin-notification-list">
    <tbody>
    @if($notifications->count() > 0)
        @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->title }}</td>
                <td >{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('Y/m/d') }}</td>
                <td class="text-right"><a href="/notification/{{ $notification->id }}/edit" class="edit-notification" id="notify{{ $notification->id }}"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                </td>
            </tr>
        @endforeach
    @endif
    <tr></tr>
    </tbody>
</table>