@extends('layouts.master')
@section('page_title', 'Hr Job')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Hr Job</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hr-jobs.update', $hrJob->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('hr-job.form')

                        </form>
                    </div>
                </div>
@endsection
