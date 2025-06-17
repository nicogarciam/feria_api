<!-- Affiliate Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('affiliate_id', 'Affiliate Id:') !!}
    {!! Form::select('affiliate_id', $affiliateItems, null, ['class' => 'form-control']) !!}
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

<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::select('state', ['ACTIVE' => 'ACTIVE', 'SUSPENDED' => 'SUSPENDED', 'DELAYED' => 'DELAYED'], null, ['class' => 'form-control']) !!}
</div>

<!-- User Created Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_created_id', 'User Created Id:') !!}
    {!! Form::number('user_created_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Entity Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('entity_id', 'Entity Id:') !!}
    {!! Form::number('entity_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Membership Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membership_type_id', 'Membership Type Id:') !!}
    {!! Form::select('membership_type_id', $membership_typeItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Memeber Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('memeber_code', 'Memeber Code:') !!}
    {!! Form::text('memeber_code', null, ['class' => 'form-control']) !!}
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
    <a href="{{ route('memberships.index') }}" class="btn btn-default">Cancel</a>
</div>
