@extends('layouts.master')
@section('page_title', 'Fin General Ledger')
@section('content')

@section('content')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Fin General Ledger</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fin-general-ledgers.update', $finGeneralLedger->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('fin-general-ledger.form')

                        </form>
                    </div>
                </div>
@endsection
