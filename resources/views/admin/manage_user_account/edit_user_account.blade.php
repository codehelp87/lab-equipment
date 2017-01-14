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
                    <tr>
                        <td>Larry</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Otto</td>
                        <td><a href="#">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Larry</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Otto</td>
                        <td><a href="#">Edit</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
@include('admin.manage_user_account.edit_user_account_modal')