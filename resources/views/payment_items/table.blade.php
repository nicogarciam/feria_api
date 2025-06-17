<div class="table-responsive">
    <table class="table" id="paymentItems-table">
        <thead>
            <tr>
                <th>Payment Id</th>
        <th>Description</th>
        <th>Amount</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($paymentItems as $paymentItem)
            <tr>
                <td>{{ $paymentItem->payment_id }}</td>
            <td>{{ $paymentItem->description }}</td>
            <td>{{ $paymentItem->amount }}</td>
                <td>
                    {!! Form::open(['route' => ['paymentItems.destroy', $paymentItem->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('paymentItems.show', [$paymentItem->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('paymentItems.edit', [$paymentItem->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
