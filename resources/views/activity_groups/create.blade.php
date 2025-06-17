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
                    {!! Form::open(['route' => 'activityGroups.store']) !!}

                        @include('activity_groups.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
