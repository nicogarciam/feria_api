@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Benefit Places
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($benefitPlaces, ['route' => ['benefitPlaces.update', $benefitPlaces->id], 'method' => 'patch']) !!}

                        @include('benefit_places.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection