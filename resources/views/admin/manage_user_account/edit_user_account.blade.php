<form class="form-horizontal">
    <div class="form-group">
        <div class="col-sm-4">
            <select name="lab" id="lab" class="form-control" required="required">
                <option value="0">See by Lab</option>
            </select>
        </div>
        <div class="col-sm-4">
            <select name="status" id="status" class="form-control" required="required">
                <option value="0">See by Status</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <table class="table table-responsive">
                <tbody>
                    @if ($users->count() > 0)
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->student_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><a href="#"  class="student-edit" id="student{{$user->id}}">Edit</a></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</form>
@include('admin.manage_user_account.edit_user_account_modal')