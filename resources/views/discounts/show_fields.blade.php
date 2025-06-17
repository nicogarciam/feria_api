<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $discount->hotel_id }}</p>
</div>

<!-- Date From Field -->
<div class="form-group">
    {!! Form::label('date_from', 'Date From:') !!}
    <p>{{ $discount->date_from }}</p>
</div>

<!-- Date To Field -->
<div class="form-group">
    {!! Form::label('date_to', 'Date To:') !!}
    <p>{{ $discount->date_to }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $discount->description }}</p>
</div>

<!-- Limit Discount Field -->
<div class="form-group">
    {!! Form::label('limit_discount', 'Limit Discount:') !!}
    <p>{{ $discount->limit_discount }}</p>
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    <p>{{ $discount->accommodation_type_id }}</p>
</div>

<!-- Discount Field -->
<div class="form-group">
    {!! Form::label('discount', 'Discount:') !!}
    <p>{{ $discount->discount }}</p>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('active', 'Active:') !!}
    <p>{{ $discount->active }}</p>
</div>

