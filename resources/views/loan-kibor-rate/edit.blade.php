@extends('layouts.master')
@section('page_title', 'Loan Kibor Rate')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Kibor Rate</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-kibor-rates.update', $loanKiborRate->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-kibor-rate.form')

                        </form>
                    </div>
                </div>
@endsection
