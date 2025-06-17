@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Hotel
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($hotel, ['route' => ['hotels.update', $hotel->id], 'method' => 'patch']) !!}

                        @include('hotels.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection