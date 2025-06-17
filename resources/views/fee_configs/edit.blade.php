@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fee Config
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($feeConfig, ['route' => ['feeConfigs.update', $feeConfig->id], 'method' => 'patch']) !!}

                        @include('fee_configs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection