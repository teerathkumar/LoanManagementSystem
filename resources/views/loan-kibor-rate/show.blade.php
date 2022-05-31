@extends('layouts.master')
@section('page_title', 'Loan Kibor Rate')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Kibor Rate</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-kibor-rates.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Kibor Rate:</strong>
                            {{ $loanKiborRate->kibor_rate }}
                        </div>
                        <div class="form-group">
                            <strong>Spread Rate:</strong>
                            {{ $loanKiborRate->spread_rate }}
                        </div>
                        <div class="form-group">
                            <strong>Start Date:</strong>
                            {{ $loanKiborRate->start_date }}
                        </div>
                        <div class="form-group">
                            <strong>End Date:</strong>
                            {{ $loanKiborRate->end_date }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $loanKiborRate->status }}
                        </div>

                    </div>
                </div>

@endsection
