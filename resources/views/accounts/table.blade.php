<div class="table-responsive">
    <table class="table" id="accounts-table">
        <thead>
            <tr>
                <th>Firstname</th>
        <th>Lastname</th>
        <th>Activated</th>
        <th>Email</th>
        <th>Langkey</th>
        <th>City Id</th>
        <th>Gender</th>
        <th>Imageurl</th>
        <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($accounts as $account)
            <tr>
                <td>{{ $account->firstName }}</td>
            <td>{{ $account->lastName }}</td>
            <td>{{ $account->activated }}</td>
            <td>{{ $account->email }}</td>
            <td>{{ $account->langKey }}</td>
            <td>{{ $account->city_id }}</td>
            <td>{{ $account->gender }}</td>
            <td>{{ $account->imageUrl }}</td>
            <td>{{ $account->user_id }}</td>
                <td>
                    {!! Form::open(['route' => ['accounts.destroy', $account->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('accounts.show', [$account->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('accounts.edit', [$account->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
