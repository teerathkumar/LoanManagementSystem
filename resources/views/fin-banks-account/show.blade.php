@extends('layouts.master')
@section('page_title', 'Fin Banks Account')

@section('content')
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fin Banks Account</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fin-banks-accounts.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Bank Name:</strong>
                            {{ $finBanksAccount->bank_name }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Account:</strong>
                            {{ $finBanksAccount->bank_account }}
                        </div>
                        <div class="form-group">
                            <strong>Trans Amount:</strong>
                            {{ $finBanksAccount->trans_amount }}
                        </div>
                        <div class="form-group">
                            <strong>Slip Date:</strong>
                            {{ $finBanksAccount->slip_date }}
                        </div>

                    </div>
                </div>

@endsection
