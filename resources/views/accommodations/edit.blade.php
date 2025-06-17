@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Accommodation
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($accommodation, ['route' => ['accommodations.update', $accommodation->id], 'method' => 'patch']) !!}

                        @include('accommodations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection