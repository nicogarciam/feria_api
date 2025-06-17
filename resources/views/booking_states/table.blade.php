<div class="table-responsive">
    <table class="table" id="bookingStates-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Color</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookingStates as $bookingState)
            <tr>
                <td>{{ $bookingState->name }}</td>
            <td>{{ $bookingState->color }}</td>
                <td>
                    {!! Form::open(['route' => ['bookingStates.destroy', $bookingState->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bookingStates.show', [$bookingState->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('bookingStates.edit', [$bookingState->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
