@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Senarai Pemandu</h1>

        @include('partials.messages')

        @foreach ($drivers as $driver)
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('drivers.show', $driver) }}">{{ $driver->name }}</a></div>

                    <ul class="list-group">
                        <li class="list-group-item">Telefon: {{ $driver->phone }}</li>
                        <li class="list-group-item">E-mel: {{ $driver->email }}</li>
                        <li class="list-group-item">Tarikh Dimasukkan: {{ $driver->created_at->toDayDateTimeString() }}</li>

                        @if ($driver->image && file_exists($driver->image))
                            <img src="{{ $driver->image }}">
                        @endif
                    </ul>

                <div class="panel-footer">
                    <span class="label label-default">{{ $driver->status }}</span>
                    {!! $driver->delete_button !!}
                </div>

            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
