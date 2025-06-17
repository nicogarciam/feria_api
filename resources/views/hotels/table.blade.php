<div class="table-responsive">
    <table class="table" id="hotels-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Latitud</th>
        <th>Longitud</th>
        <th>City Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($hotels as $hotel)
            <tr>
                <td>{{ $hotel->name }}</td>
            <td>{{ $hotel->email }}</td>
            <td>{{ $hotel->address }}</td>
            <td>{{ $hotel->latitud }}</td>
            <td>{{ $hotel->longitud }}</td>
            <td>{{ $hotel->city_id }}</td>
                <td>
                    {!! Form::open(['route' => ['hotels.destroy', $hotel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('hotels.show', [$hotel->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('hotels.edit', [$hotel->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
