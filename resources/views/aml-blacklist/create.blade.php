@extends('layouts.master')
@section('page_title', 'Aml Blacklist')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Aml Blacklist</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('aml-blacklists.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('aml-blacklist.form')

            </form>
        </div>
    </div>

@endsection
