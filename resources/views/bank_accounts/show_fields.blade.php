<!-- Store Id Field -->
<div class="form-group">
    {!! Form::label('hotel_id', 'Store Id:') !!}
    <p>{{ $bankAccount->hotel_id }}</p>
</div>

<!-- Bank Field -->
<div class="form-group">
    {!! Form::label('bank', 'Bank:') !!}
    <p>{{ $bankAccount->bank }}</p>
</div>

<!-- Cbu Field -->
<div class="form-group">
    {!! Form::label('cbu', 'Cbu:') !!}
    <p>{{ $bankAccount->cbu }}</p>
</div>

<!-- Cvu Field -->
<div class="form-group">
    {!! Form::label('cvu', 'Cvu:') !!}
    <p>{{ $bankAccount->cvu }}</p>
</div>

<!-- Alias Field -->
<div class="form-group">
    {!! Form::label('alias', 'Alias:') !!}
    <p>{{ $bankAccount->alias }}</p>
</div>

