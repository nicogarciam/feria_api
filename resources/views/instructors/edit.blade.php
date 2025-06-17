@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Instructor
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($instructor, ['route' => ['instructors.update', $instructor->id], 'method' => 'patch']) !!}

                        @include('instructors.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection