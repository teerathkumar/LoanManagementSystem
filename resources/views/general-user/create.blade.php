@extends('layouts.master')
@section('page_title', 'General User')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create General User</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('general-users.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('general-user.form')

            </form>
        </div>
    </div>

@endsection
