<form class="form-horizontal">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Equipment</label>
        <div class="col-sm-4">
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
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Approve user for Equipment</button>
        </div>
    </div>
</form>
@include('admin.training_completion.training_completion_modal')