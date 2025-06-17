<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $coupon->hotel_id }}</p>
</div>

<!-- Code Field -->
<div class="form-group">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $coupon->code }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $coupon->description }}</p>
</div>

<!-- Limit Discount Field -->
<div class="form-group">
    {!! Form::label('limit_discount', 'Limit Discount:') !!}
    <p>{{ $coupon->limit_discount }}</p>
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    <p>{{ $coupon->accommodation_type_id }}</p>
</div>

<!-- Discount Field -->
<div class="form-group">
    {!! Form::label('discount', 'Discount:') !!}
    <p>{{ $coupon->discount }}</p>
</div>

<!-- Date To Field -->
<div class="form-group">
    {!! Form::label('date_to', 'Date To:') !!}
    <p>{{ $coupon->date_to }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $coupon->state }}</p>
</div>

