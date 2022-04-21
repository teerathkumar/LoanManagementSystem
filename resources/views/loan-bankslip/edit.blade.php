@extends('layouts.master')
@section('page_title', 'Loan Bankslip')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Bankslip</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-bankslips.update', $loanBankslip->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-bankslip.form')

                        </form>
                    </div>
                </div>
@endsection
