<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller {

    public function index() {

        $usertype = \Illuminate\Support\Facades\Auth::user()->user_type;
        //echo $usertype;
        if($usertype=="cfo"){
            $status = [2,3];
        } else if($usertype=="finance"){
            $status = [1];
        } else {
            $status = [3,4];
            $status = [1,2,3,4];
            
        }
        $finGeneralLedgers = \App\Models\FinGeneralLedger::whereIn('voucher_status', $status)->get();

        return view('fin-general-ledger.vouchers', compact('finGeneralLedgers'))->with('i');
    }

    public function getVoucher($id) {
        
        $finGeneralLedger = \App\Models\FinGeneralLedger::where('fin_general_ledgers.id', $id)->with('ledgerdetails')->first();
        $ret = "
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

        
        <table width='100%' border='1' cellspacing='0'>
            <tr class='voucher-head'>
                <td colspan='4' align='center'>ASAAN GHAR FINANCE LIMITED (AGFL)</td>
            </tr>
            <tr  class='voucher-head voucher-subhead'>
                <td colspan='4' align='center'>". FinGeneralLedgerController::getVoucherHeading($finGeneralLedger->txn_type) ."</td>
            </tr>
            <tr  class='blank'>
                <td colspan='4' align='center'>&nbsp;</td>
            </tr>
            <tr  class='blank'>
                <td colspan='4' align='center'>&nbsp;</td>
            </tr>
            <tr  class='blank'>
                <td colspan='4' align='center'>&nbsp;</td>
            </tr>
            <tr  class='upper-values'>
                <td colspan='2'>Reference</td>
                <td colspan='2'>Transaction Date</td>
            </tr>
            <tr  class='upper-values'>
                <td colspan='2'>". FinGeneralLedgerController::getReference($finGeneralLedger->txn_type,$finGeneralLedger->txn_series,3) ."</td>
                <td colspan='2'> $finGeneralLedger->txn_date </td>
            </tr>
            <tr  class=''>
                <td colspan='4'>Purpose</td>
            </tr>
            <tr  class='upper-values-2'>
                <td colspan='4'> $finGeneralLedger->details </td>
            </tr>
            <tr  class='upper-values-3'>
                <td width='25%'>Prepared By</td>
                <td width='25%'>Checked By</td>
                <td width='25%'>Approved By</td>
                <td width='25%'>Received By</td>
            </tr>
            <tr  class=''>
                <td colspan='4'>&nbsp;</td>
            </tr>
            <tr  class='transaction-heading'>
                <td>Sr#</td>
                <td>Chart of Account</td>
                <td>Debit</td>
                <td>Credit</td>
            </tr>";
        $i = 0;
        $GrandDebit = 0;
        $GrandCredit = 0;
        foreach ($finGeneralLedger->ledgerdetails as $row){
            $i = $i + 1;
        $GrandDebit += $row->debit;
        $GrandCredit += $row->credit;
        $ret.="<tr  class='transaction-data'>
                <td>".$i."</td>
                <td>". (FinGeneralLedgerController::getChartOfAccountTitle($row->coa_id) ) ." </td>
                <td align='right'>". number_format($row->debit, 0) ."</td>
                <td align='right'>" . number_format($row->credit, 0) . "</td>
            </tr>";
        }
        $ret.="<tr  class='transaction-heading'>
                <td colspan='2' align='right'>Total</td>
                <td align='right'>". number_format($GrandDebit, 0) ."</td>
                <td align='right'>". number_format($GrandCredit, 0) ."</td>
            </tr>
            <tr  class='blank'>
                <td colspan='4'>&nbsp;</td>
            </tr>
            <tr  class='amount-words'>
                <td colspan='4'>Amount in Words: <span>" . ( FinGeneralLedgerController::convertNumberToWord($GrandDebit) ) . "</span></td>
            </tr>
        </table>";
        return $ret;
        
    }
    public function GetVouchersDocuments($iGeneralJournalId) {
          
$r = '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
      
      ';
        //$dir = base_path().'\public\uploads\source\\' . $GJTransactionDate . '\\' . $iGeneralJournalId;
        $dir = base_path() . '/public/uploads/'.$iGeneralJournalId.'/';

        if(!file_exists($dir)){
            mkdir($dir);
        }
        $files1 = scandir($dir);
        $files2 = scandir($dir, 1);

        $j = 0;
        for ($i = 0; $i < count($files2); $i++) {
            $file_ext = $files2[$i];
            $aFileExt = explode(".", $file_ext);
            if (count($aFileExt) == 2) {
                $imgPath = '/uploads/' . $iGeneralJournalId . '/' . $file_ext;

                if (in_array($aFileExt[1], array("jpg","jpeg", "png", "gif"))) {
                    $r .= '
                    <div class="carousel-item ' . ($j == 0 ? "active" : "") . '">
                        <img class="d-block w-100" style="margin:0 auto; height:520px;" src="'.$imgPath.'" alt="First slide">
                      </div>';

                    $j++;
                }
                // <div style="margin:0 auto; height:520px;" caste="sahito">
                //     <iframe src="https://docs.google.com/viewer?url=https://' . $imgPath . '&embedded=true" frameborder="0" style="margin:0 auto;width:85%; height:520px;display:block;"></iframe>
                // </div>
                if (in_array($aFileExt[1], array("pdf", "doc", "docx", "txt"))) {

                    $r .= '<div class="carousel-item ' . ($j == 0 ? "active" : "") . '">                  
                    
                        <iframe src="https://' . $imgPath . '" frameborder="0" style="margin:0 auto;width:85%; height:520px;display:block;"></iframe>
                    </div>
                    ';
                    $j++;
                    //<embed src="pdfFiles/interfaces.pdf" width="600" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                }
                //echo "<br>";
            }
        }
        if ($j == 0) {
            $r .= '<div align="center" style="padding:10px;">..:: No Any Documents Found ::..</div>';
        }

        $r .= '</div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a></div>';
        return $r;
    }

    public function show($id) {

        $QueryGeneralJournal = \App\Models\FinGeneralLedger::where('id', $id)->with('office')->first();

        $AccountsReports = new clsFMS_Reports_AccountReports();
        $GeneralJournalVoucher = $AccountsReports->GenerateGeneralJournalReceiptlReport(false, $dummy, $iGeneralJournalId);
        $VoucherDocuments = $this->GetVouchersDocuments($iGeneralJournalId, $GJTransactionDate);

        $GJH_Result = $objDB_FIS->ExecQueryAll("select 
                GJH.ProcessComment AS 'ProcessComment', GJH.ProcessTo AS 'ProcessTo', GJH.IsProcessed AS 'IsProcessed', GJH.ActionType AS 'ActionType', 
                GJH.ProcessBy AS 'ProcessBy', GJH.CreatedOn AS 'CreatedOn', concat(E.FirstName,' ',E.LastName) as 'FullName', E.Designation AS 'Designation'
                from fms_accounts_generaljournal_history as GJH
                inner join fms_organization_employees as E on E.EmployeeId = GJH.ProcessBy   
                where  GJH.GeneralJournalId = '$iGeneralJournalId'");
    }

}
