<div class="table-responsive">
    <table class="table" id="bookingCharges-table">
        <thead>
            <tr>
                <th>Date</th>
        <th>Booking Id</th>
        <th>Charge Type</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Payed</th>
        <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookingCharges as $bookingCharge)
            <tr>
                <td>{{ $bookingCharge->date }}</td>
            <td>{{ $bookingCharge->booking_id }}</td>
            <td>{{ $bookingCharge->charge_type }}</td>
            <td>{{ $bookingCharge->description }}</td>
            <td>{{ $bookingCharge->amount }}</td>
            <td>{{ $bookingCharge->payed }}</td>
            <td>{{ $bookingCharge->user_id }}</td>
                <td>
                    {!! Form::open(['route' => ['bookingCharges.destroy', $bookingCharge->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bookingCharges.show', [$bookingCharge->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('bookingCharges.edit', [$bookingCharge->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
