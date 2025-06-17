<!-- Pay Date Field -->
<div class="form-group">
    {!! Form::label('pay_date', 'Pay Date:') !!}
    <p>{{ $payment->pay_date }}</p>
</div>

<!-- Sale Id Field -->
<div class="form-group">
    {!! Form::label('booking_id', 'Sale Id:') !!}
    <p>{{ $payment->booking_id }}</p>
</div>

<!-- Note Field -->
<div class="form-group">
    {!! Form::label('note', 'Note:') !!}
    <p>{{ $payment->note }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $payment->amount }}</p>
</div>

<!-- Discount Field -->
<div class="form-group">
    {!! Form::label('discount', 'Discount:') !!}
    <p>{{ $payment->discount }}</p>
</div>

<!-- Total Field -->
<div class="form-group">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $payment->total }}</p>
</div>

<!-- Coupon Code Field -->
<div class="form-group">
    {!! Form::label('coupon_code', 'Coupon Code:') !!}
    <p>{{ $payment->coupon_code }}</p>
</div>

<!-- Payment Type Id Field -->
<div class="form-group">
    {!! Form::label('payment_type_id', 'Payment Type Id:') !!}
    <p>{{ $payment->payment_type_id }}</p>
</div>

<!-- Payment State Id Field -->
<div class="form-group">
    {!! Form::label('payment_state_id', 'Payment State Id:') !!}
    <p>{{ $payment->payment_state_id }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $payment->user_id }}</p>
</div>

