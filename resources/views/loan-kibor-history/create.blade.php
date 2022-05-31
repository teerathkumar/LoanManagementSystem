@extends('layouts.master')
@section('page_title', 'Loan Kibor History')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Loan Kibor History</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-kibor-histories.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-kibor-history.form')

            </form>
        </div>
    </div>

@endsection
