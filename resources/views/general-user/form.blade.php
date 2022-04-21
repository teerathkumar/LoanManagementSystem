<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('emp_id') }}
            {{ Form::text('emp_id', $generalUser->emp_id, ['class' => 'form-control' . ($errors->has('emp_id') ? ' is-invalid' : ''), 'placeholder' => 'Emp Id']) }}
            {!! $errors->first('emp_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('user_type_id') }}
            {{ Form::text('user_type_id', $generalUser->user_type_id, ['class' => 'form-control' . ($errors->has('user_type_id') ? ' is-invalid' : ''), 'placeholder' => 'User Type Id']) }}
            {!! $errors->first('user_type_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('user_name') }}
            {{ Form::text('user_name', $generalUser->user_name, ['class' => 'form-control' . ($errors->has('user_name') ? ' is-invalid' : ''), 'placeholder' => 'User Name']) }}
            {!! $errors->first('user_name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('token') }}
            {{ Form::text('token', $generalUser->token, ['class' => 'form-control' . ($errors->has('token') ? ' is-invalid' : ''), 'placeholder' => 'Token']) }}
            {!! $errors->first('token', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('created_date') }}
            {{ Form::text('created_date', $generalUser->created_date, ['class' => 'form-control' . ($errors->has('created_date') ? ' is-invalid' : ''), 'placeholder' => 'Created Date']) }}
            {!! $errors->first('created_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>