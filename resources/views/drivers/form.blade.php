<div class="form-group">
    {!! Form::label('name', 'Nama', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('name', null, [
            'class' => 'form-control',
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'E-mel', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::email('email', null, [
            'class' => 'form-control',
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('phone', 'Telefon', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('phone', null, [
            'class' => 'form-control'
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('image', 'Gambar', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::file('image'); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submit, ['class' => 'btn btn-primary']); !!}
    </div>
</div>