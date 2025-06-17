<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $booking->hotel_id }}</p>
</div>

<!-- Customer Id Field -->
<div class="form-group">
    {!! Form::label('guest_id', 'Customer Id:') !!}
    <p>{{ $booking->guest_id }}</p>
</div>

<!-- Sale State Id Field -->
<div class="form-group">
    {!! Form::label('booking_state_id', 'Sale State Id:') !!}
    <p>{{ $booking->booking_state_id }}</p>
</div>

<!-- Date In Field -->
<div class="form-group">
    {!! Form::label('date_in', 'Date In:') !!}
    <p>{{ $booking->date_in }}</p>
</div>

<!-- Date Out Field -->
<div class="form-group">
    {!! Form::label('date_out', 'Date Out:') !!}
    <p>{{ $booking->date_out }}</p>
</div>

<!-- Note Field -->
<div class="form-group">
    {!! Form::label('note', 'Note:') !!}
    <p>{{ $booking->note }}</p>
</div>

<!-- Pax Field -->
<div class="form-group">
    {!! Form::label('pax', 'Pax:') !!}
    <p>{{ $booking->pax }}</p>
</div>

<!-- Pax Adult Field -->
<div class="form-group">
    {!! Form::label('pax_adult', 'Pax Adult:') !!}
    <p>{{ $booking->pax_adult }}</p>
</div>

<!-- Pax Minor Field -->
<div class="form-group">
    {!! Form::label('pax_minor', 'Pax Minor:') !!}
    <p>{{ $booking->pax_minor }}</p>
</div>

<!-- Accommodation Count Field -->
<div class="form-group">
    {!! Form::label('accommodation_count', 'Accommodation Count:') !!}
    <p>{{ $booking->accommodation_count }}</p>
</div>

<!-- Coupon Code Field -->
<div class="form-group">
    {!! Form::label('coupon_code', 'Coupon Code:') !!}
    <p>{{ $booking->coupon_code }}</p>
</div>

<!-- Days To Confirm Field -->
<div class="form-group">
    {!! Form::label('days_to_confirm', 'Days To Confirm:') !!}
    <p>{{ $booking->days_to_confirm }}</p>
</div>

<!-- Days To Cancel Field -->
<div class="form-group">
    {!! Form::label('days_to_cancel', 'Days To Cancel:') !!}
    <p>{{ $booking->days_to_cancel }}</p>
</div>

