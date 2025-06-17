<div class="table-responsive">
    <table class="table" id="guests-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Dni</th>
        <th>Birthday</th>
        <th>Email</th>
        <th>Address</th>
        <th>Token</th>
        <th>Password</th>
        <th>City Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($guests as $guest)
            <tr>
                <td>{{ $guest->name }}</td>
            <td>{{ $guest->dni }}</td>
            <td>{{ $guest->birthday }}</td>
            <td>{{ $guest->email }}</td>
            <td>{{ $guest->address }}</td>
            <td>{{ $guest->token }}</td>
            <td>{{ $guest->password }}</td>
            <td>{{ $guest->city_id }}</td>
                <td>
                    {!! Form::open(['route' => ['guests.destroy', $guest->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('guests.show', [$guest->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('guests.edit', [$guest->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
