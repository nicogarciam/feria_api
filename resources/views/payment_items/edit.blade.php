@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Payment Item
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($paymentItem, ['route' => ['paymentItems.update', $paymentItem->id], 'method' => 'patch']) !!}

                        @include('payment_items.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection