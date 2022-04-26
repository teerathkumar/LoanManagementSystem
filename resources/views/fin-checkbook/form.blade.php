<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('checkbook_title') }}
            {{ Form::text('checkbook_title', $finCheckbook->checkbook_title, ['class' => 'form-control' . ($errors->has('checkbook_title') ? ' is-invalid' : ''), 'placeholder' => 'Checkbook Title']) }}
            {!! $errors->first('checkbook_title', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bank_id') }}
            {{ Form::text('bank_id', $finCheckbook->bank_id, ['class' => 'form-control' . ($errors->has('bank_id') ? ' is-invalid' : ''), 'placeholder' => 'Bank Id']) }}
            {!! $errors->first('bank_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('checknum_start') }}
            {{ Form::text('checknum_start', $finCheckbook->checknum_start, ['class' => 'form-control' . ($errors->has('checknum_start') ? ' is-invalid' : ''), 'placeholder' => 'Checknum Start']) }}
            {!! $errors->first('checknum_start', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('checknum_end') }}
            {{ Form::text('checknum_end', $finCheckbook->checknum_end, ['class' => 'form-control' . ($errors->has('checknum_end') ? ' is-invalid' : ''), 'placeholder' => 'Checknum End']) }}
            {!! $errors->first('checknum_end', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>