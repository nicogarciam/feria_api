<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Discount Member Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount_member', 'Discount Member:') !!}
    {!! Form::text('discount_member', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Common Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discount_common', 'Discount Common:') !!}
    {!! Form::text('discount_common', null, ['class' => 'form-control']) !!}
</div>

<!-- Points Awards Field -->
<div class="form-group col-sm-6">
    {!! Form::label('points_awards', 'Points Awards:') !!}
    {!! Form::text('points_awards', null, ['class' => 'form-control']) !!}
</div>

<!-- Limit Uses Field -->
<div class="form-group col-sm-6">
    {!! Form::label('limit_uses', 'Limit Uses:') !!}
    {!! Form::text('limit_uses', null, ['class' => 'form-control']) !!}
</div>

<!-- Range Hours Field -->
<div class="form-group col-sm-6">
    {!! Form::label('range_hours', 'Range Hours:') !!}
    {!! Form::text('range_hours', null, ['class' => 'form-control']) !!}
</div>

<!-- Business Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('business_id', 'Business Id:') !!}
    {!! Form::text('business_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Rating Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rating', 'Rating:') !!}
    {!! Form::text('rating', null, ['class' => 'form-control']) !!}
</div>

<!-- Votes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('votes', 'Votes:') !!}
    {!! Form::text('votes', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image_url', 'Image Url:') !!}
    {!! Form::file('image_url') !!}
</div>
<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('benefits.index') }}" class="btn btn-default">Cancel</a>
</div>
