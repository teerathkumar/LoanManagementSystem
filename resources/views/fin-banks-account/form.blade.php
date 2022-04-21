<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('bank_name') }}
            {{ Form::text('bank_name', $finBanksAccount->bank_name, ['class' => 'form-control' . ($errors->has('bank_name') ? ' is-invalid' : ''), 'placeholder' => 'Bank Name']) }}
            {!! $errors->first('bank_name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bank_account') }}
            {{ Form::text('bank_account', $finBanksAccount->bank_account, ['class' => 'form-control' . ($errors->has('bank_account') ? ' is-invalid' : ''), 'placeholder' => 'Bank Account']) }}
            {!! $errors->first('bank_account', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('trans_amount') }}
            {{ Form::text('trans_amount', $finBanksAccount->trans_amount, ['class' => 'form-control' . ($errors->has('trans_amount') ? ' is-invalid' : ''), 'placeholder' => 'Trans Amount']) }}
            {!! $errors->first('trans_amount', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('slip_date') }}
            {{ Form::text('slip_date', $finBanksAccount->slip_date, ['class' => 'form-control' . ($errors->has('slip_date') ? ' is-invalid' : ''), 'placeholder' => 'Slip Date']) }}
            {!! $errors->first('slip_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>