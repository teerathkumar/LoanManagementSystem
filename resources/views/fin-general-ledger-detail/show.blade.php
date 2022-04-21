@extends('layouts.master')
@section('page_title', 'Fin General Ledger Detail')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fin General Ledger Detail</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fin-general-ledger-details.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Coa Id:</strong>
                            {{ $finGeneralLedgerDetail->coa_id }}
                        </div>
                        <div class="form-group">
                            <strong>Debit:</strong>
                            {{ $finGeneralLedgerDetail->debit }}
                        </div>
                        <div class="form-group">
                            <strong>Credit:</strong>
                            {{ $finGeneralLedgerDetail->credit }}
                        </div>
                        <div class="form-group">
                            <strong>Created Date:</strong>
                            {{ $finGeneralLedgerDetail->created_date }}
                        </div>

                    </div>
                </div>

@endsection
