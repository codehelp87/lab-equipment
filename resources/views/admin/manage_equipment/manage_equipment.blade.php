<div class="col-sm-12">
<div class="table-responsive">
    <table class="table table-responsive" id="list-equipment">
        <tbody>
            @if($equipments->count() > 0)
            @foreach($equipments as $equipment)
            <tr id="edit-eqipment{{ $equipment->id }}">
                <td>
                   {{ $equipment->title }}<br>
                   {{ $equipment->model_no }}<br>
                   {{ $equipment->maker }}<br>
                </td>
                <td><img src="{{ $equipment->equipment_photo }}" style="width: 50px; height: 50px;"></td>
                <td>
                    <Strong>Status</Strong><br>
                    <Strong>Time Unit</Strong><br>
                    <Strong>Max Time(per day)</Strong><br>
                </td>
                <td>
                    {{ $equipment->availability == 1? 'Available': 'Unavailable'}}<br>
                    {{ $equipment->time_unit }} mins<br>
                    {{ $equipment->max_reservation_time }} hours<br>
                </td>
                <td>
                    <Strong>Open</Strong><br>
                    <Strong>Cancel</Strong><br>
                </td>
                <td>
                    <span>30 minutes before</span><br>
                    <span>1 hour before</span><br>
                </td>
                <td><a href="#" class="edit-eqipment" id="{{ $equipment->id }}" title="{{ $equipment->title }}">Edit</a></td>
                <td><a href="#"  class="delete-equipment" id="{{ $equipment->id }}" rel= "{{ route('delete_equipment', ['id' => $equipment->id ]) }}">Delete</a></td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="display{{ $equipment->id }}" id="edit-eqipment{{ $equipment->id }}" style="display: none;"></div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    </div>
</div>