<div class="table-responsive">
    <table class="table" id="paymentStates-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
        <th>Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($paymentStates as $paymentState)
            <tr>
                <td>{{ $paymentState->name }}</td>
            <td>{{ $paymentState->description }}</td>
            <td>{{ $paymentState->active }}</td>
                <td>
                    {!! Form::open(['route' => ['paymentStates.destroy', $paymentState->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentStates.show', [$paymentState->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('paymentStates.edit', [$paymentState->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
