<div class="table-responsive">
    <table class="table" id="payments-table">
        <thead>
            <tr>
                <th>Pay Date</th>
        <th>Booking Id</th>
        <th>Note</th>
        <th>Amount</th>
        <th>Discount</th>
        <th>Total</th>
        <th>Coupon Code</th>
        <th>Payment Type Id</th>
        <th>Payment State Id</th>
        <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->pay_date }}</td>
            <td>{{ $payment->booking_id }}</td>
            <td>{{ $payment->note }}</td>
            <td>{{ $payment->amount }}</td>
            <td>{{ $payment->discount }}</td>
            <td>{{ $payment->total }}</td>
            <td>{{ $payment->coupon_code }}</td>
            <td>{{ $payment->payment_type_id }}</td>
            <td>{{ $payment->payment_state_id }}</td>
            <td>{{ $payment->user_id }}</td>
                <td>
                    {!! Form::open(['route' => ['payments.destroy', $payment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('payments.show', [$payment->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('payments.edit', [$payment->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
