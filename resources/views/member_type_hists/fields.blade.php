<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Month Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount_month', 'Amount Month:') !!}
    {!! Form::text('amount_month', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount', 'Discount:') !!}
    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Ini Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_ini', 'Date Ini:') !!}
    {!! Form::text('date_ini', null, ['class' => 'form-control','id'=>'date_ini']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_ini').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Date End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_end', 'Date End:') !!}
    {!! Form::text('date_end', null, ['class' => 'form-control','id'=>'date_end']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_end').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Membership Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membership_id', 'Membership Id:') !!}
    {!! Form::text('membership_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Membership Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membership_type_id', 'Membership Type Id:') !!}
    {!! Form::text('membership_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('active', 'Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('active', 0) !!}
        {!! Form::checkbox('active', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('memberTypeHists.index') }}" class="btn btn-default">Cancel</a>
</div>
