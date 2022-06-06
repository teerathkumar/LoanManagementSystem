<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('loan_id') }}
            {{ Form::text('loan_id', $loanKiborHistory->loan_id, ['class' => 'form-control' . ($errors->has('loan_id') ? ' is-invalid' : ''), 'placeholder' => 'Loan Id']) }}
            {!! $errors->first('loan_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('kibor_rate_id') }}
            {{ Form::text('kibor_rate_id', $loanKiborHistory->kibor_rate_id, ['class' => 'form-control' . ($errors->has('kibor_rate_id') ? ' is-invalid' : ''), 'placeholder' => 'Kibor Rate Id']) }}
            {!! $errors->first('kibor_rate_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('start_date') }}
            {{ Form::text('start_date', $loanKiborHistory->start_date, ['class' => 'form-control' . ($errors->has('start_date') ? ' is-invalid' : ''), 'placeholder' => 'Start Date']) }}
            {!! $errors->first('start_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('end_date') }}
            {{ Form::text('end_date', $loanKiborHistory->end_date, ['class' => 'form-control' . ($errors->has('end_date') ? ' is-invalid' : ''), 'placeholder' => 'End Date']) }}
            {!! $errors->first('end_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $loanKiborHistory->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>