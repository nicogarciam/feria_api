<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $season->name }}</p>
</div>

<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $season->hotel_id }}</p>
</div>

<!-- Date From Field -->
<div class="form-group">
    {!! Form::label('date_from', 'Date From:') !!}
    <p>{{ $season->date_from }}</p>
</div>

<!-- Date To Field -->
<div class="form-group">
    {!! Form::label('date_to', 'Date To:') !!}
    <p>{{ $season->date_to }}</p>
</div>

<!-- Season Type Field -->
<div class="form-group">
    {!! Form::label('season_type', 'Season Type:') !!}
    <p>{{ $season->season_type }}</p>
</div>

