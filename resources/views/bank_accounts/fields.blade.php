<!-- Store Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    {!! Form::text('hotel_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Bank Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank', 'Bank:') !!}
    {!! Form::text('bank', null, ['class' => 'form-control']) !!}
</div>

<!-- Cbu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cbu', 'Cbu:') !!}
    {!! Form::text('cbu', null, ['class' => 'form-control']) !!}
</div>

<!-- Cvu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cvu', 'Cvu:') !!}
    {!! Form::text('cvu', null, ['class' => 'form-control']) !!}
</div>

<!-- Alias Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alias', 'Alias:') !!}
    {!! Form::text('alias', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('bankAccounts.index') }}" class="btn btn-default">Cancel</a>
</div>
