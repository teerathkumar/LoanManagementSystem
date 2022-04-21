@extends('layouts.master')
@section('page_title', 'Fin Chart Of Account')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Fin Chart Of Account</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fin-chart-of-accounts.update', $finChartOfAccount->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('fin-chart-of-account.form')

                        </form>
                    </div>
                </div>
@endsection
