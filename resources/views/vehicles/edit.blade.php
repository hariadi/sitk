@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Kemaskini Tempahan</h1>

            @include('partials.messages')

            {!! Form::model($vehicle, [
                'method' => 'PATCH',
                'route' => ['vehicles.update', $vehicle->id],
                'class' => 'form-horizontal'
            ]) !!}

            @include('vehicles.form', ['submit' => 'Kemaskini'])

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
