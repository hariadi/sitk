@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>
        .panel-heading .accordion-toggle:after {
            /* symbol for "opening" panels */
            font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
            content: "\e114";    /* adjust as needed, taken from bootstrap.css */
            float: right;        /* adjust as needed */
            color: grey;         /* adjust as needed */
        }
        .panel-heading .accordion-toggle.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\e080";    /* adjust as needed, taken from bootstrap.css */
        }
    </style>
@endpush
@section('content')
<div class="container">

    <h3 class="page-header">Senarai Permohonan</h3>

    @include('partials.messages')

    <div class="row">
        <div class="col-md-9">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                @foreach ($reservations as $reservation)
                    <div class="panel panel-{{ $reservation->status_class }}">

                        <div class="panel-heading" role="tab" id="heading{{ $reservation->id }}">
                            <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $reservation->id }}" aria-expanded="true" aria-controls="collapse{{ $reservation->id }}">
                                <span class="label label-{{ $reservation->status_class }}">{{ array_search($reservation->status, $statuses) }}</span>
                                {{ $reservation->destination }}

                            </a>
                            </h4>
                        </div>

                        <div id="collapse{{ $reservation->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $reservation->id }}">

                                <ul class="list-group">
                                    <li class="list-group-item">{{ $reservation->reason }}</li>
                                    <li class="list-group-item">Tarikh Tempahan: {{ $reservation->created_at }}</li>
                                    <li class="list-group-item">Mula: {{ $reservation->start_at }}</li>
                                    <li class="list-group-item">Tamat: {{ $reservation->end_at }}</li>

                                    @if ($reservation->approved_id)
                                        <li class="list-group-item">Mula: {{ $reservation->approved }}</li>
                                        <li class="list-group-item">Tamat: {{ $reservation->approved_at }}</li>

                                    @endif

                                    @if ($reservation->isApproved())
                                        <li class="list-group-item">Pemandu: <a href="{{ route('drivers.show', $reservation->driver) }}">{{ $reservation->driver->name }}</a> ({{ $reservation->driver->phone }})</li>
                                        <li class="list-group-item">Kenderaan: <a href="{{ route('vehicles.show', $reservation->vehicle) }}">{{ $reservation->vehicle->registration_no }}</a></li>
                                    @endif
                                </ul>

                            <div class="panel-footer"><h3><span class="label label-{{ $reservation->status_class }}">{{ $reservation->status }}</span></h3></div>

                        </div>

                    </div>
                @endforeach

            </div>
            {{ $reservations->appends(request()->except('page'))->links() }}
        </div><!-- /.col-md-9 -->

        <div class="col-md-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Status Tempahan</div>
                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ route('dashboard') }}">Semua</a></li>
                    @foreach($statuses as $label => $status)
                    <li class="list-group-item">
                        <span class="label label-{{ $labels[$label] }}">{{ $label }}</span>
                        <a href="?status={{ $status }}">{{ $status}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div><!-- /.col-md-3 -->
    </div>
</div>
@endsection