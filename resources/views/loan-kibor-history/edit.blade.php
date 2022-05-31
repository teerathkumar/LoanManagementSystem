@extends('layouts.master')
@section('page_title', 'Loan Kibor History')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Kibor History</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-kibor-histories.update', $loanKiborHistory->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-kibor-history.form')

                        </form>
                    </div>
                </div>
@endsection
