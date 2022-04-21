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

        <table class="col-sm-12">
            <thead style="background-color: #97D35D;">
                <tr class="datatable-header center">
                    <th>Code</th>
                    <th>Title</th>
                    <th>Transaction Date</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody>

                @foreach($ReportData as $L1_Key=>$L1_ReportRow)
                <tr  class="border-blue">
                    <td>{{ $L1_Key }}</td>
                    <td colspan="2">{{ $L1[$L1_Key]['Title'] }}</td>
                    <td>{{ $L1[$L1_Key]['Title'] }}</td>
                    <td>{{ $L1[$L1_Key]['Debit'] }}</td>
                    <td>{{ $L1[$L1_Key]['Credit'] }}</td>
                </tr>
                @foreach($L1_ReportRow as $L2_Key=>$L2_ReportRow)
                <tr  class="border-blue">
                    <td>{{ $L2_Key }}</td>
                </tr>

                @foreach($L2_ReportRow as $L3_Key=>$L3_ReportRow)
                <tr  class="border-blue">
                    <td>{{ $L3_Key }}</td>
                </tr>

                @foreach($L3_ReportRow as $L4_Key=>$L4_ReportRow)
                <tr  class="border-blue">
                    <td>{{ $L4_Key }}</td>
                </tr>

                @foreach($L4_ReportRow as $L5_Key=>$Row)
                @foreach($Row as $Row)
                
                <tr  class="border-blue">
                    <td>{{ $Row->L5_Code }}</td>
                    <td>{{ $Row->L5_Title }}</td>
                    <td>{{ date("M j, Y", strtotime($Row->txn_date)) }}</td>
                    <td align="right">{{ number_format($Row->debit) }}</td>
                    <td align="right">{{ number_format($Row->credit) }}</td>
                </tr>
                @endforeach
                @endforeach
                @endforeach
                @endforeach
                @endforeach
                @endforeach
            </tbody>
        </table><br><br>


        @else

        <form method="POST" action="{{ route('reports.trialreport') }}"  role="form" enctype="multipart/form-data">
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
