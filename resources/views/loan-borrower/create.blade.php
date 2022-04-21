@extends('layouts.master')
@section('page_title', 'Loan Borrower')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Loan Borrower</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-borrowers.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-borrower.form')

            </form>
        </div>
    </div>

@endsection
