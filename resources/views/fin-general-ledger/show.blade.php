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
            <a class="btn btn-primary" onclick="printScrn()"> Print</a>
        </div>
    </div>

    <div class="card-body" id="voucher-body">
        <style>
            table td {
                padding: 5px;
            }
            .voucher-head {
                background-color: #C6E0B4;
                font-size: 16px;
                font-weight: bolder;
            }
            .voucher-subhead {
                font-size: 14px;
                font-weight: bold;
            }
            .blank td {
                border: 0px;
            }
            .upper-values-2 td {
                height: 60px;
            }

            .upper-values-3{
                /*        line-height: 12;*/
                text-align: center;
            }
            .upper-values-3 td {
                height: 130px;
                vertical-align: bottom;
            }
            .transaction-heading {
                background-color: #C6E0B4;
                font-weight: bold;
                text-align: center;
            }
            .transaction-data td {
                padding: 5px;
            }
            .amount-words {
                
            }
            .amount-words span {
                font-weight: bold;
                text-transform: capitalize;
                font-style: italic;
            }
        </style>

        
        <table width="100%" border="1" cellspacing="0">
            <tr class="voucher-head">
                <td colspan="4" align="center">ASAAN GHAR FINANCE LIMITED (AGFL)</td>
            </tr>
            <tr  class="voucher-head voucher-subhead">
                <td colspan="4" align="center">{{ App\Http\Controllers\FinGeneralLedgerController::getVoucherHeading($finGeneralLedger->txn_type) }}</td>
            </tr>
            <tr  class="blank">
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr  class="blank">
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr  class="blank">
                <td colspan="4" align="center">&nbsp;</td>
            </tr>
            <tr  class="upper-values">
                <td colspan="2">Reference</td>
                <td colspan="2">Transaction Date</td>
            </tr>
            <tr  class="upper-values">
                <td colspan="2">{{ App\Http\Controllers\FinGeneralLedgerController::getReference($finGeneralLedger->txn_type,$finGeneralLedger->txn_series,3) }}</td>
                <td colspan="2">{{ $finGeneralLedger->txn_date }}</td>
            </tr>
            <tr  class="">
                <td colspan="4">Purpose</td>
            </tr>
            <tr  class="upper-values-2">
                <td colspan="4">{{ $finGeneralLedger->details }}</td>
            </tr>
            <tr  class="upper-values-3">
                <td width="25%">Prepared By</td>
                <td width="25%">Checked By</td>
                <td width="25%">Approved By</td>
                <td width="25%">Received By</td>
            </tr>
            <tr  class="">
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr  class="transaction-heading">
                <td>Sr#</td>
                <td>Chart of Account</td>
                <td>Debit</td>
                <td>Credit</td>
            </tr>
            @php
            $i=0;
            $GrandDebit = 0;
            $GrandCredit = 0;
            @endphp
            @foreach($finGeneralLedger->ledgerdetails as $row)
            @php
            $i=$i+1;
            
            $GrandDebit += $row->debit;
            $GrandCredit += $row->credit;
            @endphp
            <tr  class="transaction-data">
                <td>{{ $i }}</td>
                
                <td>{{ App\Http\Controllers\FinGeneralLedgerController::getChartOfAccountTitle($row->coa_id) }} </td>
                <td align="right">{{ number_format($row->debit,0) }}</td>
                <td align="right">{{ number_format($row->credit,0) }}</td>
            </tr>
            @endforeach
            <tr  class="transaction-heading">
                <td colspan="2" align="right">Total</td>
                <td align="right">{{ number_format($GrandDebit,0) }}</td>
                <td align="right">{{ number_format($GrandCredit,0) }}</td>
            </tr>
            <tr  class="blank">
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr  class="amount-words">
                <td colspan="4">Amount in Words: <span>{{ App\Http\Controllers\FinGeneralLedgerController::convertNumberToWord($GrandDebit) }}</span></td>
            </tr>
        </table>
    </div>
</div>
<script>
    function printScrn() {

        var mywindow = window.open('', 'PRINT', 'height=800,width=1200');

        mywindow.document.write('<html>');
        /*
        mywindow.document.write('<head><title>' + document.title + '</title>');
        mywindow.document.write('</head>');
        mywindow.document.write('<body >');
        mywindow.document.write('<h1>' + document.title + '</h1>');*/
        mywindow.document.write(document.getElementById("voucher-body").innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
@endsection
