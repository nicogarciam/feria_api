@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Benefit Schedule
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'benefitSchedules.store']) !!}

                        @include('benefit_schedules.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
