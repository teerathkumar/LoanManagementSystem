@extends('layouts.master')
@section('page_title', 'Loan Type')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Loan Type</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-types.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-type.form')

            </form>
        </div>
    </div>

@endsection
