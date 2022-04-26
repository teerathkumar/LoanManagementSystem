@extends('layouts.master')
@section('page_title', 'Fin Checkbook')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Fin Checkbook</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fin-checkbooks.update', $finCheckbook->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('fin-checkbook.form')

                        </form>
                    </div>
                </div>
@endsection
