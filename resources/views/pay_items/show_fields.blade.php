<!-- Concept Field -->
<div class="form-group">
    {!! Form::label('concept', 'Concept:') !!}
    <p>{{ $payItem->concept }}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $payItem->date }}</p>
</div>

<!-- Paid Field -->
<div class="form-group">
    {!! Form::label('paid', 'Paid:') !!}
    <p>{{ $payItem->paid }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $payItem->amount }}</p>
</div>

<!-- Ref Id Field -->
<div class="form-group">
    {!! Form::label('ref_id', 'Ref Id:') !!}
    <p>{{ $payItem->ref_id }}</p>
</div>

<!-- Pay Id Field -->
<div class="form-group">
    {!! Form::label('pay_id', 'Pay Id:') !!}
    <p>{{ $payItem->pay_id }}</p>
</div>

