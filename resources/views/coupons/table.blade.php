<div class="table-responsive">
    <table class="table" id="coupons-table">
        <thead>
            <tr>
                <th>Hotel Id</th>
        <th>Code</th>
        <th>Description</th>
        <th>Limit Discount</th>
        <th>Accommodation Type Id</th>
        <th>Discount</th>
        <th>Date To</th>
        <th>State</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->hotel_id }}</td>
            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->description }}</td>
            <td>{{ $coupon->limit_discount }}</td>
            <td>{{ $coupon->accommodation_type_id }}</td>
            <td>{{ $coupon->discount }}</td>
            <td>{{ $coupon->date_to }}</td>
            <td>{{ $coupon->state }}</td>
                <td>
                    {!! Form::open(['route' => ['coupons.destroy', $coupon->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('coupons.show', [$coupon->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('coupons.edit', [$coupon->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
