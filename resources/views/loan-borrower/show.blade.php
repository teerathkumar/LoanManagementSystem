@extends('layouts.master')
@section('page_title', 'Loan Borrower')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Borrower</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-borrowers.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fname:</strong>
                            {{ $loanBorrower->fname }}
                        </div>
                        <div class="form-group">
                            <strong>Mname:</strong>
                            {{ $loanBorrower->mname }}
                        </div>
                        <div class="form-group">
                            <strong>Lname:</strong>
                            {{ $loanBorrower->lname }}
                        </div>
                        <div class="form-group">
                            <strong>Gender:</strong>
                            {{ $loanBorrower->gender }}
                        </div>
                        <div class="form-group">
                            <strong>Dob:</strong>
                            {{ $loanBorrower->dob }}
                        </div>
                        <div class="form-group">
                            <strong>Caste:</strong>
                            {{ $loanBorrower->caste }}
                        </div>
                        <div class="form-group">
                            <strong>Cnic:</strong>
                            {{ $loanBorrower->cnic }}
                        </div>
                        <div class="form-group">
                            <strong>Mobile:</strong>
                            {{ $loanBorrower->mobile }}
                        </div>
                        <div class="form-group">
                            <strong>Address:</strong>
                            {{ $loanBorrower->address }}
                        </div>

                    </div>
                </div>

@endsection
