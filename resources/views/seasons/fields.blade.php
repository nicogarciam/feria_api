<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

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

<!-- Season Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('season_type', 'Season Type:') !!}
    {!! Form::text('season_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('seasons.index') }}" class="btn btn-default">Cancel</a>
</div>
