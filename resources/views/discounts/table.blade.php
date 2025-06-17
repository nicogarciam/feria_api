<div class="table-responsive">
    <table class="table" id="discounts-table">
        <thead>
            <tr>
                <th>Hotel Id</th>
        <th>Date From</th>
        <th>Date To</th>
        <th>Description</th>
        <th>Limit Discount</th>
        <th>Accommodation Type Id</th>
        <th>Discount</th>
        <th>Active</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($discounts as $discount)
            <tr>
                <td>{{ $discount->hotel_id }}</td>
            <td>{{ $discount->date_from }}</td>
            <td>{{ $discount->date_to }}</td>
            <td>{{ $discount->description }}</td>
            <td>{{ $discount->limit_discount }}</td>
            <td>{{ $discount->accommodation_type_id }}</td>
            <td>{{ $discount->discount }}</td>
            <td>{{ $discount->active }}</td>
                <td>
                    {!! Form::open(['route' => ['discounts.destroy', $discount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('discounts.show', [$discount->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('discounts.edit', [$discount->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
