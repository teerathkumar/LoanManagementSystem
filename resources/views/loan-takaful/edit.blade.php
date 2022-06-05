@extends('layouts.master')
@section('page_title', 'Loan Takaful')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Loan Takaful</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-takafuls.update', $loanTakaful->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('loan-takaful.form')

                        </form>
                    </div>
                </div>
@endsection
