@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Movement
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($movement, ['route' => ['movements.update', $movement->id], 'method' => 'patch']) !!}

                        @include('movements.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection