<div class="table-responsive">
    <table class="table" id="membershipTypes-table">
        <thead>
            <tr>
                <th>Description</th>
        <th>Amount</th>
        <th>Family Members</th>
        <th>Date From</th>
        <th>Date End</th>
        <th>Entity Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($membershipTypes as $membershipType)
            <tr>
                <td>{{ $membershipType->description }}</td>
            <td>{{ $membershipType->amount }}</td>
            <td>{{ $membershipType->family_members }}</td>
            <td>{{ $membershipType->date_from }}</td>
            <td>{{ $membershipType->date_end }}</td>
            <td>{{ $membershipType->entity_id }}</td>
                <td>
                    {!! Form::open(['route' => ['membershipTypes.destroy', $membershipType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('membershipTypes.show', [$membershipType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('membershipTypes.edit', [$membershipType->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
