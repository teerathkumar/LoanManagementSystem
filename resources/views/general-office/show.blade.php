@extends('layouts.master')
@section('page_title', 'General Office')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show General Office</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('general-offices.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $generalOffice->name }}
                        </div>
                        <div class="form-group">
                            <strong>Code:</strong>
                            {{ $generalOffice->code }}
                        </div>
                        <div class="form-group">
                            <strong>Parent Id:</strong>
                            {{ $generalOffice->parent_id }}
                        </div>

                    </div>
                </div>

@endsection
