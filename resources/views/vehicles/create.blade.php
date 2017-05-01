@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Maklumat Kenderaan Baru</h1>

            @include('partials.messages')

            {!! Form::open([
                'route' => 'vehicles.store',
                'class' => 'form-horizontal'
            ]) !!}

           @include('vehicles.form', ['submit' => 'Daftar Kenderaan'])

           {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
