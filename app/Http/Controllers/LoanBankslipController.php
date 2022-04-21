<?php

namespace App\Http\Controllers;

use App\Models\LoanBankslip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class LoanBankslipController
 * @package App\Http\Controllers
 */
class LoanBankslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$loanBankslips = LoanBankslip::orderby("id")->with("accounts")->get();
        //dd($loanBankslips);
        $loanBankslips = DB::table('loan_bankslips')
            ->join('loan_payment_recovereds', 'loan_payment_recovereds.bank_slip_id', '=', 'loan_bankslips.id')
            ->join('fin_banks_accounts', 'fin_banks_accounts.id', '=', 'loan_bankslips.bankAccountId')
            ->groupBy('loan_bankslips.id')
            ->select('loan_bankslips.*', 'fin_banks_accounts.bank_name', DB::raw('sum(loan_payment_recovereds.amount_total) as amount_sum'))

            ->get();
        //dd($users);
        //$LoanPaymentRec = new \App\Models\LoanPaymentRecovered;

        return view('loan-bankslip.index', compact('loanBankslips'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanBankslip = new LoanBankslip();
        return view('loan-bankslip.create', compact('loanBankslip'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanBankslip::$rules);

        $loanBankslip = LoanBankslip::create($request->all());

        return redirect()->route('loan-bankslips.index')
            ->with('flash_success', 'LoanBankslip created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanBankslip = LoanBankslip::find($id);

        return view('loan-bankslip.show', compact('loanBankslip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanBankslip = LoanBankslip::find($id);

        return view('loan-bankslip.edit', compact('loanBankslip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanBankslip $loanBankslip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanBankslip $loanBankslip)
    {
        request()->validate(LoanBankslip::$rules);

        $loanBankslip->update($request->all());

        return redirect()->route('loan-bankslips.index')
            ->with('flash_success', 'LoanBankslip updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanBankslip = LoanBankslip::find($id)->delete();

        return redirect()->route('loan-bankslips.index')
            ->with('flash_success', 'LoanBankslip deleted successfully');
    }
}
