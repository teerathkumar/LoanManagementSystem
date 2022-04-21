@extends('layouts.master')
@section('page_title', 'Hr Job')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Hr Job</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('hr-jobs.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('hr-job.form')

            </form>
        </div>
    </div>

@endsection
