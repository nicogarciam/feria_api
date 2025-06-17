<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $membershipType->description }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $membershipType->amount }}</p>
</div>

<!-- Family Members Field -->
<div class="form-group">
    {!! Form::label('family_members', 'Family Members:') !!}
    <p>{{ $membershipType->family_members }}</p>
</div>

<!-- Date From Field -->
<div class="form-group">
    {!! Form::label('date_from', 'Date From:') !!}
    <p>{{ $membershipType->date_from }}</p>
</div>

<!-- Date End Field -->
<div class="form-group">
    {!! Form::label('date_end', 'Date End:') !!}
    <p>{{ $membershipType->date_end }}</p>
</div>

<!-- Entity Id Field -->
<div class="form-group">
    {!! Form::label('entity_id', 'Entity Id:') !!}
    <p>{{ $membershipType->entity_id }}</p>
</div>

