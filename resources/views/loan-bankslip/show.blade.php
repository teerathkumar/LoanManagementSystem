@extends('layouts.master')
@section('page_title', 'Loan Bankslip')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Bankslip</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-bankslips.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $loanBankslip->name }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $loanBankslip->amount }}
                        </div>
                        <div class="form-group">
                            <strong>Bankaccountid:</strong>
                            {{ $loanBankslip->bankAccountId }}
                        </div>

                    </div>
                </div>

@endsection
