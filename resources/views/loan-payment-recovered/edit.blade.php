@extends('layouts.master')
@section('page_title', 'Financing Payment Recovered')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Financing Payment Recovered</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-payment-recovereds.update', $loanPaymentRecovered->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-payment-recovered.form')

                        </form>
                    </div>
                </div>
@endsection
