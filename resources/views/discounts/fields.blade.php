<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    {!! Form::number('hotel_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Date From Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_from', 'Date From:') !!}
    {!! Form::text('date_from', null, ['class' => 'form-control','id'=>'date_from']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_from').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Date To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_to', 'Date To:') !!}
    {!! Form::text('date_to', null, ['class' => 'form-control','id'=>'date_to']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_to').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Limit Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('limit_discount', 'Limit Discount:') !!}
    {!! Form::number('limit_discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Accommodation Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_type_id', 'Accommodation Type Id:') !!}
    {!! Form::number('accommodation_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount', 'Discount:') !!}
    {!! Form::number('discount', null, ['class' => 'form-control']) !!}
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
    <a href="{{ route('discounts.index') }}" class="btn btn-default">Cancel</a>
</div>
