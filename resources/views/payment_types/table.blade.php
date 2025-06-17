<div class="table-responsive">
    <table class="table" id="paymentTypes-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
        <th>Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($paymentTypes as $paymentType)
            <tr>
                <td>{{ $paymentType->name }}</td>
            <td>{{ $paymentType->description }}</td>
            <td>{{ $paymentType->active }}</td>
                <td>
                    {!! Form::open(['route' => ['paymentTypes.destroy', $paymentType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentTypes.show', [$paymentType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('paymentTypes.edit', [$paymentType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
