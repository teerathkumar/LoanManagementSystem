@extends('layouts.master')
@section('page_title', 'Fin Checkbook')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Fin Checkbook</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('fin-checkbooks.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('fin-checkbook.form')

            </form>
        </div>
    </div>

@endsection
