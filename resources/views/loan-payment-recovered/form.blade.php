<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('due_id') }}
            {{ Form::text('due_id', $loanPaymentRecovered->due_id, ['class' => 'form-control' . ($errors->has('due_id') ? ' is-invalid' : ''), 'placeholder' => 'Due Id']) }}
            {!! $errors->first('due_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('loan_id') }}
            {{ Form::text('loan_id', $loanPaymentRecovered->loan_id, ['class' => 'form-control' . ($errors->has('loan_id') ? ' is-invalid' : ''), 'placeholder' => 'Loan Id']) }}
            {!! $errors->first('loan_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_total') }}
            {{ Form::text('amount_total', $loanPaymentRecovered->amount_total, ['class' => 'form-control' . ($errors->has('amount_total') ? ' is-invalid' : ''), 'placeholder' => 'Amount Total']) }}
            {!! $errors->first('amount_total', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_pr') }}
            {{ Form::text('amount_pr', $loanPaymentRecovered->amount_pr, ['class' => 'form-control' . ($errors->has('amount_pr') ? ' is-invalid' : ''), 'placeholder' => 'Amount Pr']) }}
            {!! $errors->first('amount_pr', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_mu') }}
            {{ Form::text('amount_mu', $loanPaymentRecovered->amount_mu, ['class' => 'form-control' . ($errors->has('amount_mu') ? ' is-invalid' : ''), 'placeholder' => 'Amount Mu']) }}
            {!! $errors->first('amount_mu', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_penalty') }}
            {{ Form::text('amount_penalty', $loanPaymentRecovered->amount_penalty, ['class' => 'form-control' . ($errors->has('amount_penalty') ? ' is-invalid' : ''), 'placeholder' => 'Amount Penalty']) }}
            {!! $errors->first('amount_penalty', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('recovered_by') }}
            {{ Form::text('recovered_by', $loanPaymentRecovered->recovered_by, ['class' => 'form-control' . ($errors->has('recovered_by') ? ' is-invalid' : ''), 'placeholder' => 'Recovered By']) }}
            {!! $errors->first('recovered_by', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('recovered_date') }}
            {{ Form::text('recovered_date', $loanPaymentRecovered->recovered_date, ['class' => 'form-control' . ($errors->has('recovered_date') ? ' is-invalid' : ''), 'placeholder' => 'Recovered Date']) }}
            {!! $errors->first('recovered_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bank_slip_id') }}
            {{ Form::text('bank_slip_id', $loanPaymentRecovered->bank_slip_id, ['class' => 'form-control' . ($errors->has('bank_slip_id') ? ' is-invalid' : ''), 'placeholder' => 'Bank Slip Id']) }}
            {!! $errors->first('bank_slip_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>