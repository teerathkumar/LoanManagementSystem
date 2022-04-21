@extends('layouts.master')
@section('page_title', 'Fin Chart Of Account')
@section('content')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Create Fin Chart Of Account</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('fin-chart-of-accounts.store') }}"  role="form" enctype="multipart/form-data">
                @csrf

                @include('fin-chart-of-account.form')

            </form>
        </div>
    </div>

@endsection
