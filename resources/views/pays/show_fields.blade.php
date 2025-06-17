<!-- Pay Date Field -->
<div class="form-group">
    {!! Form::label('pay_date', 'Pay Date:') !!}
    <p>{{ $pay->pay_date }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $pay->user_id }}</p>
</div>

<!-- Pay Method Field -->
<div class="form-group">
    {!! Form::label('pay_method', 'Pay Method:') !!}
    <p>{{ $pay->pay_method }}</p>
</div>

<!-- Pay Ref Field -->
<div class="form-group">
    {!! Form::label('pay_ref', 'Pay Ref:') !!}
    <p>{{ $pay->pay_ref }}</p>
</div>

<!-- Member Id Field -->
<div class="form-group">
    {!! Form::label('member_id', 'Member Id:') !!}
    <p>{{ $pay->member_id }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $pay->amount }}</p>
</div>

