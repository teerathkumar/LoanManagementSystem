@extends('layouts.master')
@section('page_title', 'Loan Payment Recovered')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Payment Recovered</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-payment-recovereds.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Due Id:</strong>
                            {{ $loanPaymentRecovered->due_id }}
                        </div>
                        <div class="form-group">
                            <strong>Loan Id:</strong>
                            {{ $loanPaymentRecovered->loan_id }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Total:</strong>
                            {{ $loanPaymentRecovered->amount_total }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Pr:</strong>
                            {{ $loanPaymentRecovered->amount_pr }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Mu:</strong>
                            {{ $loanPaymentRecovered->amount_mu }}
                        </div>
                        <div class="form-group">
                            <strong>Amount Penalty:</strong>
                            {{ $loanPaymentRecovered->amount_penalty }}
                        </div>
                        <div class="form-group">
                            <strong>Recovered By:</strong>
                            {{ $loanPaymentRecovered->recovered_by }}
                        </div>
                        <div class="form-group">
                            <strong>Recovered Date:</strong>
                            {{ $loanPaymentRecovered->recovered_date }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Slip Id:</strong>
                            {{ $loanPaymentRecovered->bank_slip_id }}
                        </div>

                    </div>
                </div>

@endsection
