@extends('layouts.master')
@section('page_title', 'Financing Payment Due')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Financing Payment Due</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-payment-dues.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Financing Id:</strong>
                            {{ $loanPaymentDue->loan_id }}
                        </div>
                        <div class="form-group">
                            <strong>Installment No:</strong>
                            {{ $loanPaymentDue->installment_no }}
                        </div>
                        <div class="form-group">
                            <strong>Due Date:</strong>
                            {{ $loanPaymentDue->due_date }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Total:</strong>
                            {{ $loanPaymentDue->amount_total }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Pr:</strong>
                            {{ $loanPaymentDue->amount_pr }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Mu:</strong>
                            {{ $loanPaymentDue->amount_mu }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Penalty:</strong>
                            {{ $loanPaymentDue->amount_penalty }}
                        </div>
                        <div class="form-group">
                            <strong>Payment Status:</strong>
                            {{ $loanPaymentDue->payment_status }}
                        </div>

                    </div>
                </div>

@endsection
