@extends('layouts.master')
@section('page_title', 'Loan Status')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Status</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-statuses.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $loanStatus->title }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $loanStatus->status }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $loanStatus->created_date }}
                        </div>

                    </div>
                </div>

@endsection
