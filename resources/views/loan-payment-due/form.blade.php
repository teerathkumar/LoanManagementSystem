<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('loan_id') }}
            {{ Form::text('loan_id', $loanPaymentDue->loan_id, ['class' => 'form-control' . ($errors->has('loan_id') ? ' is-invalid' : ''), 'placeholder' => 'Loan Id']) }}
            {!! $errors->first('loan_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('installment_no') }}
            {{ Form::text('installment_no', $loanPaymentDue->installment_no, ['class' => 'form-control' . ($errors->has('installment_no') ? ' is-invalid' : ''), 'placeholder' => 'Installment No']) }}
            {!! $errors->first('installment_no', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('due_date') }}
            {{ Form::text('due_date', $loanPaymentDue->due_date, ['class' => 'form-control' . ($errors->has('due_date') ? ' is-invalid' : ''), 'placeholder' => 'Due Date']) }}
            {!! $errors->first('due_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_total') }}
            {{ Form::text('amount_total', $loanPaymentDue->amount_total, ['class' => 'form-control' . ($errors->has('amount_total') ? ' is-invalid' : ''), 'placeholder' => 'Amount Total']) }}
            {!! $errors->first('amount_total', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_pr') }}
            {{ Form::text('amount_pr', $loanPaymentDue->amount_pr, ['class' => 'form-control' . ($errors->has('amount_pr') ? ' is-invalid' : ''), 'placeholder' => 'Amount Pr']) }}
            {!! $errors->first('amount_pr', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_mu') }}
            {{ Form::text('amount_mu', $loanPaymentDue->amount_mu, ['class' => 'form-control' . ($errors->has('amount_mu') ? ' is-invalid' : ''), 'placeholder' => 'Amount Mu']) }}
            {!! $errors->first('amount_mu', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('amount_penalty') }}
            {{ Form::text('amount_penalty', $loanPaymentDue->amount_penalty, ['class' => 'form-control' . ($errors->has('amount_penalty') ? ' is-invalid' : ''), 'placeholder' => 'Amount Penalty']) }}
            {!! $errors->first('amount_penalty', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('payment_status') }}
            {{ Form::text('payment_status', $loanPaymentDue->payment_status, ['class' => 'form-control' . ($errors->has('payment_status') ? ' is-invalid' : ''), 'placeholder' => 'Payment Status']) }}
            {!! $errors->first('payment_status', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>