<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $voucher->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $voucher->description }}</p>
</div>

<!-- With Cuota Field -->
<div class="form-group">
    {!! Form::label('with_cuota', 'With Cuota:') !!}
    <p>{{ $voucher->with_cuota }}</p>
</div>

<!-- State Field -->
<div class="form-group">
    {!! Form::label('state', 'State:') !!}
    <p>{{ $voucher->state }}</p>
</div>

<!-- Date Start Field -->
<div class="form-group">
    {!! Form::label('date_start', 'Date Start:') !!}
    <p>{{ $voucher->date_start }}</p>
</div>

<!-- Date End Field -->
<div class="form-group">
    {!! Form::label('date_end', 'Date End:') !!}
    <p>{{ $voucher->date_end }}</p>
</div>

<!-- Membership Used Id Field -->
<div class="form-group">
    {!! Form::label('membership_used_id', 'Membership Used Id:') !!}
    <p>{{ $voucher->membership_used_id }}</p>
</div>

<!-- Discount Field -->
<div class="form-group">
    {!! Form::label('discount', 'Discount:') !!}
    <p>{{ $voucher->discount }}</p>
</div>

