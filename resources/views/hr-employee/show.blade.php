@extends('layouts.master')
@section('page_title', 'Hr Employee')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Hr Employee</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('hr-employees.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fname:</strong>
                            {{ $hrEmployee->fname }}
                        </div>
                        <div class="form-group">
                            <strong>Lname:</strong>
                            {{ $hrEmployee->lname }}
                        </div>
                        <div class="form-group">
                            <strong>Fathers Name:</strong>
                            {{ $hrEmployee->fathers_name }}
                        </div>
                        <div class="form-group">
                            <strong>Dob:</strong>
                            {{ $hrEmployee->dob }}
                        </div>
                        <div class="form-group">
                            <strong>Address:</strong>
                            {{ $hrEmployee->address }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Account Number:</strong>
                            {{ $hrEmployee->bank_account_number }}
                        </div>
                        <div class="form-group">
                            <strong>Mobile:</strong>
                            {{ $hrEmployee->mobile }}
                        </div>
                        <div class="form-group">
                            <strong>Cnic:</strong>
                            {{ $hrEmployee->cnic }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $hrEmployee->created_date }}
                        </div>

                    </div>
                </div>

@endsection
