@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Payment State
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($paymentState, ['route' => ['paymentStates.update', $paymentState->id], 'method' => 'patch']) !!}

                        @include('payment_states.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection