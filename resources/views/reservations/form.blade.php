<div class="form-group">
    {!! Form::label('reason', 'Tujuan', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::textarea('reason', null, [
            'class' => 'form-control',
            'rows' => 3
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('start_at', 'Tarikh Mula', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('start_at', (isset($create['start_at']) ? $create['start_at'] : null), [
            'class' => 'form-control datetimepicker'
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('end_at', 'Tarikh Tamat', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('end_at', (isset($create['end_at']) ? $create['end_at'] : null), [
            'class' => 'form-control datetimepicker'
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('destination', 'Destinasi', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::textarea('destination', null, [
            'class' => 'form-control',
            'rows' => 5
        ]); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submit, ['class' => 'btn btn-primary']); !!}
    </div>
</div>