@extends('layouts.master')
@section('page_title', 'Tax Certificate')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Tax Certificate</h6>
    </div>

    <div class="card-body">
        <div class="tab-content">
            Date: <span style="text-decoration: underline;">{{ date("Y-m-d") }}</span><br><br>
            Customer Name: <span style="text-decoration: underline;">{{ $loanData->name }}</span><br><br>
            CNIC # <span style="text-decoration: underline;">{{ $loanData->cnic }}</span><br><br>
            Property Address: ______________________________________________________________________<br><br>
            Subject: Tax Certificate of Home Finance Customer Facility <br><br>
            Dear Sir / Madam,<br>
            This Tax Certificate is being issued upon the request received from you dated: <span style="text-decoration: underline;">{{ date("Y-m-d") }}</span><br><br>
            Details of Home Finance Facility provided to you are as follows:<br><br>
            Account # <span style="text-decoration: underline;">{{ $loanData->loan_id }}</span><br>
            Disbursement dated: <span style="text-decoration: underline;">{{ $loanData->disb_date }}</span><br>
            Financed Amount: <span style="text-decoration: underline;">{{ $loanData->finance_amount }}</span><br>
            Current Status of Financing: <span style="text-decoration: underline;">{{ $loanData->loan_status }}</span><br>
            Finance Outstanding as of 30-Jun-2022 <span style="text-decoration: underline;">{{ $loanData->outstanding }}</span><br>
            Profit Paid from 01-Jul-2021 to 30-June-2022. <span style="text-decoration: underline;">{{ $recovered->profit }}</span><br><br>
            
            
            S. No.	Months	Profit Amount
            1	15-Jul-2021	141,667
            2	15-Aug-2021	141,596
            3	15-Sep-2021	141,524
            4	15-Oct-2021	141,451
            5	15-Nov-2021	141,376
            6	15-Dec-2021	141,301
            7	15-Jan-2022	141,225
            8	15-Feb-2022	141,148
            9	15-Mar-2022	141,069
            10	15-Apr-2022	140,990
            11	15-May-2022	140,909
            12	15-Jun-2022	140,828
            Total Profit Amount	1,695,084
            <br><br>
            Regards,
            <br><br><br>

            Asaan Ghar Finance Limited

        </div>
    </div>
</div>

{{--TimeTable Ends--}}

@endsection
