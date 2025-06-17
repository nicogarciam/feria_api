<!-- Affiliate Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('affiliate_id', 'Affiliate Id:') !!}
    {!! Form::number('affiliate_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Ralation Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ralation', 'Ralation:') !!}
    {!! Form::select('ralation', ['PADRE' => 'PADRE', 'MADRE' => 'MADRE', 'HIJO/A' => 'HIJO/A', 'SOBRINO' => 'SOBRINO', 'OTRO' => 'OTRO'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('families.index') }}" class="btn btn-default">Cancel</a>
</div>
