@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Kemaskini Tempahan</h1>

            @include('partials.messages')

            {!! Form::model($reservation, [
                'method' => 'PATCH',
                'route' => ['reservations.update', $reservation->id],
                'class' => 'form-horizontal'
            ]) !!}

            @include('reservations.form', ['submit' => 'Kemaskini'])

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $(function(){
        $('.datetimepicker').datetimepicker({
            format: 'D MMMM YYYY LT'
        });
    });
</script>
@endpush