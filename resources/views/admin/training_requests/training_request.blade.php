<form class="form-horizontal">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Equipment</label>
        <div class="col-sm-10">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="0">Select Equipment</option>
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
                        <td>
                            <div class="form-group">
                                <input type="checkbox" class="form-control" id="select">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Larry</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>Otto</td>
                        <td>
                            <div class="form-group">
                                <input type="checkbox" class="form-control" id="select">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Date of Training session</label>
        <div class="col-sm-3">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="0">Select Year</option>
            </select>
        </div>
        <div class="col-sm-3">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="0">Select Month</option>
            </select>
        </div>
        <div class="col-sm-3">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="0">Select Day</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="location" placeholder="Location">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Send a confirmation email</button>
        </div>
    </div>
</form>
@include('admin.training_requests.training_request_modal')