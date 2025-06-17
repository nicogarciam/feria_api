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

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id', $userItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Pay Method Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_method', 'Pay Method:') !!}
    {!! Form::select('pay_method', ['MercadoPago' => 'MercadoPago', 'Contado' => 'Contado', 'Debito' => 'Debito', 'Transferencia' => 'Transferencia'], null, ['class' => 'form-control']) !!}
</div>

<!-- Pay Ref Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_ref', 'Pay Ref:') !!}
    {!! Form::text('pay_ref', null, ['class' => 'form-control']) !!}
</div>

<!-- Member Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('member_id', 'Member Id:') !!}
    {!! Form::select('member_id', $affiliateItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('pays.index') }}" class="btn btn-default">Cancel</a>
</div>
