@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1 class="page-header">Maklumat Tempahan</h1>

            @include('partials.messages')

            <div class="panel panel-default">
                <div class="panel-heading">{{ $reservation->destination }}</div>

                <div class="panel-body">{{ $reservation->reason }}</div>

                    <ul class="list-group">
                        <li class="list-group-item">Tarikh Tempahan: {{ $reservation->created_at }}</li>
                        <li class="list-group-item">Mula: {{ $reservation->start_at }}</li>
                        <li class="list-group-item">Tamat: {{ $reservation->end_at }}</li>
                        @if ($reservation->isApproved())
                            <li class="list-group-item"><b>Pemandu</b>
                                <dl class="dl-horizontal">
                                    <dt>Nama</dt>
                                    <dd><a href="{{ route('drivers.show', $reservation->driver) }}">{{ $reservation->driver->name }}</a></dd>
                                    <dt>Telefon</dt>
                                    <dd>{{ $reservation->driver->phone }}</dd>
                                    <dt>E-mel</dt>
                                    <dd>{{ $reservation->driver->email }}</dd>
                                </dl>
                            </li>
                            <li class="list-group-item"><b>Kenderaan</b>
                            <dl class="dl-horizontal">
                                <dt>Nama</dt>
                                <dd><a href="{{ route('vehicles.show', $reservation->vehicle) }}">{{ $reservation->vehicle->registration_no }}</a></dd>
                                <dt>Jenis</dt>
                                <dd>{{ $reservation->vehicle->types  }}</dd>
                                <dt>Model</dt>
                                <dd>{{ $reservation->vehicle->model }}</dd>
                            </dl>
                        @endif
                    </ul>

                <div class="panel-footer"><h3><span class="label label-{{ $reservation->status_class }}">{{ $reservation->status }}</span></h3></div>

            </div>
        </div>
    </div>
</div>
@endsection
