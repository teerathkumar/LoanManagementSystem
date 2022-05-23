<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller {

    public function __construct() {
        
    }

    public function TrialBalance() {
        //dd("Yeah");
        $d['report'] = "Financial";
        return view('reports.trialreport', $d);
    }

    public function TrialBalanceReport(Request $request) {
        error_reporting(E_ERROR);
        $this->validate($request, [
            'datefrom' => 'required|date',
            'dateto' => 'required|date'
                ], [], ['datefrom' => 'Date From', 'dateto' => 'Date To']);

        $d['datef'] = $request->datefrom;
        $d['datet'] = $request->dateto;
        $d['i'] = 0;
        $ReportData = DB::table("fin_general_ledgers as gl")
                ->join("fin_general_ledger_details as gld", "gld.fin_gen_id", "=", "gl.id")
                ->join("fin_chart_of_accounts as fca_l5", "fca_l5.id", "=", "gld.coa_id")
                ->join("fin_chart_of_accounts as fca_l4", "fca_l4.code", "=", "fca_l5.parent_code")
                ->join("fin_chart_of_accounts as fca_l3", "fca_l3.code", "=", "fca_l4.parent_code")
                ->join("fin_chart_of_accounts as fca_l2", "fca_l2.code", "=", "fca_l3.parent_code")
                ->join("fin_chart_of_accounts as fca_l1", "fca_l1.code", "=", "fca_l2.parent_code")
                ->whereBetween("gl.txn_date", array($request->datefrom, $request->dateto), "and")
                ->select(DB::raw("
                    fca_l1.code as 'L1_Code', fca_l1.title as 'L1_Title', 
                    fca_l2.code as 'L2_Code', fca_l2.title as 'L2_Title', 
                    fca_l3.code as 'L3_Code', fca_l3.title as 'L3_Title', 
                    fca_l4.code as 'L4_Code', fca_l4.title as 'L4_Title', 
                    fca_l5.code as 'L5_Code', fca_l5.title as 'L5_Title', 
                    gld.debit,gld.credit, gl.txn_date, gl.id"))
                ->get();

        /*
         *    +"L1_Code": "01"
          +"L1_Title": "Assets"
          +"L2_Code": "01-01"
          +"L2_Title": "Non-Current Assets"
          +"L3_Code": "01-01-004"
          +"L3_Title": "Lendings"
          +"L4_Code": "01-01-004-001"
          +"L4_Title": "Lendings To Financial Institutions"
          +"L5_Code": "01-01-004-001-0001"
          +"L5_Title": "Lendings To Financial Institutions"
          +"debit": "9290000.00"
          +"credit": "0.00"
          +"txn_date": "2022-03-24"
          +"id": 1
         */

        $l1_array = array();
        $l2_array = array();
        $l3_array = array();
        $l4_array = array();
        $l5_array = array();
        $raja_array = array();
        if ($ReportData) {
            foreach ($ReportData as $reportrow) {
                $raja_array[$reportrow->L1_Code][$reportrow->L2_Code][$reportrow->L3_Code][$reportrow->L4_Code][$reportrow->L5_Code][] = $reportrow;
                $l1_array[$reportrow->L1_Code]['Debit'] += $reportrow->debit;
                $l1_array[$reportrow->L1_Code]['Credit'] += $reportrow->credit;
                $l1_array[$reportrow->L1_Code]['Title'] = $reportrow->L1_Title;

                $l2_array[$reportrow->L2_Code]['Debit'] += $reportrow->debit;
                $l2_array[$reportrow->L2_Code]['Credit'] += $reportrow->credit;
                $l2_array[$reportrow->L2_Code]['Title'] = $reportrow->L2_Title;

                $l3_array[$reportrow->L3_Code]['Debit'] += $reportrow->debit;
                $l3_array[$reportrow->L3_Code]['Credit'] += $reportrow->credit;
                $l3_array[$reportrow->L3_Code]['Title'] = $reportrow->L3_Title;

                $l4_array[$reportrow->L4_Code]['Debit'] += $reportrow->debit;
                $l4_array[$reportrow->L4_Code]['Credit'] += $reportrow->credit;
                $l4_array[$reportrow->L4_Code]['Title'] = $reportrow->L4_Title;

                $l5_array[$reportrow->L5_Code]['Debit'] += $reportrow->debit;
                $l5_array[$reportrow->L5_Code]['Credit'] += $reportrow->credit;
                $l5_array[$reportrow->L5_Code]['Title'] = $reportrow->L5_Title;
            }
        }

//        echo "<pre>";
//        print_r($l1_array);
//        print_r($l2_array);
//        print_r($l3_array);
//        print_r($l4_array);
//        print_r($l5_array);
//        
//        print_r($raja_array);
//        echo "</pre>";
//        dd($ReportData);

        $d['L1'] = $l1_array;
        $d['L2'] = $l2_array;
        $d['L3'] = $l3_array;
        $d['L4'] = $l4_array;
        $d['L5'] = $l5_array;
        $d['ReportData'] = $raja_array;

        return view('reports.trialreport', $d);
        //dd($request->all());
    }

    public function Financial() {
        //dd("Yeah");
        $d['report'] = "Financial";

        $d['chartOfAccounts'] = \App\Models\FinChartOfAccount::where('level', 'L5')->select('id', 'title', 'code')->orderBy("code")->get();

        return view('reports.finreport', $d);
    }

    public function FinancialReport(Request $request) {

        //dd($request->all());
        $this->validate($request, [
            'datefrom' => 'required|date',
            'dateto' => 'required|date'
                ], [], ['datefrom' => 'Date From', 'dateto' => 'Date To']);

        $d['datef'] = $request->datefrom;
        $d['datet'] = $request->dateto;
        $d['chartofaccount'] = $request->chartofaccount;
        $d['i'] = 0;

        /*
          select fca.code, fca.title, fca.parent_code, gld.debit,gld.debit, gl.txn_date
          from fin_general_ledgers as gl
          inner join fin_general_ledger_details as gld on gld.fin_gen_id = gl.id
          inner join fin_chart_of_accounts as fca on fca.id = gld.coa_id
          where gl.txn_date BETWEEN '' and ''
         */
        $ReportData = DB::table("fin_general_ledgers as gl")
                ->join("fin_general_ledger_details as gld", "gld.fin_gen_id", "=", "gl.id")
                ->join("fin_chart_of_accounts as fca", "fca.id", "=", "gld.coa_id")
                ->whereBetween("gl.txn_date", array($request->datefrom, $request->dateto), "and")
                ->select(DB::raw(""
                                . "fca.code, fca.title, fca.parent_code, gld.debit,gld.credit, gl.txn_date, gl.id, gl.txn_type, gl.txn_series"))
                ->get();
        if (isset($request->chartofaccount)) {
            $ReportData = DB::table("fin_general_ledgers as gl")
                    ->join("fin_general_ledger_details as gld", "gld.fin_gen_id", "=", "gl.id")
                    ->join("fin_chart_of_accounts as fca", "fca.id", "=", "gld.coa_id")
                    ->whereBetween("gl.txn_date", array($request->datefrom, $request->dateto), "and")
                    ->where("gld.coa_id", $request->chartofaccount)
                    ->select(DB::raw(""
                                    . "fca.code, fca.title, fca.parent_code, gld.debit,gld.credit, gl.txn_date, gl.id"))
                    ->get();
        }
        $raja_array = array();
        if ($ReportData) {
            foreach ($ReportData as $reportrow) {
                $raja_array[$reportrow->id][] = $reportrow;
            }
        }

        //dd($raja_array);
        $d['ReportData'] = $raja_array;

        return view('reports.finreport', $d);
        //dd($request->all());
    }

    public function Dues() {
        //dd("Yeah");
        $d['report'] = "Dues";
        return view('reports.dues', $d);
    }

    public function DuesReport(Request $request) {
        $this->validate($request, [
            'datefrom' => 'required|date',
            'dateto' => 'required|date'
                ], [], ['datefrom' => 'Date From', 'dateto' => 'Date To']);

        $d['datef'] = $request->datefrom;
        $d['datet'] = $request->dateto;
        $d['i'] = 0;

        $ReportData = DB::table("loan_history")
                ->join("loan_borrowers", "loan_borrowers.id", "=", "loan_history.borrower_id")
                ->join("loan_payment_due", "loan_payment_due.loan_id", "=", "loan_history.id")
                ->join("general_offices", "general_offices.id", "=", "loan_history.office_id")
                ->where("loan_payment_due.payment_status", "=", "0")
                ->groupBy("loan_history.id")
                ->select(DB::raw(""
                                . "concat(loan_borrowers.fname,' ',loan_borrowers.mname,' ', loan_borrowers.lname) as 'b_name', "
                                . "general_offices.name, "
                                . "sum(loan_payment_due.amount_pr) as 's_am_pr', "
                                . "sum(loan_payment_due.amount_mu) as 's_am_mu',"
                                . "sum(if(loan_payment_due.due_date between '" . ($request->datefrom) . "' and '" . ($request->dateto) . "',loan_payment_due.amount_pr,0 )) as 'c_am_pr', "
                                . "sum(if(loan_payment_due.due_date between '" . ($request->datefrom) . "' and '" . ($request->dateto) . "',loan_payment_due.amount_mu,0 )) as 'c_am_mu' "
                                . ""), "loan_history.*")
                ->get();
        $d['ReportData'] = $ReportData;
//        dd($ReportData);
//        $loanBankslips = DB::table('loan_bankslips')
//            ->join('loan_payment_recovereds', 'loan_payment_recovereds.bank_slip_id', '=', 'loan_bankslips.id')
//            ->join('fin_banks_accounts', 'fin_banks_accounts.id', '=', 'loan_bankslips.bankAccountId')
//            ->groupBy('loan_bankslips.id')
//            ->select('loan_bankslips.*', 'fin_banks_accounts.bank_name', DB::raw('sum(loan_payment_recovereds.amount_total) as amount_sum'))
//
//            ->get();

        return view('reports.dues', $d);
        //dd($request->all());
    }

    public function Payments() {
        //dd("Yeah");
        $d['report'] = "Dues";
        return view('reports.payments', $d);
    }

    public function PaymentsReport(Request $request) {
        $this->validate($request, [
            'datefrom' => 'required|date',
            'dateto' => 'required|date'
                ], [], ['datefrom' => 'Date From', 'dateto' => 'Date To']);

        $d['datef'] = $request->datefrom;
        $d['datet'] = $request->dateto;
        $d['i'] = 0;

        $ReportData = DB::table("loan_history")
                ->join("loan_borrowers", "loan_borrowers.id", "=", "loan_history.borrower_id")
                ->join("loan_payment_due", "loan_payment_due.loan_id", "=", "loan_history.id")
                ->join("general_offices", "general_offices.id", "=", "loan_history.office_id")
                ->where("loan_payment_due.payment_status", "=", "0")
                ->groupBy("loan_history.id")
                ->select(DB::raw(""
                                . "concat(loan_borrowers.fname,' ',loan_borrowers.mname,' ', loan_borrowers.lname) as 'b_name', "
                                . "general_offices.name, "
                                . "sum(loan_payment_due.amount_pr) as 's_am_pr', "
                                . "sum(loan_payment_due.amount_mu) as 's_am_mu',"
                                . "sum(if(loan_payment_due.due_date between '" . ($request->datefrom) . "' and '" . ($request->dateto) . "',loan_payment_due.amount_pr,0 )) as 'c_am_pr', "
                                . "sum(if(loan_payment_due.due_date between '" . ($request->datefrom) . "' and '" . ($request->dateto) . "',loan_payment_due.amount_mu,0 )) as 'c_am_mu' "
                                . ""), "loan_history.*")
                ->get();
        $d['ReportData'] = $ReportData;
//        dd($ReportData);
//        $loanBankslips = DB::table('loan_bankslips')
//            ->join('loan_payment_recovereds', 'loan_payment_recovereds.bank_slip_id', '=', 'loan_bankslips.id')
//            ->join('fin_banks_accounts', 'fin_banks_accounts.id', '=', 'loan_bankslips.bankAccountId')
//            ->groupBy('loan_bankslips.id')
//            ->select('loan_bankslips.*', 'fin_banks_accounts.bank_name', DB::raw('sum(loan_payment_recovereds.amount_total) as amount_sum'))
//
//            ->get();

        return view('reports.payments', $d);
        //dd($request->all());
    }

}
