@extends('layouts.master')
@section('page_title', 'Fin General Ledger')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Create Fin General Ledger</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('fin-general-ledgers.store') }}" id="myform" role="form" enctype="multipart/form-data">
            @csrf

            @include('fin-general-ledger.form')

        </form>
    </div>
</div>

@endsection
