@extends('layouts.master')
@section('page_title', 'Aml Blacklist')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Aml Blacklist</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('aml-blacklists.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $amlBlacklist->name }}
                        </div>
                        <div class="form-group">
                            <strong>Guardian:</strong>
                            {{ $amlBlacklist->guardian }}
                        </div>
                        <div class="form-group">
                            <strong>Cnic:</strong>
                            {{ $amlBlacklist->cnic }}
                        </div>
                        <div class="form-group">
                            <strong>District:</strong>
                            {{ $amlBlacklist->district }}
                        </div>
                        <div class="form-group">
                            <strong>Province:</strong>
                            {{ $amlBlacklist->province }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $amlBlacklist->status }}
                        </div>

                    </div>
                </div>

@endsection
