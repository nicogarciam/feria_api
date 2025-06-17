<div class="table-responsive">
    <table class="table" id="pays-table">
        <thead>
            <tr>
                <th>Pay Date</th>
        <th>User Id</th>
        <th>Pay Method</th>
        <th>Pay Ref</th>
        <th>Member Id</th>
        <th>Amount</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pays as $pay)
            <tr>
                <td>{{ $pay->pay_date }}</td>
            <td>{{ $pay->user_id }}</td>
            <td>{{ $pay->pay_method }}</td>
            <td>{{ $pay->pay_ref }}</td>
            <td>{{ $pay->member_id }}</td>
            <td>{{ $pay->amount }}</td>
                <td>
                    {!! Form::open(['route' => ['pays.destroy', $pay->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('pays.show', [$pay->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('pays.edit', [$pay->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
