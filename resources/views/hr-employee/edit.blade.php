@extends('layouts.master')
@section('page_title', 'Hr Employee')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Hr Employee</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hr-employees.update', $hrEmployee->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('hr-employee.form')

                        </form>
                    </div>
                </div>
@endsection
