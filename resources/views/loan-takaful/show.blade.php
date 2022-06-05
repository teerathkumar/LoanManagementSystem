@extends('layouts.master')
@section('page_title', 'Loan Takaful')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Takaful</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-takafuls.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Start Date:</strong>
                            {{ $loanTakaful->start_date }}
                        </div>
                        <div class="form-group">
                            <strong>End Date:</strong>
                            {{ $loanTakaful->end_date }}
                        </div>
                        <div class="form-group">
                            <strong>Policy Number:</strong>
                            {{ $loanTakaful->policy_number }}
                        </div>
                        <div class="form-group">
                            <strong>Renewal Date:</strong>
                            {{ $loanTakaful->renewal_date }}
                        </div>

                    </div>
                </div>

@endsection
