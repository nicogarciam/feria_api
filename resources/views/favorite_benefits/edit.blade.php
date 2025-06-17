@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Favorite Benefit
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($favoriteBenefit, ['route' => ['favoriteBenefits.update', $favoriteBenefit->id], 'method' => 'patch']) !!}

                        @include('favorite_benefits.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection