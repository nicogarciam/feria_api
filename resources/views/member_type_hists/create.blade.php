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
                    {!! Form::open(['route' => 'memberTypeHists.store']) !!}

                        @include('member_type_hists.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
