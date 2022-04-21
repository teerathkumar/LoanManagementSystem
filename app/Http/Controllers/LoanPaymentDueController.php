<?php

namespace App\Http\Controllers;

use App\Models\LoanPaymentDue;
use Illuminate\Http\Request;

/**
 * Class LoanPaymentDueController
 * @package App\Http\Controllers
 */
class LoanPaymentDueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanPaymentDues = LoanPaymentDue::get();

        return view('loan-payment-due.index', compact('loanPaymentDues'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanPaymentDue = new LoanPaymentDue();
        return view('loan-payment-due.create', compact('loanPaymentDue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanPaymentDue::$rules);

        $loanPaymentDue = LoanPaymentDue::create($request->all());

        return redirect()->route('loan-payment-dues.index')
            ->with('flash_success', 'LoanPaymentDue created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanPaymentDue = LoanPaymentDue::find($id);

        return view('loan-payment-due.show', compact('loanPaymentDue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanPaymentDue = LoanPaymentDue::find($id);

        return view('loan-payment-due.edit', compact('loanPaymentDue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanPaymentDue $loanPaymentDue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanPaymentDue $loanPaymentDue)
    {
        request()->validate(LoanPaymentDue::$rules);

        $loanPaymentDue->update($request->all());

        return redirect()->route('loan-payment-dues.index')
            ->with('flash_success', 'LoanPaymentDue updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanPaymentDue = LoanPaymentDue::find($id)->delete();

        return redirect()->route('loan-payment-dues.index')
            ->with('flash_success', 'LoanPaymentDue deleted successfully');
    }
}
