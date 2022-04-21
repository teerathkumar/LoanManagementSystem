@extends('layouts.master')
@section('page_title', 'Loan Information')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Loan Information (A/c#: {{ $data->id }})</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <label>Account Number:</label>
                <p ><strong>{{$data->id}}</strong></p>
            </div>
            <div class="col">
                <label>Borrower Name:</label>
                <p ><strong>{{$data->loan_borrower->fname." ". $data->loan_borrower->fname." ". $data->loan_borrower->fname}}</strong></p>
            </div>
            <div class="col">
                <label>Borrower CNIC:</label>
                <p><strong>{{$data->loan_borrower->cnic}}</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Account Number:</label>
                <p ><strong>{{$data->id}}</strong></p>
            </div>
            <div class="col">
                <label>Borrower Name:</label>
                <p ><strong>{{$data->loan_borrower->fname." ". $data->loan_borrower->fname." ". $data->loan_borrower->fname}}</strong></p>
            </div>
            <div class="col">
                <label>Borrower CNIC:</label>
                <p><strong>{{$data->loan_borrower->cnic}}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
