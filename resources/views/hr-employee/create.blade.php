@extends('layouts.master')
@section('page_title', 'Hr Employee')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Hr Employee</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('hr-employees.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('hr-employee.form')

            </form>
        </div>
    </div>

@endsection
