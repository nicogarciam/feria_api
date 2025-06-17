<div class="table-responsive">
    <table class="table" id="accommodationPrices-table">
        <thead>
            <tr>
                <th>Hotel Id</th>
        <th>Season Id</th>
        <th>Accommodation Type Id</th>
        <th>Price</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accommodationPrices as $accommodationPrice)
            <tr>
                <td>{{ $accommodationPrice->hotel_id }}</td>
            <td>{{ $accommodationPrice->season_id }}</td>
            <td>{{ $accommodationPrice->accommodation_type_id }}</td>
            <td>{{ $accommodationPrice->price }}</td>
                <td>
                    {!! Form::open(['route' => ['accommodationPrices.destroy', $accommodationPrice->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accommodationPrices.show', [$accommodationPrice->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('accommodationPrices.edit', [$accommodationPrice->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
