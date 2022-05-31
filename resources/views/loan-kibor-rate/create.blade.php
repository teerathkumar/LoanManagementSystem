@extends('layouts.master')
@section('page_title', 'Loan Kibor Rate')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Loan Kibor Rate</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-kibor-rates.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-kibor-rate.form')

            </form>
        </div>
    </div>

@endsection
