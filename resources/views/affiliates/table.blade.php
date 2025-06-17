<div class="table-responsive">
    <table class="table" id="affiliates-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Date Start</th>
        <th>Birthday</th>
        <th>Address</th>
        <th>Gender</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($affiliates as $affiliate)
            <tr>
                <td>{{ $affiliate->name }}</td>
            <td>{{ $affiliate->date_start }}</td>
            <td>{{ $affiliate->birthday }}</td>
            <td>{{ $affiliate->address }}</td>
            <td>{{ $affiliate->gender }}</td>
                <td>
                    {!! Form::open(['route' => ['affiliates.destroy', $affiliate->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('affiliates.show', [$affiliate->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('affiliates.edit', [$affiliate->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
