@extends('layouts.master')
@section('page_title', 'Financing Payment Due')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Financing Payment Due</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-payment-dues.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-payment-due.form')

            </form>
        </div>
    </div>

@endsection
