@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Kenderaan</h1>

        @include('partials.messages')

        @foreach ($vehicles as $vehicle)
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->registration_no }}</a></div>

                <div class="panel-body">{{ $vehicle->model }}</div>

                    <ul class="list-group">
                        <li class="list-group-item">Jenis: {{ $vehicle->types }}</li>
                        <li class="list-group-item">Kapasiti: {{ $vehicle->capacity }}</li>
                        <li class="list-group-item">Tarikh Dimasukkan: {{ $vehicle->created_at->toDayDateTimeString() }}</li>

                        @if ($vehicle->image && file_exists($vehicle->image))
                            <img src="{{ $vehicle->image }}">
                        @endif
                    </ul>

                <div class="panel-footer"><span class="label label-default">{{ $vehicle->status }}</span></div>

            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
