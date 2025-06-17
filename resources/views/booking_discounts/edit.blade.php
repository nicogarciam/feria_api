@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Booking Discount
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bookingDiscount, ['route' => ['bookingDiscounts.update', $bookingDiscount->id], 'method' => 'patch']) !!}

                        @include('booking_discounts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection