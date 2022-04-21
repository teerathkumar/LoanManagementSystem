@extends('layouts.master')
@section('page_title', 'Loan Borrower')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Borrower</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-borrowers.update', $loanBorrower->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-borrower.form')

                        </form>
                    </div>
                </div>
@endsection
