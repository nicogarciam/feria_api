<!-- Firstname Field -->
<div class="form-group">
    {!! Form::label('firstName', 'Firstname:') !!}
    <p>{{ $account->firstName }}</p>
</div>

<!-- Lastname Field -->
<div class="form-group">
    {!! Form::label('lastName', 'Lastname:') !!}
    <p>{{ $account->lastName }}</p>
</div>

<!-- Activated Field -->
<div class="form-group">
    {!! Form::label('activated', 'Activated:') !!}
    <p>{{ $account->activated }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $account->email }}</p>
</div>

<!-- Langkey Field -->
<div class="form-group">
    {!! Form::label('langKey', 'Langkey:') !!}
    <p>{{ $account->langKey }}</p>
</div>

<!-- City Id Field -->
<div class="form-group">
    {!! Form::label('city_id', 'City Id:') !!}
    <p>{{ $account->city_id }}</p>
</div>

<!-- Gender Field -->
<div class="form-group">
    {!! Form::label('gender', 'Gender:') !!}
    <p>{{ $account->gender }}</p>
</div>

<!-- Imageurl Field -->
<div class="form-group">
    {!! Form::label('imageUrl', 'Imageurl:') !!}
    <p>{{ $account->imageUrl }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $account->user_id }}</p>
</div>

