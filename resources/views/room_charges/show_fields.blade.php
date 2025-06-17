<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $roomCharge->date }}</p>
</div>

<!-- Accommodation Id Field -->
<div class="form-group">
    {!! Form::label('accommodation_id', 'Accommodation Id:') !!}
    <p>{{ $roomCharge->accommodation_id }}</p>
</div>

<!-- Charge Type Field -->
<div class="form-group">
    {!! Form::label('charge_type', 'Charge Type:') !!}
    <p>{{ $roomCharge->charge_type }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $roomCharge->description }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $roomCharge->amount }}</p>
</div>

<!-- Payed Field -->
<div class="form-group">
    {!! Form::label('payed', 'Payed:') !!}
    <p>{{ $roomCharge->payed }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $roomCharge->user_id }}</p>
</div>

