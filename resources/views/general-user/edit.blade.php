@extends('layouts.master')
@section('page_title', 'General User')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update General User</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('general-users.update', $generalUser->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('general-user.form')

                        </form>
                    </div>
                </div>
@endsection
