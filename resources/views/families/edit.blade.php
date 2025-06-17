@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Family
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($family, ['route' => ['families.update', $family->id], 'method' => 'patch']) !!}

                        @include('families.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection