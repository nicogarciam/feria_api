@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Activity Group
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($activityGroup, ['route' => ['activityGroups.update', $activityGroup->id], 'method' => 'patch']) !!}

                        @include('activity_groups.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection