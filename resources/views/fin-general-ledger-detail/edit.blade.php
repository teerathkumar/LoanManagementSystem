@extends('layouts.master')
@section('page_title', 'Fin General Ledger Detail')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Fin General Ledger Detail</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fin-general-ledger-details.update', $finGeneralLedgerDetail->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('fin-general-ledger-detail.form')

                        </form>
                    </div>
                </div>
@endsection
