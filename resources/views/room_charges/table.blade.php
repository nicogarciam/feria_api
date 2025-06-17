<div class="table-responsive">
    <table class="table" id="roomCharges-table">
        <thead>
            <tr>
                <th>Date</th>
        <th>Accommodation Id</th>
        <th>Charge Type</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Payed</th>
        <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roomCharges as $roomCharge)
            <tr>
                <td>{{ $roomCharge->date }}</td>
            <td>{{ $roomCharge->accommodation_id }}</td>
            <td>{{ $roomCharge->charge_type }}</td>
            <td>{{ $roomCharge->description }}</td>
            <td>{{ $roomCharge->amount }}</td>
            <td>{{ $roomCharge->payed }}</td>
            <td>{{ $roomCharge->user_id }}</td>
                <td>
                    {!! Form::open(['route' => ['roomCharges.destroy', $roomCharge->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('roomCharges.show', [$roomCharge->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('roomCharges.edit', [$roomCharge->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
