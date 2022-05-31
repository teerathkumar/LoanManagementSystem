@extends('layouts.master')
@section('page_title', 'Loan Kibor History')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Kibor History</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-kibor-histories.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Loan Id:</strong>
                            {{ $loanKiborHistory->loan_id }}
                        </div>
                        <div class="form-group">
                            <strong>Start Date:</strong>
                            {{ $loanKiborHistory->start_date }}
                        </div>
                        <div class="form-group">
                            <strong>End Date:</strong>
                            {{ $loanKiborHistory->end_date }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $loanKiborHistory->status }}
                        </div>

                    </div>
                </div>

@endsection
