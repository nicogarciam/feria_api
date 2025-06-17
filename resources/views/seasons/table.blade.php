<div class="table-responsive">
    <table class="table" id="seasons-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Hotel Id</th>
        <th>Date From</th>
        <th>Date To</th>
        <th>Season Type</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($seasons as $season)
            <tr>
                <td>{{ $season->name }}</td>
            <td>{{ $season->hotel_id }}</td>
            <td>{{ $season->date_from }}</td>
            <td>{{ $season->date_to }}</td>
            <td>{{ $season->season_type }}</td>
                <td>
                    {!! Form::open(['route' => ['seasons.destroy', $season->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('seasons.show', [$season->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('seasons.edit', [$season->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
