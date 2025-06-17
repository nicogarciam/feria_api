@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Accommodation Price
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'accommodationPrices.store']) !!}

                        @include('accommodation_prices.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
