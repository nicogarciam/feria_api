@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Voucher
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($voucher, ['route' => ['vouchers.update', $voucher->id], 'method' => 'patch']) !!}

                        @include('vouchers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection