@extends('layouts.master')
@section('page_title', 'Fin Checkbook')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fin Checkbook</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fin-checkbooks.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Checkbook Title:</strong>
                            {{ $finCheckbook->checkbook_title }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Id:</strong>
                            {{ $finCheckbook->bank_id }}
                        </div>
                        <div class="form-group">
                            <strong>Checknum Start:</strong>
                            {{ $finCheckbook->checknum_start }}
                        </div>
                        <div class="form-group">
                            <strong>Checknum End:</strong>
                            {{ $finCheckbook->checknum_end }}
                        </div>

                    </div>
                </div>

@endsection
