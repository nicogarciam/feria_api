<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $bookingCharge->date }}</p>
</div>

<!-- Sale Id Field -->
<div class="form-group">
    {!! Form::label('booking_id', 'Sale Id:') !!}
    <p>{{ $bookingCharge->booking_id }}</p>
</div>

<!-- Charge Type Field -->
<div class="form-group">
    {!! Form::label('charge_type', 'Charge Type:') !!}
    <p>{{ $bookingCharge->charge_type }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $bookingCharge->description }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $bookingCharge->amount }}</p>
</div>

<!-- Payed Field -->
<div class="form-group">
    {!! Form::label('payed', 'Payed:') !!}
    <p>{{ $bookingCharge->payed }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $bookingCharge->user_id }}</p>
</div>

