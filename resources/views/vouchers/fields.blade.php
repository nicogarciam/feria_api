<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- With Cuota Field -->
<div class="form-group col-sm-6">
    {!! Form::label('with_cuota', 'With Cuota:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('with_cuota', 0) !!}
        {!! Form::checkbox('with_cuota', '1', null) !!}
    </label>
</div>


<!-- State Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_start', 'Date Start:') !!}
    {!! Form::text('date_start', null, ['class' => 'form-control','id'=>'date_start']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_start').datetimepicker({
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

<!-- Membership Used Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membership_used_id', 'Membership Used Id:') !!}
    {!! Form::select('membership_used_id', $membershipItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount', 'Discount:') !!}
    {!! Form::number('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('vouchers.index') }}" class="btn btn-default">Cancel</a>
</div>
