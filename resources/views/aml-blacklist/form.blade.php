<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $amlBlacklist->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('guardian') }}
            {{ Form::text('guardian', $amlBlacklist->guardian, ['class' => 'form-control' . ($errors->has('guardian') ? ' is-invalid' : ''), 'placeholder' => 'Guardian']) }}
            {!! $errors->first('guardian', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cnic') }}
            {{ Form::text('cnic', $amlBlacklist->cnic, ['class' => 'form-control' . ($errors->has('cnic') ? ' is-invalid' : ''), 'placeholder' => 'Cnic']) }}
            {!! $errors->first('cnic', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('district') }}
            {{ Form::text('district', $amlBlacklist->district, ['class' => 'form-control' . ($errors->has('district') ? ' is-invalid' : ''), 'placeholder' => 'District']) }}
            {!! $errors->first('district', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('province') }}
            {{ Form::text('province', $amlBlacklist->province, ['class' => 'form-control' . ($errors->has('province') ? ' is-invalid' : ''), 'placeholder' => 'Province']) }}
            {!! $errors->first('province', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $amlBlacklist->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>