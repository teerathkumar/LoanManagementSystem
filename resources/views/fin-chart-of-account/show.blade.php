@extends('layouts.master')
@section('page_title', 'Fin Chart Of Account')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fin Chart Of Account</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fin-chart-of-accounts.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $finChartOfAccount->title }}
                        </div>
                        <div class="form-group">
                            <strong>Code:</strong>
                            {{ $finChartOfAccount->code }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $finChartOfAccount->created_date }}
                        </div>

                    </div>
                </div>

@endsection
