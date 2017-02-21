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

<div class="col-sm-8">
<div class="table-responsive">
    <table class="table table-responsive" id="list-labs">
        <tbody>
            @if($labs->count() > 0)
            @foreach($labs as $lab)
            <tr id="edit-lab{{ $lab->id }}">
                <td>
                   {{ $lab->title }}<br>
                </td>
                <td><a href="#" class="edit-lab" id="{{ $lab->id }}" title="{{ $lab->title }}">Edit</a></td>
                <td><a href="#"  class="delete-lab" id="{{ $lab->id }}" rel= "{{ route('delete_equipment', ['id' => $lab->id ]) }}">Delete</a></td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="display{{ $lab->id }}" id="edit-eqipment{{ $lab->id }}" style="display: none;">dddjdjdjdjjddjdjdddjjdjjddjddjjddj</div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    </div>
</div>
