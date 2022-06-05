<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('start_date') }}
            {{ Form::date('start_date', $loanTakaful->start_date, ['class' => 'form-control' . ($errors->has('start_date') ? ' is-invalid' : ''), 'placeholder' => 'Start Date']) }}
            {!! $errors->first('start_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('end_date') }}
            {{ Form::date('end_date', $loanTakaful->end_date, ['class' => 'form-control' . ($errors->has('end_date') ? ' is-invalid' : ''), 'placeholder' => 'End Date']) }}
            {!! $errors->first('end_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('policy_number') }}
            {{ Form::text('policy_number', $loanTakaful->policy_number, ['class' => 'form-control' . ($errors->has('policy_number') ? ' is-invalid' : ''), 'placeholder' => 'Policy Number']) }}
            {!! $errors->first('policy_number', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('renewal_date') }}
            {{ Form::date('renewal_date', $loanTakaful->renewal_date, ['class' => 'form-control' . ($errors->has('renewal_date') ? ' is-invalid' : ''), 'placeholder' => 'Renewal Date']) }}
            {!! $errors->first('renewal_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>