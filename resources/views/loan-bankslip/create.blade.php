@extends('layouts.master')
@section('page_title', 'Financing Bankslip')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Financing Bankslip</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-bankslips.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-bankslip.form')

            </form>
        </div>
    </div>

@endsection
