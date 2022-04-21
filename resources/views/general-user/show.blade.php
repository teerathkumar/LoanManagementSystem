@extends('layouts.master')
@section('page_title', 'General User')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show General User</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('general-users.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Emp Id:</strong>
                            {{ $generalUser->emp_id }}
                        </div>
                        <div class="form-group">
                            <strong>User Type Id:</strong>
                            {{ $generalUser->user_type_id }}
                        </div>
                        <div class="form-group">
                            <strong>User Name:</strong>
                            {{ $generalUser->user_name }}
                        </div>
                        <div class="form-group">
                            <strong>Token:</strong>
                            {{ $generalUser->token }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $generalUser->created_date }}
                        </div>

                    </div>
                </div>

@endsection
