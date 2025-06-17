@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Membership
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($membership, ['route' => ['memberships.update', $membership->id], 'method' => 'patch']) !!}

                        @include('memberships.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection