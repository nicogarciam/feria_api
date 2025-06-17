<div class="table-responsive">
    <table class="table" id="accommodations-table">
        <thead>
            <tr>
                <th>Code</th>
        <th>Name</th>
        <th>Description</th>
        <th>Capacity Desc</th>
        <th>Capacity</th>
        <th>Hotel Id</th>
        <th>Accommodation Type Id</th>
        <th>Accommodation State Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accommodations as $accommodation)
            <tr>
                <td>{{ $accommodation->code }}</td>
            <td>{{ $accommodation->name }}</td>
            <td>{{ $accommodation->description }}</td>
            <td>{{ $accommodation->capacity_desc }}</td>
            <td>{{ $accommodation->capacity }}</td>
            <td>{{ $accommodation->hotel_id }}</td>
            <td>{{ $accommodation->accommodation_type_id }}</td>
            <td>{{ $accommodation->accommodation_state_id }}</td>
                <td>
                    {!! Form::open(['route' => ['accommodations.destroy', $accommodation->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accommodations.show', [$accommodation->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('accommodations.edit', [$accommodation->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
