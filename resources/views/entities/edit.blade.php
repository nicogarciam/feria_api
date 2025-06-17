@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entity
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entity, ['route' => ['entities.update', $entity->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('entities.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection