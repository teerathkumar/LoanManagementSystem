@extends('layouts.master')
@section('page_title', 'Fin Banks Account')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Fin Banks Account</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('fin-banks-accounts.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('fin-banks-account.form')

            </form>
        </div>
    </div>

@endsection
