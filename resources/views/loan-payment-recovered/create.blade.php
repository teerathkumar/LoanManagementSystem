@extends('layouts.master')
@section('page_title', 'Financing Payment Recovered')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Financing Payment Recovered</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-payment-recovereds.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-payment-recovered.form')

            </form>
        </div>
    </div>

@endsection
