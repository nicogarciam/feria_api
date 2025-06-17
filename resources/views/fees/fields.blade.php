<!-- Concept Field -->
<div class="form-group col-sm-6">
    {!! Form::label('concept', 'Concept:') !!}
    {!! Form::text('concept', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::text('date', null, ['class' => 'form-control','id'=>'date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Paid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paid', 'Paid:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('paid', 0) !!}
        {!! Form::checkbox('paid', '1', null) !!}
    </label>
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_id', 'Account Id:') !!}
    {!! Form::select('account_id', $accountItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Membership Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membership_id', 'Membership Id:') !!}
    {!! Form::select('membership_id', $membershipItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Pay Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_id', 'Pay Id:') !!}
    {!! Form::select('pay_id', $payItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('fees.index') }}" class="btn btn-default">Cancel</a>
</div>
