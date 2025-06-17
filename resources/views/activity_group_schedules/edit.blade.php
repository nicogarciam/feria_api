@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Activity Group Schedule
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($activityGroupSchedule, ['route' => ['activityGroupSchedules.update', $activityGroupSchedule->id], 'method' => 'patch']) !!}

                        @include('activity_group_schedules.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection