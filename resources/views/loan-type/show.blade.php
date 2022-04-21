@extends('layouts.master')
@section('page_title', 'Loan Type')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Loan Type</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('loan-types.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $loanType->name }}
                        </div>
                        <div class="form-group">
                            <strong>Parent Id:</strong>
                            {{ $loanType->parent_id }}
                        </div>
                        <div class="form-group">
                            <strong>Createdon:</strong>
                            {{ $loanType->createdOn }}
                        </div>

                    </div>
                </div>

@endsection
