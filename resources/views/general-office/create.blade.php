@extends('layouts.master')
@section('page_title', 'General Office')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create General Office</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('general-offices.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('general-office.form')

            </form>
        </div>
    </div>

@endsection
