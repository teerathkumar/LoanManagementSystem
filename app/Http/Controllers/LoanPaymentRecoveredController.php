<?php

namespace App\Http\Controllers;

use App\Models\LoanPaymentRecovered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class LoanPaymentRecoveredController
 * @package App\Http\Controllers
 */
class LoanPaymentRecoveredController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay_installment($loanId) {

        // amount_total amount_pr amount_mu
        $TotalAmountDue = \App\Models\LoanPaymentDue::where(
                        ['loan_id' => $loanId, 'payment_status' => 0, ['due_date', '<=', date('Y-m-d')]]
                )->sum('amount_total');
        $TotalAmountDue = $TotalAmountDue ? $TotalAmountDue : 0;
        
        
        $AmountInstallment = \App\Models\LoanPaymentDue::where(
                        ['loan_id' => $loanId, 'payment_status' => 0]
                )->first('amount_total');
        $AmountInstallment = $AmountInstallment ? $AmountInstallment->amount_total : 0;
        //dd($AmountInstallment);
        $loanPaymentRecovered = new LoanPaymentRecovered();
        //echo "Here it is";
        //dd($TotalAmountDue);
        
        
        $DDLList = [];
        if(\App\Models\LoanBankslip::where('slipDate',date('Y-m-d'))->count()<=0){
            //echo "Is it here";
            \App\Models\LoanBankslip::create(['slipDate'=>date('Y-m-d'),'name'=>'Manual Repayments']);
            $BankSlips = \App\Models\LoanBankslip::where('slipDate',date('Y-m-d'))->get();
        } else {
            $BankSlips = \App\Models\LoanBankslip::where('slipDate',date('Y-m-d'))->get();
        }
        //dd($BankSlips);
        foreach ($BankSlips as $BankSlips) {
            $DDLList[$BankSlips->id] = $BankSlips->name.' '.$BankSlips->slipDate;
        }

        return view('loan-payment-recovered.pay', compact('loanPaymentRecovered'))->with(['loanId' => $loanId, 'TotalAmountDue' => $TotalAmountDue, 'DDLList' => $DDLList, 'AmountInstallment' => $AmountInstallment]);
    }

    public function index() {
        $loanPaymentRecovereds = LoanPaymentRecovered::get();

        return view('loan-payment-recovered.index', compact('loanPaymentRecovereds'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $loanPaymentRecovered = new LoanPaymentRecovered();
        return view('loan-payment-recovered.create', compact('loanPaymentRecovered'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(LoanPaymentRecovered::$rules);

        $loanPaymentRecovered = LoanPaymentRecovered::create($request->all());

        return redirect()->route('loan-payment-recovereds.index')
                        ->with('flash_success', 'Loan Payment created successfully.');
    }

    public function storepay(Request $request) {
        request()->validate(LoanPaymentRecovered::$rules);
        //echo auth()->user()->name;
        //dd(auth()->user());
        $loanId = $request->loan_id;
        $payableAmount = $request->amount_total;
        $recovered_by = $request->recovered_by;
        $recovered_date = $request->recovered_date;
        $bank_slip_id = $request->bank_slip_id;
        //dd($request->all());

        $TotalAmountDue = \App\Models\LoanPaymentDue::where(
                        ['loan_id' => $loanId, 'payment_status' => 0, ['due_date', '<=', date("Y-m-d")]]
                )->sum('amount_total');
        $DueData = \App\Models\LoanPaymentDue::where(
                        ['loan_id' => $loanId, 'payment_status' => 0]
                )->get();
        $balancePayableAmount = $payableAmount;
        $PaidArray = [];
        $PartialPaidArray = [];
        //echo $balancePayableAmount;
        //echo "<br>";
        foreach ($DueData as $Dues) {
            $DueId = $Dues->id;
            $DueAmountTotal = $Dues->amount_total;
            $DuePr = $Dues->amount_pr;
            $DueMu = $Dues->amount_mu;
            $DueTk = $Dues->amount_takaful;

            $PaidRecord = LoanPaymentRecovered::where(['due_id' => $DueId])->first();
            if ($PaidRecord) {
                $DueAmountTotal -= $PaidRecord->amount_total;
                $DuePr -= $PaidRecord->amount_pr;
                $DueMu -= $PaidRecord->amount_mu;
                $DueTk -= $PaidRecord->amount_takaful;
            }
            //dd($PaidRecord);
            if ($balancePayableAmount > 0 && $balancePayableAmount >= $DueAmountTotal) {
                $balancePayableAmount -= $DueAmountTotal;
                $PaidArray[$DueId] = [$DueAmountTotal, $DuePr, $DueMu, $DueTk, 1];
            } else if ($balancePayableAmount > 0 && $balancePayableAmount < $DueAmountTotal) {

                if ($balancePayableAmount >= $DueMu) {
                    if ($balancePayableAmount == $DueMu) {
                        $DueMu = $balancePayableAmount;
                        $DuePr = 0;
                        $DueTk = 0;
                    } else {


                        $balancePayableAmount -= $DueMu;
                        if ($balancePayableAmount >= $DueTk) {
                            $balancePayableAmount -= $DueTk;
                        }
                        if ($balancePayableAmount > 0) {
                            $DuePr = $balancePayableAmount;
                        } else {
                            $DuePr = 0;
                        }
                    }
                } else {
                    $DueMu = $balancePayableAmount;
                    $DuePr = 0;
                    $DueTk = 0;
                }
                $DueAmountTotal = $DuePr + $DueMu+$DueTk;
                $balancePayableAmount -= $DueAmountTotal;
                $PaidArray[$DueId] = [$DueAmountTotal, $DuePr, $DueMu, $DueTk, 0];
            } else {
                break;
            }
        }
        //echo $balancePayableAmount;
        //echo "<br>";
        //dd($PaidArray);



        DB::beginTransaction();

        try {
            $PaidPrincipal = $PaidMarkup = $PaidTakaful = 0;
            foreach ($PaidArray as $DueId => $DueData) {
                $PayData = [
                    'loan_id' => $loanId,
                    'due_id' => $DueId,
                    'amount_total' => $DueData[0],
                    'amount_pr' => $DueData[1],
                    'amount_mu' => $DueData[2],
                    'amount_takaful' => $DueData[3],
                    'recovered_by' => $recovered_by,
                    'recovered_date' => $recovered_date,
                    'bank_slip_id' => $bank_slip_id
                ];
                LoanPaymentRecovered::create($PayData);

                if ($DueData[4] == 1) {
                    $DueDataUpdate = ['payment_status' => $DueData[4]];
                    \App\Models\LoanPaymentDue::find($DueId)->update($DueDataUpdate);
                }

                $PaidPrincipal += $DueData[1];
                $PaidMarkup += $DueData[2];
                $PaidTakaful += $DueData[3];
            }
            
            
            $LastSeries = \App\Models\FinGeneralLedger::orderBy("id", "desc")->first()->txn_series;
            $NextSeries = $LastSeries+1;
            //Maintain General Ledger
            $Model_GL = \App\Models\FinGeneralLedger::create([
                        'slip_id' => 1,'loan_id'=>$loanId, 'user_id' => 1,'details'=>'Repayment Voucher', 'debit' => $payableAmount, 'credit' => $payableAmount, 'txn_date' => $recovered_date, 'txn_type' => 1,'txn_series'=>$NextSeries++, 'office_id' => 1
            ]);
            $FinGL_Id = $Model_GL->id;
            //JS Bank
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id, 'coa_id' => '172', 'debit' => $payableAmount, 'credit' => 0]);
            //Lendings To Financial Institutions
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id' => '147', 'debit' => 0, 'credit' => $PaidPrincipal]);
            //Takaful
            if($PaidTakaful){
                \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id' => '187', 'debit' => 0, 'credit' => $PaidTakaful]);
            }
            
            //Profit/Markup
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id' => '177', 'debit' => 0, 'credit' => $PaidMarkup]);

            
            //Maintain General Ledger
            $Model_GL = \App\Models\FinGeneralLedger::create([
                        'slip_id' => 1, 'user_id' => 1,'details'=>'Profit Voucher', 'debit' => $PaidMarkup, 'credit' => $PaidMarkup, 'txn_date' => $recovered_date, 'txn_type' => 1,'txn_series'=>$NextSeries++, 'office_id' => 1
            ]);
            $FinGL_Id = $Model_GL->id;
            //Profit/Markup Rec
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id' => '177', 'debit' => $PaidMarkup, 'credit' => 0]);
            //Profit on lending
            \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id,'coa_id' => '331', 'debit' => 0, 'credit' => $PaidMarkup]);
            
            DB::commit();
            return redirect()->route('loan-payment-recovereds.index')
                            ->with('flash_success', 'Loan Payment created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loan-payment-recovereds.index')
                            ->with('flash_error', 'Loan Payment Failed.');
        }


        //echo $balancePayableAmount;
        //echo "<br>";
        //dd($PaidArray);
        //$loanPaymentRecovered = LoanPaymentRecovered::create($request->all());

        return redirect()->route('loan-payment-recovereds.index')
                        ->with('flash_success', 'Loan Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $loanPaymentRecovered = LoanPaymentRecovered::find($id);

        return view('loan-payment-recovered.show', compact('loanPaymentRecovered'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $loanPaymentRecovered = LoanPaymentRecovered::find($id);

        return view('loan-payment-recovered.edit', compact('loanPaymentRecovered'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanPaymentRecovered $loanPaymentRecovered
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanPaymentRecovered $loanPaymentRecovered) {
        request()->validate(LoanPaymentRecovered::$rules);

        $loanPaymentRecovered->update($request->all());

        return redirect()->route('loan-payment-recovereds.index')
                        ->with('flash_success', 'Loan Payment updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $loanPaymentRecovered = LoanPaymentRecovered::find($id)->delete();

        return redirect()->route('loan-payment-recovereds.index')
                        ->with('flash_success', 'Loan Payment deleted successfully');
    }

}
