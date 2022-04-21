@extends('layouts.master')
@section('page_title', 'Fin General Ledger')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fin General Ledger</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fin-general-ledgers.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Slip Id:</strong>
                            {{ $finGeneralLedger->slip_id }}
                        </div>
                        <div class="form-group">
                            <strong>User Id:</strong>
                            {{ $finGeneralLedger->user_id }}
                        </div>
                        <div class="form-group">
                            <strong>Debit:</strong>
                            {{ $finGeneralLedger->debit }}
                        </div>
                        <div class="form-group">
                            <strong>Credit:</strong>
                            {{ $finGeneralLedger->credit }}
                        </div>
                        <div class="form-group">
                            <strong>Txn Date:</strong>
                            {{ $finGeneralLedger->txn_date }}
                        </div>
                        <div class="form-group">
                            <strong>Reference:</strong>
                            {{ $finGeneralLedger->reference }}
                        </div>
                        <div class="form-group">
                            <strong>Office Id:</strong>
                            {{ $finGeneralLedger->office_id }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $finGeneralLedger->created_date }}
                        </div>

                    </div>
                </div>

@endsection
