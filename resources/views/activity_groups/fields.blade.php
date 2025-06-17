<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Cuota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cuota', 'Cuota:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('cuota', 0) !!}
        {!! Form::checkbox('cuota', '1', null) !!}
    </label>
</div>


<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('activityGroups.index') }}" class="btn btn-default">Cancel</a>
</div>
