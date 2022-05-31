<?php

namespace App\Http\Controllers;

use App\Models\LoanKiborHistory;
use Illuminate\Http\Request;

/**
 * Class LoanKiborHistoryController
 * @package App\Http\Controllers
 */
class LoanKiborHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanKiborHistories = LoanKiborHistory::get();

        return view('loan-kibor-history.index', compact('loanKiborHistories'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanKiborHistory = new LoanKiborHistory();
        return view('loan-kibor-history.create', compact('loanKiborHistory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanKiborHistory::$rules);

        $loanKiborHistory = LoanKiborHistory::create($request->all());

        return redirect()->route('loan-kibor-histories.index')
            ->with('flash_success', 'LoanKiborHistory created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanKiborHistory = LoanKiborHistory::find($id);

        return view('loan-kibor-history.show', compact('loanKiborHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanKiborHistory = LoanKiborHistory::find($id);

        return view('loan-kibor-history.edit', compact('loanKiborHistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanKiborHistory $loanKiborHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanKiborHistory $loanKiborHistory)
    {
        request()->validate(LoanKiborHistory::$rules);

        $loanKiborHistory->update($request->all());

        return redirect()->route('loan-kibor-histories.index')
            ->with('flash_success', 'LoanKiborHistory updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanKiborHistory = LoanKiborHistory::find($id)->delete();

        return redirect()->route('loan-kibor-histories.index')
            ->with('flash_success', 'LoanKiborHistory deleted successfully');
    }
}
