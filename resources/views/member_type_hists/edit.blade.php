@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Member Type Hist
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($memberTypeHist, ['route' => ['memberTypeHists.update', $memberTypeHist->id], 'method' => 'patch']) !!}

                        @include('member_type_hists.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection