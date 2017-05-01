<div class="form-group">
    {!! Form::label('registration_no', 'No. Pendaftaran', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('registration_no', null, [
            'class' => 'form-control',
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('types', 'Jenis', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-4">
        {!! Form::select('types', $types, null, [
            'class' => 'form-control'
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('model', 'Model', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-10">
        {!! Form::text('model', null, [
            'class' => 'form-control'
        ]); !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('capacity', 'Kapasiti', ['class' => 'col-sm-2 control-label']); !!}
    <div class="col-sm-2">
        {!! Form::text('capacity', null, [
            'class' => 'form-control'
        ]); !!}
    </div>
    <p class="help-block col-sm-offset-2 col-sm-8">Bilangan tempat duduk penumpang</p>
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