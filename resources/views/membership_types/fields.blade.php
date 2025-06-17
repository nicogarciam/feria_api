<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Family Members Field -->
<div class="form-group col-sm-6">
    {!! Form::label('family_members', 'Family Members:') !!}
    {!! Form::text('family_members', null, ['class' => 'form-control']) !!}
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

<!-- Entity Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('entity_id', 'Entity Id:') !!}
    {!! Form::text('entity_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('membershipTypes.index') }}" class="btn btn-default">Cancel</a>
</div>
