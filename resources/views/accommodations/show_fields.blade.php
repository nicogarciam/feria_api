<!-- Code Field -->
<div class="form-group">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $accommodation->code }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $accommodation->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $accommodation->description }}</p>
</div>

<!-- Capacity Desc Field -->
<div class="form-group">
    {!! Form::label('capacity_desc', 'Capacity Desc:') !!}
    <p>{{ $accommodation->capacity_desc }}</p>
</div>

<!-- Capacity Field -->
<div class="form-group">
    {!! Form::label('capacity', 'Capacity:') !!}
    <p>{{ $accommodation->capacity }}</p>
</div>

<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $accommodation->hotel_id }}</p>
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    <p>{{ $accommodation->accommodation_type_id }}</p>
</div>

<!-- Accommodation State Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_state_id', 'Accommodation State Id:') !!}
    <p>{{ $accommodation->accommodation_state_id }}</p>
</div>

