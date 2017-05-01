@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Maklumat Tempahan</h1>

        @include('partials.messages')

            <div class="panel panel-default">
                <div class="panel-heading">{{ $vehicle->registration_no }}</div>

                <div class="panel-body">{{ $vehicle->model }}</div>

                    <ul class="list-group">
                        <li class="list-group-item">Tarikh Dimasukkan: {{ $vehicle->created_at->toDayDateTimeString() }}</li>
                        <li class="list-group-item">Jenis: {{ $vehicle->types }}</li>
                        <li class="list-group-item">Kapasiti: {{ $vehicle->capacity }}</li>

                        @if ($vehicle->image && file_exists($vehicle->image))
                            <img src="{{ $vehicle->image }}">
                        @endif
                    </ul>

                <div class="panel-footer">
                <span class="label label-default">{{ $vehicle->status }}</span>
                {!! $vehicle->delete_button !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
