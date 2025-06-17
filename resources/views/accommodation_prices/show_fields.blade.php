<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $accommodationPrice->hotel_id }}</p>
</div>

<!-- Season Id Field -->
<div class="form-group">
    {!! Form::label('season_id', 'Season Id:') !!}
    <p>{{ $accommodationPrice->season_id }}</p>
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    <p>{{ $accommodationPrice->accommodation_type_id }}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $accommodationPrice->price }}</p>
</div>

