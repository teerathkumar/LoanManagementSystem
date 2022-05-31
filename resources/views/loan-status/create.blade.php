@extends('layouts.master')
@section('page_title', 'Financing Status')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Financing Status</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-statuses.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-status.form')

            </form>
        </div>
    </div>

@endsection
