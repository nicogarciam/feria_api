<!-- Concept Field -->
<div class="form-group">
    {!! Form::label('concept', 'Concept:') !!}
    <p>{{ $fee->concept }}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $fee->date }}</p>
</div>

<!-- Paid Field -->
<div class="form-group">
    {!! Form::label('paid', 'Paid:') !!}
    <p>{{ $fee->paid }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $fee->amount }}</p>
</div>

<!-- Account Id Field -->
<div class="form-group">
    {!! Form::label('account_id', 'Account Id:') !!}
    <p>{{ $fee->account_id }}</p>
</div>

<!-- Membership Id Field -->
<div class="form-group">
    {!! Form::label('membership_id', 'Membership Id:') !!}
    <p>{{ $fee->membership_id }}</p>
</div>

<!-- Pay Id Field -->
<div class="form-group">
    {!! Form::label('pay_id', 'Pay Id:') !!}
    <p>{{ $fee->pay_id }}</p>
</div>

