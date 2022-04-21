@extends('layouts.master')
@section('page_title', 'Fin Banks Account')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Fin Banks Account</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fin-banks-accounts.update', $finBanksAccount->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('fin-banks-account.form')

                        </form>
                    </div>
                </div>
@endsection
