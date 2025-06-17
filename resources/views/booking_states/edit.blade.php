@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Booking State
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bookingState, ['route' => ['bookingStates.update', $bookingState->id], 'method' => 'patch']) !!}

                        @include('booking_states.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection