<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    {!! Form::number('hotel_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guest_id', 'Customer Id:') !!}
    {!! Form::number('guest_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Sale State Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('booking_state_id', 'Sale State Id:') !!}
    {!! Form::number('booking_state_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Date In Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_in', 'Date In:') !!}
    {!! Form::text('date_in', null, ['class' => 'form-control','id'=>'date_in']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_in').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Date Out Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_out', 'Date Out:') !!}
    {!! Form::text('date_out', null, ['class' => 'form-control','id'=>'date_out']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#date_out').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Note Field -->
<div class="form-group col-sm-6">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Pax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pax', 'Pax:') !!}
    {!! Form::number('pax', null, ['class' => 'form-control']) !!}
</div>

<!-- Pax Adult Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pax_adult', 'Pax Adult:') !!}
    {!! Form::number('pax_adult', null, ['class' => 'form-control']) !!}
</div>

<!-- Pax Minor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pax_minor', 'Pax Minor:') !!}
    {!! Form::number('pax_minor', null, ['class' => 'form-control']) !!}
</div>

<!-- Accommodation Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accommodation_count', 'Accommodation Count:') !!}
    {!! Form::number('accommodation_count', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupon Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coupon_code', 'Coupon Code:') !!}
    {!! Form::text('coupon_code', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Days To Confirm Field -->
<div class="form-group col-sm-6">
    {!! Form::label('days_to_confirm', 'Days To Confirm:') !!}
    {!! Form::number('days_to_confirm', null, ['class' => 'form-control']) !!}
</div>

<!-- Days To Cancel Field -->
<div class="form-group col-sm-6">
    {!! Form::label('days_to_cancel', 'Days To Cancel:') !!}
    {!! Form::number('days_to_cancel', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('bookings.index') }}" class="btn btn-default">Cancel</a>
</div>
