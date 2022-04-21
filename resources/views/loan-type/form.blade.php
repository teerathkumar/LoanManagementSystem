<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $loanType->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('parent_id') }}
            {{ Form::text('parent_id', $loanType->parent_id, ['class' => 'form-control' . ($errors->has('parent_id') ? ' is-invalid' : ''), 'placeholder' => 'Parent Id']) }}
            {!! $errors->first('parent_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('createdOn') }}
            {{ Form::text('createdOn', $loanType->createdOn, ['class' => 'form-control' . ($errors->has('createdOn') ? ' is-invalid' : ''), 'placeholder' => 'Createdon']) }}
            {!! $errors->first('createdOn', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>