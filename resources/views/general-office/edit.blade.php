@extends('layouts.master')
@section('page_title', 'General Office')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update General Office</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('general-offices.update', $generalOffice->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('general-office.form')

                        </form>
                    </div>
                </div>
@endsection
