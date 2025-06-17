@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Room Charge
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($roomCharge, ['route' => ['roomCharges.update', $roomCharge->id], 'method' => 'patch']) !!}

                        @include('room_charges.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection