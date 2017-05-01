@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <h1 class="page-header">Tempahan Baru</h1>

            @include('partials.messages')

            {!! Form::open([
                'route' => 'reservations.store',
                'class' => 'form-horizontal'
            ]) !!}

           @include('reservations.form', $create)

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
