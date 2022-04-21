<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('fname') }}
            {{ Form::text('fname', $hrEmployee->fname, ['class' => 'form-control' . ($errors->has('fname') ? ' is-invalid' : ''), 'placeholder' => 'Fname']) }}
            {!! $errors->first('fname', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lname') }}
            {{ Form::text('lname', $hrEmployee->lname, ['class' => 'form-control' . ($errors->has('lname') ? ' is-invalid' : ''), 'placeholder' => 'Lname']) }}
            {!! $errors->first('lname', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fathers_name') }}
            {{ Form::text('fathers_name', $hrEmployee->fathers_name, ['class' => 'form-control' . ($errors->has('fathers_name') ? ' is-invalid' : ''), 'placeholder' => 'Fathers Name']) }}
            {!! $errors->first('fathers_name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('dob') }}
            {{ Form::text('dob', $hrEmployee->dob, ['class' => 'form-control' . ($errors->has('dob') ? ' is-invalid' : ''), 'placeholder' => 'Dob']) }}
            {!! $errors->first('dob', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('address') }}
            {{ Form::text('address', $hrEmployee->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => 'Address']) }}
            {!! $errors->first('address', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('bank_account_number') }}
            {{ Form::text('bank_account_number', $hrEmployee->bank_account_number, ['class' => 'form-control' . ($errors->has('bank_account_number') ? ' is-invalid' : ''), 'placeholder' => 'Bank Account Number']) }}
            {!! $errors->first('bank_account_number', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('mobile') }}
            {{ Form::text('mobile', $hrEmployee->mobile, ['class' => 'form-control' . ($errors->has('mobile') ? ' is-invalid' : ''), 'placeholder' => 'Mobile']) }}
            {!! $errors->first('mobile', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cnic') }}
            {{ Form::text('cnic', $hrEmployee->cnic, ['class' => 'form-control' . ($errors->has('cnic') ? ' is-invalid' : ''), 'placeholder' => 'Cnic']) }}
            {!! $errors->first('cnic', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('created_date') }}
            {{ Form::text('created_date', $hrEmployee->created_date, ['class' => 'form-control' . ($errors->has('created_date') ? ' is-invalid' : ''), 'placeholder' => 'Created Date']) }}
            {!! $errors->first('created_date', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>