@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Maklumat Pemandu Baru</h1>

            @include('partials.messages')

            {!! Form::open([
                'route' => 'drivers.store',
                'class' => 'form-horizontal'
            ]) !!}

           @include('drivers.form', ['submit' => 'Daftar Pemandu'])

           {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
