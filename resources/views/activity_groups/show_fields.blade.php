<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $activityGroup->description }}</p>
</div>

<!-- Cuota Field -->
<div class="form-group">
    {!! Form::label('cuota', 'Cuota:') !!}
    <p>{{ $activityGroup->cuota }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $activityGroup->state }}</p>
</div>

