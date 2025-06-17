<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::number('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Capacity Desc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('capacity_desc', 'Capacity Desc:') !!}
    {!! Form::text('capacity_desc', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Capacity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('capacity', 'Capacity:') !!}
    {!! Form::number('capacity', null, ['class' => 'form-control']) !!}
</div>

<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    {!! Form::number('hotel_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    {!! Form::number('accommodation_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Accommodation State Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_state_id', 'Accommodation State Id:') !!}
    {!! Form::number('accommodation_state_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('accommodations.index') }}" class="btn btn-default">Cancel</a>
</div>
