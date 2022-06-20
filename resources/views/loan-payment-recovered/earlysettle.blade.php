@extends('layouts.master')
@section('page_title', 'Financing Payment Recovered')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Financing Payment Recovered</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-payment-recovereds.earlypay') }}"  role="form" enctype="multipart/form-data">
                @csrf

<div class="box box-info padding-1">
    <div class="box-body">
              
        <div class="form-group ">
            <span>
                Settlement Outstanding: <strong>{{ number_format($outstanding,0) }}</strong> <br>
                Profit for {{ $days_diff }} days: <strong>{{ number_format($Profit,0) }} </strong><br>
                Settlement Charges: <strong>{{ number_format($SettlementCharges,0) }} </strong><br>
                FED on Settlement Charges: <strong>{{ number_format($FED,0) }} </strong><br>
                Total Settlement Amount: <strong>{{ number_format($TotalSettlement,0) }} </strong><br>
            </span>
                        
            
            <input type="hidden" id="loanId" name="loanId" value="{{ $loanId }}" />
            
        </div>
        <div class="form-group">
            {{ Form::label('Settlement Outstanding') }}
            {{ Form::text('amount_outstanding', $outstanding, ['class' => 'form-control' . ($errors->has('amount_total') ? ' is-invalid' : ''), 'placeholder' => 'Amount Total']) }}
            {!! $errors->first('amount_total', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Profit for '. $days_diff .' days') }}
            {{ Form::text('amount_profit', $Profit, ['class' => 'form-control' . ($errors->has('amount_profit') ? ' is-invalid' : ''), 'placeholder' => 'Amount Profit']) }}
            {!! $errors->first('amount_profit', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Settlement Charges') }}
            {{ Form::text('amount_settlement', $SettlementCharges, ['class' => 'form-control' . ($errors->has('amount_settlement') ? ' is-invalid' : ''), 'placeholder' => 'Amount Settlement']) }}
            {!! $errors->first('amount_settlement', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('FED Amount') }}
            {{ Form::text('amount_fed', $FED, ['class' => 'form-control' . ($errors->has('amount_fed') ? ' is-invalid' : ''), 'placeholder' => 'Amount FED']) }}
            {!! $errors->first('amount_fed', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Collected Amount') }}
            {{ Form::text('amount_total', $TotalSettlement, ['class' => 'form-control' . ($errors->has('amount_total') ? ' is-invalid' : ''), 'placeholder' => 'Amount Total']) }}
            {!! $errors->first('amount_total', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
            </form>
        </div>
    </div>

@endsection
