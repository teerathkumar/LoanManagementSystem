@extends('layouts.master')
@section('page_title', 'Financing Status')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Financing Status</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-statuses.update', $loanStatus->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-status.form')

                        </form>
                    </div>
                </div>
@endsection
