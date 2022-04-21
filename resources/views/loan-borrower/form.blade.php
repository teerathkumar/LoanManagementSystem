<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('fname') }}
            {{ Form::text('fname', $loanBorrower->fname, ['class' => 'form-control' . ($errors->has('fname') ? ' is-invalid' : ''), 'placeholder' => 'Fname']) }}
            {!! $errors->first('fname', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('mname') }}
            {{ Form::text('mname', $loanBorrower->mname, ['class' => 'form-control' . ($errors->has('mname') ? ' is-invalid' : ''), 'placeholder' => 'Mname']) }}
            {!! $errors->first('mname', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('lname') }}
            {{ Form::text('lname', $loanBorrower->lname, ['class' => 'form-control' . ($errors->has('lname') ? ' is-invalid' : ''), 'placeholder' => 'Lname']) }}
            {!! $errors->first('lname', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gender') }}
            {{ Form::text('gender', $loanBorrower->gender, ['class' => 'form-control' . ($errors->has('gender') ? ' is-invalid' : ''), 'placeholder' => 'Gender']) }}
            {!! $errors->first('gender', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('dob') }}
            {{ Form::text('dob', $loanBorrower->dob, ['class' => 'form-control' . ($errors->has('dob') ? ' is-invalid' : ''), 'placeholder' => 'Dob']) }}
            {!! $errors->first('dob', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('caste') }}
            {{ Form::text('caste', $loanBorrower->caste, ['class' => 'form-control' . ($errors->has('caste') ? ' is-invalid' : ''), 'placeholder' => 'Caste']) }}
            {!! $errors->first('caste', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cnic') }}
            {{ Form::text('cnic', $loanBorrower->cnic, ['class' => 'form-control' . ($errors->has('cnic') ? ' is-invalid' : ''), 'placeholder' => 'Cnic']) }}
            {!! $errors->first('cnic', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('mobile') }}
            {{ Form::text('mobile', $loanBorrower->mobile, ['class' => 'form-control' . ($errors->has('mobile') ? ' is-invalid' : ''), 'placeholder' => 'Mobile']) }}
            {!! $errors->first('mobile', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('address') }}
            {{ Form::text('address', $loanBorrower->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => 'Address']) }}
            {!! $errors->first('address', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>