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

<!-- Accommodation Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_id', 'Accommodation Id:') !!}
    {!! Form::number('accommodation_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Charge Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge_type', 'Charge Type:') !!}
    {!! Form::text('charge_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Payed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payed', 'Payed:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('payed', 0) !!}
        {!! Form::checkbox('payed', '1', null) !!}
    </label>
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('roomCharges.index') }}" class="btn btn-default">Cancel</a>
</div>
