<?php

namespace App\Http\Controllers;

use DateTime;
use App\Helpers\Qs;
use App\Helpers\Pay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentCreate;
use App\Http\Requests\Payment\PaymentUpdate;
use App\Models\Setting;
use App\Repositories\MyClassRepo;
use App\Repositories\LoanBorrowerRepo;
use App\Repositories\LoanHistoryRepo;
use App\Repositories\PaymentRepo;
use App\Repositories\StudentRepo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class LoansController extends Controller {

    protected $tt, $my_loan_history, $exam, $year;
    protected $clsPR;

    public function __construct(LoanBorrowerRepo $tt, LoanHistoryRepo $lt, PaymentRepo $PR) {
        $this->tt = $tt;
        $this->my_loan_history = $lt;
        $this->clsPR = $PR;
    }

    function showloan($loanId){
        $d['data'] = \App\Models\LoanHistory::find($loanId)->with('loan_borrower')->first();
        return view('lms_loans.showloan', $d);        
    }
    function Index() {
        $d['tt_records'] = $this->tt->getAll();

        return view('lms_loans.borrowers', $d);
    }

    function borrowers() {
        $d['tt_records'] = $this->tt->getAll();

        return view('lms_loans.borrowers', $d);
    }

    function loandetails() {
        $tt = new LoanHistoryRepo;
        $d['tt_records'] = $tt->getAll();
        //dd($d['tt_records']);

        return view('lms_loans.loandetails', $d);
    }

    function show_schedule($tt_id) {
        //dd(__FUNCTION__);
        $d['ttr_id'] = $tt_id;
        $d['dueinfo'] = \App\Models\LoanPaymentDue::where(['loan_id' => $tt_id])->with('loan_history')->get();
        $d['paidinfo'] = \App\Models\LoanPaymentRecovered::where(['loan_id' => $tt_id])->get();
        $d['bankinfo'] = \App\Models\LMSBankSlip::where(['slip_date' => date("Y-m-d")])->get();
        return view('lms_loans.loanschedule', $d);
    }

    public function getStatus($param, $title) {
        $LoanStatus = "";
        
        switch ($param){
            case 1:
                $LoanStatus = '<span class="badge badge-pill badge-success">'.$title.'</span>';
                break;
            case 2:
                $LoanStatus = '<span class="badge badge-pill badge-primary">'.$title.'</span>';
                break;
            case 3:
                $LoanStatus = '<span class="badge badge-pill badge-danger">'.$title.'</span>';
                break;
                case 4:
                    $LoanStatus = '<span class="badge badge-pill badge-notice">'.$title.'</span>';
                    break;
            }
        return $LoanStatus;
    }
    public function loanstep($loan_id) {
        $d['loaninfo'] = \App\Models\LoanHistory::where(['id' => $loan_id])->first();
        
        return view('lms_loans.loanstep', $d);        
        
    }
    public function loanstepStore(Request $request) {
        
        $data = $request->all();
        //var_dump($data);
        return $this->gen_schedule($data["loanId"], $data);
        //$d['bankinfo'] = \App\Models\LMSBankSlip::where(['slip_date' => date("Y-m-d")])->get();
        //return view('lms_loans.loanstep', $d);        
    }
    public function gen_schedule($loan_id, $fetchdata) {
        //$data = $req->all();
        //$this->tt->create($data);
        
        //dd($fetchdata);
        $schResp = $this->GenerateRepaymentScheduleDecline($loan_id, $fetchdata);
        //dd("");
        //$schResp = $this->GenerateRepaymentScheduleNew($tt_id);
        if ($schResp == 1) {
            $tt = new LoanHistoryRepo;
            $d['tt_records'] = $tt->getAll();
            //dd($d['tt_records']);

            return view('lms_loans.loandetails', $d)->with('flash_success', 'Schedule Generated Successfully');
            
            //return back()->with('flash_success', 'Schedule Generated Successfully');
        } else {
            return back()->with('flash_error', 'Unable to Generate Schedule');
        }


        //return Qs::jsonUpdateOk();
    }


    function GenerateRepaymentScheduleNew($LoanId) {
        $data = $this->my_loan_history->find($LoanId);
        $amount_pr = $data['total_amount_pr'];
        $disb_date = $data['disb_date'];
        $rep_start_date = $data['rep_start_date'];
        $loan_freq = $data['loan_frequency'];
        $markup_rate = $data['markup_rate'];
        $loan_period = $data['loan_period'];

        $ChequeDate = $disb_date;
        $ApprovedLoanAmount = $amount_pr;
        $SrChargeRate = $markup_rate;
        $LoanFrequency = $loan_freq;
        $LoanTerm = $loan_period;
        $RepStartDate = $rep_start_date;

        $iLoanFrequency = $LoanFrequency;
        $arryModeOfPayment = array(
            1 => 1,
            3 => 3,
            7 => 4,
            6 => 6,
            4 => $LoanTerm,
            8 => 12
        );

//        $varResult = $this->Execute("
//   		UPDATE microfinance_loans
//   		SET
//                RepaymentStartDate='$RepStartDate',
//                LoanRepayments_NextRepaymentDate='$RepStartDate',
//                LoanDisbursement_DisbursementDateTime='$DisbDate',
//                LoanDisbursement_DisbursementStatus='1',
//                LoanDisbursement_EmployeeId='$EmployeeId',
//                LoanStatus = '5',
//                IsBiometric='1'
//   		WHERE LoanId='$LoanId'", $this->mis);

        $TotalDaysLoanTerms = $LoanTerm * (365 / 12);
        $LoanFrequency = $arryModeOfPayment[$LoanFrequency];
        $TotalSrCharge = $ApprovedLoanAmount * ($SrChargeRate / 100);
        $DailySrcCharge = $TotalSrCharge / 365;
        $MonthlyPrinciple = ($ApprovedLoanAmount * $LoanFrequency) / $LoanTerm;
        // $MonthlySolarPrice = ($SolarPackagePrice * $LoanFrequency) / $LoanTerm;
        $MonthlyServiceCharge = ($TotalSrCharge * $LoanFrequency) / 12;
        $RemainingSrCharge = $TotalSrCharge;
        $RemainingPrinciple = $ApprovedLoanAmount;

        $DueData = \App\Models\LoanPaymentDue::where(array('loan_id' => $LoanId))->exists();

        if ($DueData) {
            return 0;
        }

        $GrandTotalServiceCharge = 0;
        for ($i = 1; $i <= ($LoanTerm / $LoanFrequency); $i++) {
            if ($i == 1) {
                $Dev_ScheduleDate = $RepStartDate;
                $datetime_chq = new DateTime(date("Y-m-d", strtotime($ChequeDate)));
                $datetime_repstart = new DateTime(date("Y-m-d", strtotime($RepStartDate)));
                $difference = $datetime_chq->diff($datetime_repstart);
                //

                $TotalDifference = 0;
                $Dev_ScheduleDate_R = $Dev_ScheduleDate;
                for ($raja = 1; $raja <= ($LoanTerm / $LoanFrequency); $raja++) {
                    if ($raja == 1) {
                        $TotalDifference += $difference->days;
                    } else {
                        $PreviousRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $date_R = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $date_R->modify('+' . $LoanFrequency . ' month');
                        $Dev_ScheduleDate_R = $date_R->format('Y-m-d');
                        $NextRepaymentDate_R = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $difference_R = $PreviousRepaymentDate->diff($NextRepaymentDate_R);
                        $TotalDifference += $difference_R->days;
                    }
                }
                if ($TotalDifference > $TotalDaysLoanTerms) {
                    $RemainingDays = $TotalDifference - $TotalDaysLoanTerms;
                    $MonthlyServiceCharge += ($DailySrcCharge * $RemainingDays);
                } else if ($TotalDifference < $TotalDaysLoanTerms && $LoanTerm < 12 && $iLoanFrequency != 4) {
                    $RemainingDays = $TotalDaysLoanTerms - $TotalDifference;
                    $MonthlyServiceCharge = ($DailySrcCharge * $RemainingDays);
                } else if ($TotalDifference == $TotalDaysLoanTerms) {
                    $TotalCycles = $LoanTerm / $LoanFrequency;
                    $TotalPayable = round($MonthlyServiceCharge) * $TotalCycles;
                    // $MonthlyServiceCharge += $TotalSrCharge - $TotalPayable;
                    $MonthlyServiceCharge += ($DailySrcCharge * $TotalDaysLoanTerms) - $TotalPayable;
                }
            } else {
                $PreviousRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $date = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $date->modify('+' . $LoanFrequency . ' month');
                $Dev_ScheduleDate = $date->format('Y-m-d');
                $NextRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $difference = $PreviousRepaymentDate->diff($NextRepaymentDate);
                //
                $MonthlyServiceCharge = ($TotalSrCharge * $LoanFrequency) / 12;
            }
            if ($i == ($LoanTerm / $LoanFrequency)) {
                $MonthlyPrinciple = $RemainingPrinciple;
                // $MonthlySolarPrice = $SolarPackagePrice;
            }
            $MonthlyPrinciple = round($MonthlyPrinciple);
            // $MonthlySolarPrice = round($MonthlySolarPrice);
            $MonthlyServiceCharge = round($MonthlyServiceCharge);
            $DaysDiff = $difference->days;
            $Total = $MonthlyPrinciple + $MonthlyServiceCharge;

            $RemainingSrCharge -= $MonthlyServiceCharge;
            $RemainingPrinciple -= $MonthlyPrinciple;
            // $SolarPackagePrice -= $MonthlySolarPrice;

            $sScheduledRepaymentDate = date("M j, Y", strtotime($Dev_ScheduleDate));
            $sScheduledDay = date('D', strtotime($sScheduledRepaymentDate));
            $sScheduledDate = date('d', strtotime($sScheduledRepaymentDate));
            if ($sScheduledDay == "Sun") {
                $dateScheduledRepaymentDate = new DateTime(date("Y-m-d", strtotime($sScheduledRepaymentDate)));
                if ($sScheduledDate == 15) {
                    $dateScheduledRepaymentDate->modify('-1 day');
                } else {
                    $dateScheduledRepaymentDate->modify('+1 day');
                }
                $sScheduledRepaymentDate = $dateScheduledRepaymentDate->format('Y-m-d');
                $sScheduledRepaymentDate = date("M j, Y", strtotime($sScheduledRepaymentDate));
            }
            $MysqlScheduleDate = date("Y-m-d", strtotime($sScheduledRepaymentDate));
            $GrandTotalServiceCharge += $MonthlyServiceCharge;

            \App\Models\LoanPaymentDue::create([
                'loan_id' => $LoanId,
                'installment_no' => $i,
                'due_date' => $MysqlScheduleDate,
                'amount_total' => $Total,
                'amount_pr' => $MonthlyPrinciple,
                'amount_mu' => $MonthlyServiceCharge
            ]);
        }

        $dServiceCharges = round($GrandTotalServiceCharge);
        $dLoanBalance = $dServiceCharges + $ApprovedLoanAmount;

//        $this->Execute("
//			UPDATE
//				microfinance_loans
//			SET
//				TotalLoanAmount_Principal = '$ApprovedLoanAmount',
//				TotalLoanAmount_ServiceCharges = '$dServiceCharges',
//				TotalLoanAmount = '$dLoanBalance',
//				LoanBalance = '$dLoanBalance',
//				LoanBalance_ServiceCharges = '$dServiceCharges',
//				LoanBalance_Principal = '$ApprovedLoanAmount',
//				LoanStatus = '5'
//			WHERE LoanId = '$LoanId'
//			", $this->mis);
        return 1;
    }

    function GenerateRepaymentScheduleDecline($LoanId, $fetchdata) {
        
        

        $takaful_amount = isset($fetchdata["takaful_amount"]) ? 1 : 0;
        $fed_amount = isset($fetchdata["fed_amount"]) ? 1 : 0;
        
        $data = $this->my_loan_history->find($LoanId);
        $amount_pr = $data['total_amount_pr'];
        $disb_date = $data['disb_date'];
        $rep_start_date = $data['rep_start_date'];
        $loan_freq = $data['loan_frequency'];
        $markup_rate = $data['markup_rate'];
        $loan_period = $data['loan_period'];

        $ChequeDate = $disb_date;
        $ApprovedLoanAmount = $amount_pr;
        $SrChargeRate = $markup_rate;
        $SrChargeRate = 16;
        $LoanFrequency = $loan_freq;
        $LoanTerm = $loan_period;
        $RepStartDate = $rep_start_date;

        $DueData = \App\Models\LoanPaymentDue::where(array('loan_id' => $LoanId))->exists();

        if ($DueData) {
            return 0;
        }
        $DayRepStart = date("d", strtotime($RepStartDate));
        if ($DayRepStart < 15 || $DayRepStart > 25) {
            $DayRepStart = 15;
            $RepStartDate = date("Y-m", strtotime($RepStartDate)) . "-" . $DayRepStart;
        }

        $GrandPrinc = $GrandServ = $GrandTotal = $GrandDays = $GrandTakaful = 0;

        $iLoanFrequency = $LoanFrequency;
        $Return = "<table width='100%' border='1' bordercolor='#999999' cellspacing='0' cellpadding='4'>";
        $Return .= "<tr bgcolor='#CCCCCC'>"
                . "<td  align='center' rowspan='2'>Sr#</td>"
                . "<td align='center' rowspan='2'>Schedule Date</td>"
                . "<td align='center' rowspan='2'>Days</td>"
                . "<td  colspan='3' align='center'>Dues</td><td rowspan='2'  align='center'>Balance</td></tr>"
                . "<tr bgcolor='#CCCCCC'><td align='center'>Principle</td><td align='center'>Srv Charge</td><td align='center'>Takaful</td><td align='center'>Total</td></tr>";

        $Return .= "<tr><td colspan='6' align='right'></td><td align='right'>$ApprovedLoanAmount</td></tr>";

        $arryModeOfPayment = array(
            1 => 1,
            3 => 3,
            7 => 4,
            6 => 6,
            4 => $LoanTerm,
            8 => 12
        );
        $LoanFrequency = $arryModeOfPayment[$iLoanFrequency];
        $arryModeOfPaymentCalc = array(
            1 => 12,
            3 => 4,
            7 => 3,
            6 => 2,
            4 => 1,
            8 => 1);

        $SchedLoanTerm = $LoanTerm;
        $FormulaloanTerm = $LoanTerm / 12;
        $modeOfP = $arryModeOfPaymentCalc[$iLoanFrequency];

        //$rate = interest rate
        //$nper = number of periods
        //$fv is future value
        //$pv is present value
        //$type is type
        $fv = 0;
        $pv = $ApprovedLoanAmount;
        $rate = ($SrChargeRate / 100) / 360 * 30;
        $nper = $LoanTerm;
        $type = 0;

//        $PMT = (-$fv - $pv * pow(1 + $rate, $nper)) /
//        (1 + $rate * $type) /
//        ((pow(1 + $rate, $nper) - 1) / $rate);
        $PMT = ((0 - $pv * pow(1 + $rate, $nper)) /
                (1 + $rate) /
                ((pow(1 + $rate, $nper) - 1) / $rate)) * -1;
        
        $rate=16;
        //echo $this->calPMT($rate, 7, $ApprovedLoanAmount);
        //dd();        
        //dd(round($PMT,6));
        //dd($PMT);
        $Fst = ($SrChargeRate / $modeOfP) / 100;
        $Snd = pow((1 + $Fst), ($modeOfP * $FormulaloanTerm));
        $Trd = 1 / $Snd;
        $Fth = 1 - $Trd;
        //$Ffth = round($Fth / $Fst, 2);
        //$Final = round($ApprovedLoanAmount / $Ffth);
        $Ffth = $Fth / $Fst;
        $Final = round($ApprovedLoanAmount / $Ffth);

        //echo "Final1: " . $Final . "<br>";
        $TotalSrCharge = $ApprovedLoanAmount * ($SrChargeRate / 100);
        //echo "Final2: " . $TotalSrCharge . "<br>";
        $DailySrcCharge = $TotalSrCharge / 365;
        $TotalDaysLoanTerms = $SchedLoanTerm * (365 / 12);

        //echo "TotalDaysLoanTerms: " . $TotalDaysLoanTerms . "<br>";
        //echo "DailySrcCharge: " . $DailySrcCharge . "<br>";
        //Loop Here
        for ($i = 1; $i <= ($SchedLoanTerm / $LoanFrequency); $i++) {

            $AdditionalServiceCharges = 0;
            if ($i == 1) {
                $Dev_ScheduleDate = $RepStartDate;
                $datetime_chq = new DateTime(date("Y-m-d", strtotime($ChequeDate)));
                $datetime_repstart = new DateTime(date("Y-m-d", strtotime($RepStartDate)));
                $difference = $datetime_chq->diff($datetime_repstart);
                //


                $TotalDifference = 0;
                $Dev_ScheduleDate_R = $Dev_ScheduleDate;
                for ($raja = 1; $raja <= ($SchedLoanTerm / $LoanFrequency); $raja++) {
                    if ($raja == 1) {
                        $TotalDifference += $difference->days;
                    } else {
                        $PreviousRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $date_R = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $date_R->modify('+' . $LoanFrequency . ' month');
                        $Dev_ScheduleDate_R = $date_R->format('Y-m-d');
                        $NextRepaymentDate_R = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate_R)));
                        $difference_R = $PreviousRepaymentDate->diff($NextRepaymentDate_R);
                        $TotalDifference += $difference_R->days;
                    }
                }
                //echo "Total Days Diff: " . $TotalDifference . "<br>";
                if ($TotalDifference > $TotalDaysLoanTerms) {
                    //echo "1<br>";
                    //echo "DailySrcCharge: " . $DailySrcCharge . "<br>";

                    $RemainingDays = $TotalDifference - $TotalDaysLoanTerms;
                    //echo "RemainingDays: " . $RemainingDays . "<br>";
                    $AdditionalServiceCharges += ($DailySrcCharge * $RemainingDays);
                } else if ($TotalDifference < $TotalDaysLoanTerms && $iLoanFrequency != 4) {
                    //echo "2<br>";
                    $RemainingDays = $TotalDaysLoanTerms - $TotalDifference;
                    $AdditionalServiceCharges -= ($DailySrcCharge * $RemainingDays);
                }
                //echo "AdditionalServiceCharges: " . $AdditionalServiceCharges . "<br>";
            } else {
                $PreviousRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $date = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $date->modify('+' . $LoanFrequency . ' month');
                $Dev_ScheduleDate = $date->format('Y-m-d');
                $NextRepaymentDate = new DateTime(date("Y-m-d", strtotime($Dev_ScheduleDate)));
                $difference = $PreviousRepaymentDate->diff($NextRepaymentDate);
            }
            $MonthlyServiceCharge = $ApprovedLoanAmount * $Fst;
            //$MonthlyServiceCharge = round($MonthlyServiceCharge);


            $MonthlyPrinciple = $Final - $MonthlyServiceCharge;
            $MonthlyPrinciple = round($MonthlyPrinciple);

            $MonthlyServiceCharge += $AdditionalServiceCharges;
            

            $ApprovedLoanAmount -= $MonthlyPrinciple;
            $DaysDiff = $difference->days;

            $MonthlyPrinciple = round($MonthlyPrinciple);
            $MonthlyServiceCharge = round($MonthlyServiceCharge);
//            if($takaful_amount){
//            $MonthlyTakaful = (($ApprovedLoanAmount*0.8/100)/365)*$DaysDiff;
//            if($MonthlyTakaful<0){
//                $MonthlyTakaful = 0;
//            }
//            $MonthlyTakaful = ceil($MonthlyTakaful);
//            } else {
//                
//            }
            $MonthlyTakaful = 0;

            if ($i == ($SchedLoanTerm / $LoanFrequency)) {
                if ($ApprovedLoanAmount <> 0) {
                    $MonthlyPrinciple += $ApprovedLoanAmount;
                    $ApprovedLoanAmount = 0;
                }
            }

            $Total = $MonthlyPrinciple + $MonthlyServiceCharge+$MonthlyTakaful;

            $sScheduledRepaymentDate = date("M j, Y", strtotime($Dev_ScheduleDate));
            $sScheduledDay = date('D', strtotime($sScheduledRepaymentDate));
            $sScheduledDate = date('d', strtotime($sScheduledRepaymentDate));
            if ($sScheduledDay == "Sun") {
                $dateScheduledRepaymentDate = new DateTime(date("Y-m-d", strtotime($sScheduledRepaymentDate)));
                if ($sScheduledDate == 25) {
                    $dateScheduledRepaymentDate->modify('-1 day');
                } else {
                    $dateScheduledRepaymentDate->modify('+1 day');
                }
                $sScheduledRepaymentDate = $dateScheduledRepaymentDate->format('Y-m-d');
                $sScheduledRepaymentDate = date("M j, Y", strtotime($sScheduledRepaymentDate));
            }
            $MysqlScheduleDate = date("Y-m-d", strtotime($sScheduledRepaymentDate));
            
            
            \App\Models\LoanPaymentDue::create([
                'loan_id' => $LoanId,
                'installment_no' => $i,
                'due_date' => $MysqlScheduleDate,
                'amount_total' => $Total,
                'amount_pr' => $MonthlyPrinciple,
                'amount_mu' => $MonthlyServiceCharge,
                'amount_takaful' => $MonthlyTakaful
            ]);

            $Return .= "<tr>"
                    . "<td>$i</td>"
                    . "<td>$MysqlScheduleDate</td>"
                    . "<td align='right'>$DaysDiff</td>"
                    . "<td align='right'>$MonthlyPrinciple</td>"
                    . "<td align='right'>$MonthlyServiceCharge</td>"
                    . "<td align='right'>$MonthlyTakaful</td>"
                    . "<td align='right'>" . ($Total) . "</td>"
                    . "<td align='right'>" . ($ApprovedLoanAmount) . "</td>"
                    . "</tr>";

            $GrandPrinc += $MonthlyPrinciple;
            $GrandServ += $MonthlyServiceCharge;
            $GrandTotal += $Total;
            $GrandDays += $DaysDiff;
            $GrandTakaful += $MonthlyTakaful;
        }
        \App\Models\LoanHistory::find($LoanId)->update(['loan_status_id'=>10]);
        
        $LastSeries = \App\Models\FinGeneralLedger::orderBy("id", "desc")->first();
        if(!isset($LastSeries->txn_series)){
            $LastSeries=0;
        } else {
            $LastSeries= $LastSeries->txn_series;
        }
        $NextSeries = $LastSeries+1;
        
        $ProcessingFees = $GrandPrinc*1.5/100;
        if($fed_amount){
            $FED = $ProcessingFees*13/100;
        } else {
            $FED = 0;
        }
        $TakafulFees = $GrandPrinc*0.8/100;
        $BankPayment = $GrandPrinc - ($ProcessingFees+$TakafulFees);

        \App\Models\LoanHistory::where('id',$LoanId)->update(['id'=>$LoanId, 'total_amount'=>$GrandTotal,'total_amount_pr'=>$GrandPrinc,'total_amount_mu'=>$GrandServ,'total_amount_tak'=>$TakafulFees]);

        
        
//        Loan Processing fee income and FED payable
        
        
        //First Entry ()
        $Model_GL = \App\Models\FinGeneralLedger::create([
            'slip_id'=>1,'loan_id'=>$LoanId, 'user_id'=>1,'details'=>'Disbursement Voucher - Loan Processing fee income and FED payable', 'debit'=>$GrandPrinc, 'credit'=>$GrandPrinc, 'txn_date'=>date('Y-m-d'), 'txn_type'=>1,'txn_series'=>$NextSeries++,'office_id'=>1
        ]);
        $FinGL_Id = $Model_GL->id;
        //JS Bank
        \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'172', 'debit'=>($ProcessingFees+$FED), 'credit'=>0]);

        //Processing Fees
        \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'336', 'debit'=>0, 'credit'=>$ProcessingFees]);        
        if($FED){
            //FED Fees
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'216', 'debit'=>0, 'credit'=>$FED]);        
            
            
            
            
            $Model_GL = \App\Models\FinGeneralLedger::create([
                'slip_id'=>1,'loan_id'=>$LoanId, 'user_id'=>1,'details'=>'payment of FED on loan processing fee', 'debit'=>$FED, 'credit'=>$FED, 'txn_date'=>date('Y-m-d'), 'txn_type'=>1,'txn_series'=>$NextSeries++,'office_id'=>1
            ]);
            $FinGL_Id = $Model_GL->id;
            
            //JS Bank
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'172', 'debit'=>0, 'credit'=>$FED]);
            //FED Fees
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'216', 'debit'=>$FED, 'credit'=>0]);        
            
        }
        
        
        
        
        
        //First Entry ()
        $Model_GL = \App\Models\FinGeneralLedger::create([
            'slip_id'=>1,'loan_id'=>$LoanId, 'user_id'=>1,'details'=>'Disbursement Voucher', 'debit'=>$GrandPrinc, 'credit'=>$GrandPrinc, 'txn_date'=>date('Y-m-d'), 'txn_type'=>1,'txn_series'=>$NextSeries++,'office_id'=>1
        ]);
        $FinGL_Id = $Model_GL->id;
        //Lendings To Financial Institutions
        \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'147', 'debit'=>$GrandPrinc, 'credit'=>'0']);        
        //JS Bank
        \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'172', 'debit'=>0, 'credit'=>$GrandPrinc]);
        




        //Second Entry (Takaful)
        if($TakafulFees){
            //Takaful first
            $Model_GL = \App\Models\FinGeneralLedger::create([
                'slip_id'=>1,'loan_id'=>$LoanId, 'user_id'=>1,'details'=>'Takaful Voucher - Payment Received From Borrower', 'debit'=>$GrandPrinc, 'credit'=>$GrandPrinc, 'txn_date'=>date('Y-m-d'), 'txn_type'=>1,'txn_series'=>$NextSeries++,'office_id'=>1
            ]);
            $FinGL_Id = $Model_GL->id;
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'187', 'debit'=>0, 'credit'=>$TakafulFees]);        
            //JS Bank
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'172', 'debit'=>$TakafulFees, 'credit'=>0]);

            //Takaful second
            $Model_GL = \App\Models\FinGeneralLedger::create([
                'slip_id'=>1,'loan_id'=>$LoanId, 'user_id'=>1,'details'=>'Takaful Voucher - Payment to Takaful Company', 'debit'=>$GrandPrinc, 'credit'=>$GrandPrinc, 'txn_date'=>date('Y-m-d'), 'txn_type'=>1,'txn_series'=>$NextSeries++,'office_id'=>1
            ]);
            $FinGL_Id = $Model_GL->id;
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'187', 'debit'=>$TakafulFees, 'credit'=>0]);        
            //JS Bank
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'172', 'debit'=>0, 'credit'=>$TakafulFees]);
            
        }
        //Processing
        \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id'=>'337', 'debit'=>0, 'credit'=>$ProcessingFees]);
        
        $dLoanBalance = $GrandServ + $GrandPrinc;

        $Return .= "<tr>"
                . "<td colspan='3'>Total ($GrandDays Days)</td>"
                . "<td align='right'>$GrandPrinc</td>"
                . "<td align='right'>$GrandServ</td>"
                . "<td align='right'>$GrandTakaful</td>"
                . "<td align='right'>$GrandTotal</td>"
                . "<td align='right'>$ApprovedLoanAmount</td>"
                . "</tr>";
        $Return .= "</table>";
        return 1;
    }

    function calPMT($apr, $term, $loan) {
        $term = $term * 12;
        $apr = $apr / 1200;
        $amount = $apr * -$loan * pow((1 + $apr), $term) / (1 - pow((1 + $apr), $term));
        return round($amount);
    }

    

}
