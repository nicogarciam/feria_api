<!-- Sale Id Field -->
<div class="form-group">
    {!! Form::label('booking_id', 'Sale Id:') !!}
    <p>{{ $bookingDiscount->booking_id }}</p>
</div>

<!-- Discount Id Field -->
<div class="form-group">
    {!! Form::label('discount_id', 'Discount Id:') !!}
    <p>{{ $bookingDiscount->discount_id }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $bookingDiscount->description }}</p>
</div>

<!-- Discount Field -->
<div class="form-group">
    {!! Form::label('discount', 'Discount:') !!}
    <p>{{ $bookingDiscount->discount }}</p>
</div>

