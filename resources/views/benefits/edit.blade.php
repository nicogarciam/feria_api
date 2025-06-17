@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Benefit
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($benefit, ['route' => ['benefits.update', $benefit->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('benefits.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection