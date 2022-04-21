@extends('layouts.master')
@section('page_title', 'Financial Report (Test)')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Financial Report (Test)</span>
    </div>
    <div class="card-body">
        @if(isset($datef))

        <fieldset>
            <legend>Report Criteria:</legend>
            <span class="card-title">Generated from {{ $datef }} to {{ $datet }}</span>
            <br><br>
        </fieldset>


        @foreach($ReportData as $ReportRow)
        <table class="col-sm-12">
            <thead style="background-color: #97D35D;">

                <tr class="datatable-header center" style="padding: 4px;">
                    <th width="5%">Sr.#</th>
                    <th width="20%">Code</th>
                    <th width="40%">Descriptions</th>
                    <th width="15%">Transaction</th>
                    <th  style="text-align:right" width="10%">Debit</th>
                    <th style="text-align:right" width="10%">Credit</th>
                    
                </tr>
            </thead>
            <tbody>
<?php $GrandDebit=0 ?>               
<?php $GrandCredit=0 ?>                
<?php $i=0 ?>
                @foreach($ReportRow as $Row)
                <tr  class="border-blue">
                    <td>{{ ++$i }}</td>
                    <td>{{ $Row->code }}</td>
                    <td>{{ $Row->title }}</td>
                    <td>{{ date("M j, Y", strtotime($Row->txn_date)) }}</td>
                    <td align="right">{{ number_format($Row->debit) }}</td>
                    <td align="right">{{ number_format($Row->credit) }}</td>
                    
                </tr>
                
<?php $GrandDebit+=$Row->debit ?>                
<?php $GrandCredit+=$Row->credit ?>                
                @endforeach
                
                <tr  class="border-blue" style="border-color: #97D35D;border-width: 2px 0px 2px 0px;border-style: double;">
                    <td colspan="4">Total</td>
                    <td align="right">{{ number_format($GrandDebit) }}</td>
                    <td align="right">{{ number_format($GrandCredit) }}</td>
                </tr> 
            </tbody>
        </table><br><br>
        @endforeach


        @else

        <form method="POST" action="{{ route('reports.financialreport') }}"  role="form" enctype="multipart/form-data">
            @csrf

            <div class="box box-info padding-1 col-sm-6">
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Date From:') }}
                        {{ Form::date('datefrom', null, ['class' => 'form-control' . ($errors->has('datefrom') ? ' is-invalid' : ''), 'placeholder' => 'Date From:']) }}
                        {!! $errors->first('due_id', '<p class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Date To:') }}
                        {{ Form::date('dateto', null, ['class' => 'form-control' . ($errors->has('dateto') ? ' is-invalid' : ''), 'placeholder' => 'Date To:']) }}
                        {!! $errors->first('loan_id', '<p class="invalid-feedback">:message</p>') !!}
                    </div>

                </div>
                <div class="box-footer mt20">
                    <button type="submit" class="btn btn-primary col-sm-12">Generate</button>
                </div>
            </div>
        </form>

        @endif
    </div>
</div>

@endsection
