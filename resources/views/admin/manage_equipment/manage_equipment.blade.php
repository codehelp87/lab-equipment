<div class="col-sm-12">
    <table class="table table-responsive" id="list-equipment">
        <tbody>
            @if($equipments->count() > 0)
            @foreach($equipments as $equipment)
            <tr id="edit-eqipment{{ $equipment->id }}">
                <td>{{ $equipment->model_no }}</td>
                <td><img src="{{ $equipment->equipment_photo }}" style="width: 50px; height: 50px;"></td>
                <td>
                    <Strong>Status</Strong><br>
                    <Strong>Unit Time</Strong><br>
                    <Strong>Max Time(per day)</Strong><br>
                </td>
                <td>
                    {{ $equipment->availability == 1? 'Available': 'Unavailable'}}<br>
                    {{ $equipment->price_per_unit_time}}<br>
                    {{ $equipment->max_reservation_time}}<br>
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
            </tr>
            <tr>
                <td colspan="7">
                    <div class="display{{ $equipment->id }}" id="edit-eqipment{{ $equipment->id }}" style="display: none;">dddjdjdjdjjddjdjdddjjdjjddjddjjddj</div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>