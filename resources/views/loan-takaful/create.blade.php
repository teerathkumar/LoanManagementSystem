@extends('layouts.master')
@section('page_title', 'Loan Takaful')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Loan Takaful</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('loan-takafuls.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('loan-takaful.form')

            </form>
        </div>
    </div>

@endsection
