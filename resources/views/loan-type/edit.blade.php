@extends('layouts.master')
@section('page_title', 'Loan Type')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Type</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-types.update', $loanType->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-type.form')

                        </form>
                    </div>
                </div>
@endsection
