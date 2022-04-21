@extends('layouts.master')
@section('page_title', 'Due Report')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Due Report</span>
    </div>
    <div class="card-body">
        @if(isset($datef))

        <fieldset>
            <legend>Report Criteria:</legend>
            <span class="card-title">Generated from {{ $datef }} to {{ $datet }}</span>
            <br><br>
        </fieldset>


        <table class="datatable-button-html5-columns col-sm-12">
            <thead style="background-color: #26a69a; color: #FFF;">

                <tr class="datatable-header center"  >
                    <th rowspan="2">Sr.#</th>
                    <th rowspan="2">Borrower Name</th>
                    <th rowspan="2">Location</th>
                    <th rowspan="2">A/C#</th>
                    <th colspan="2">Current Due</th>
                    <th colspan="2">Total Due</th>
                    <th colspan="2">Total Recovered</th>
                    <th rowspan="2">Last Recovery Date</th>
                </tr>
                <tr class="datatable-header" style="text-align: center; ">
                    <th>Principle</th>
                    <th>Markup</th>
                    <th>Principle</th>
                    <th>Markup</th>
                    <th>Principle</th>
                    <th>Markup</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ReportData as $ReportRow)
                <tr  class="border-blue">
                    <td>{{ ++$i }}</td>
                    <td>{{ $ReportRow->b_name }}</td>
                    <td>{{ $ReportRow->name }}</td>
                    <td>{{ $ReportRow->id }}</td>
                    <td>{{ number_format($ReportRow->c_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->c_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ $ReportRow->b_name }}</td>

                </tr>                
                <tr  class="border-blue">
                    <td>{{ ++$i }}</td>
                    <td>{{ $ReportRow->b_name }}</td>
                    <td>{{ $ReportRow->name }}</td>
                    <td>{{ $ReportRow->id }}</td>
                    <td>{{ number_format($ReportRow->c_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->c_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ $ReportRow->b_name }}</td>

                </tr>                
                <tr  class="border-blue">
                    <td>{{ ++$i }}</td>
                    <td>{{ $ReportRow->b_name }}</td>
                    <td>{{ $ReportRow->name }}</td>
                    <td>{{ $ReportRow->id }}</td>
                    <td>{{ number_format($ReportRow->c_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->c_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_pr) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ number_format($ReportRow->s_am_mu) }}</td>
                    <td>{{ $ReportRow->b_name }}</td>

                </tr>                
                @endforeach
            </tbody>
            <tfoot class="datatable-footer-accent">
                <tr  class="border-blue">
                    <th>{{ $i }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>1234</th>
                    <th>1234</th>
                    <th>1234</th>
                    <th>1234</th>
                    <th>1234</th>
                    <th>1234</th>
                    <th></th>
                </tr>                
                
            </tfoot>
        </table>


        @else

        <form method="POST" action="{{ route('reports.duesreport') }}"  role="form" enctype="multipart/form-data">
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
