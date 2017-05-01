@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Kemaskini Pemandu</h1>

            @include('partials.messages')

            {!! Form::model($driver, [
                'method' => 'PATCH',
                'route' => ['drivers.update', $driver->id],
                'class' => 'form-horizontal'
            ]) !!}

            @include('drivers.form', ['submit' => 'Kemaskini'])

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
