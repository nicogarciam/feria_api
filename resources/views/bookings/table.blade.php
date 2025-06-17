<div class="table-responsive">
    <table class="table" id="bookings-table">
        <thead>
            <tr>
                <th>Hotel Id</th>
        <th>Guest Id</th>
        <th>Booking State Id</th>
        <th>Date In</th>
        <th>Date Out</th>
        <th>Note</th>
        <th>Pax</th>
        <th>Pax Adult</th>
        <th>Pax Minor</th>
        <th>Accommodation Count</th>
        <th>Coupon Code</th>
        <th>Days To Confirm</th>
        <th>Days To Cancel</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->hotel_id }}</td>
            <td>{{ $booking->guest_id }}</td>
            <td>{{ $booking->booking_state_id }}</td>
            <td>{{ $booking->date_in }}</td>
            <td>{{ $booking->date_out }}</td>
            <td>{{ $booking->note }}</td>
            <td>{{ $booking->pax }}</td>
            <td>{{ $booking->pax_adult }}</td>
            <td>{{ $booking->pax_minor }}</td>
            <td>{{ $booking->accommodation_count }}</td>
            <td>{{ $booking->coupon_code }}</td>
            <td>{{ $booking->days_to_confirm }}</td>
            <td>{{ $booking->days_to_cancel }}</td>
                <td>
                    {!! Form::open(['route' => ['bookings.destroy', $booking->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bookings.show', [$booking->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('bookings.edit', [$booking->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
