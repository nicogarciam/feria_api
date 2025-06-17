@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pay
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pay, ['route' => ['pays.update', $pay->id], 'method' => 'patch']) !!}

                        @include('pays.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection