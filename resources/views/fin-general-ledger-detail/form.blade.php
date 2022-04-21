<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('coa_id') }}
            {{ Form::text('coa_id', $finGeneralLedgerDetail->coa_id, ['class' => 'form-control' . ($errors->has('coa_id') ? ' is-invalid' : ''), 'placeholder' => 'Coa Id']) }}
            {!! $errors->first('coa_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('debit') }}
            {{ Form::text('debit', $finGeneralLedgerDetail->debit, ['class' => 'form-control' . ($errors->has('debit') ? ' is-invalid' : ''), 'placeholder' => 'Debit']) }}
            {!! $errors->first('debit', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('credit') }}
            {{ Form::text('credit', $finGeneralLedgerDetail->credit, ['class' => 'form-control' . ($errors->has('credit') ? ' is-invalid' : ''), 'placeholder' => 'Credit']) }}
            {!! $errors->first('credit', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('created_date') }}
            {{ Form::text('created_date', $finGeneralLedgerDetail->created_date, ['class' => 'form-control' . ($errors->has('created_date') ? ' is-invalid' : ''), 'placeholder' => 'Created Date']) }}
            {!! $errors->first('created_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>