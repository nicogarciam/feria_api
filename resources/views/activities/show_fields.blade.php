<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $activity->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $activity->description }}</p>
</div>

<!-- With Cuota Field -->
<div class="form-group">
    {!! Form::label('with_cuota', 'With Cuota:') !!}
    <p>{{ $activity->with_cuota }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $activity->state }}</p>
</div>

<!-- Date Start Field -->
<div class="form-group">
    {!! Form::label('date_start', 'Date Start:') !!}
    <p>{{ $activity->date_start }}</p>
</div>

