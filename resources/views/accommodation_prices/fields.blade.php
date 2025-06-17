<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    {!! Form::number('hotel_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Season Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('season_id', 'Season Id:') !!}
    {!! Form::number('season_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    {!! Form::number('accommodation_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('accommodationPrices.index') }}" class="btn btn-default">Cancel</a>
</div>
