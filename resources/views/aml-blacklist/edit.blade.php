@extends('layouts.master')
@section('page_title', 'Aml Blacklist')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Aml Blacklist</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('aml-blacklists.update', $amlBlacklist->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('aml-blacklist.form')

                        </form>
                    </div>
                </div>
@endsection
