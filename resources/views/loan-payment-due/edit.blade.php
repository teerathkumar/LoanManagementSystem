@extends('layouts.master')
@section('page_title', 'Loan Payment Due')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Payment Due</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-payment-dues.update', $loanPaymentDue->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-payment-due.form')

                        </form>
                    </div>
                </div>
@endsection
