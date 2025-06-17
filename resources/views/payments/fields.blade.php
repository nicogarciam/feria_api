<!-- Pay Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_date', 'Pay Date:') !!}
    {!! Form::text('pay_date', null, ['class' => 'form-control','id'=>'pay_date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#pay_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Sale Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('booking_id', 'Sale Id:') !!}
    {!! Form::number('booking_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount', 'Discount:') !!}
    {!! Form::number('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::number('total', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupon Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coupon_code', 'Coupon Code:') !!}
    {!! Form::text('coupon_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Payment Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payment_type_id', 'Payment Type Id:') !!}
    {!! Form::number('payment_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Payment State Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payment_state_id', 'Payment State Id:') !!}
    {!! Form::number('payment_state_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>
</div>
