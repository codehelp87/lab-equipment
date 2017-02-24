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
            <a class="btn btn-link admin-notification-list open" href="#">See lists</a>
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-hover table-striped" id="list-notification">
        <tbody>
            @if($notifications->count() > 0)
            @foreach($notifications as $notification)
            <tr id="edit-notification{{ $notification->id }}">
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $notification->title }}</td>
                <td >{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('Y/m/d') }}</td>
                <td class="text-right"><a href="/notification/{{ $notification->id }}/edit" class="edit-notification" id="{{ $notification->id }}"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="display{{ $notification->id }}" id="edit-notification{{ $notification->id }}" style="display: none;"></div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
</div>