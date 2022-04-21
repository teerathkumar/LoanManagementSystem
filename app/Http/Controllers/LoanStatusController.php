<?php

namespace App\Http\Controllers;

use App\Models\LoanStatus;
use Illuminate\Http\Request;

/**
 * Class LoanStatusController
 * @package App\Http\Controllers
 */
class LoanStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanStatuses = LoanStatus::get();

        return view('loan-status.index', compact('loanStatuses'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanStatus = new LoanStatus();
        return view('loan-status.create', compact('loanStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanStatus::$rules);

        $loanStatus = LoanStatus::create($request->all());

        return redirect()->route('loan-statuses.index')
            ->with('flash_success', 'LoanStatus created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanStatus = LoanStatus::find($id);

        return view('loan-status.show', compact('loanStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanStatus = LoanStatus::find($id);

        return view('loan-status.edit', compact('loanStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanStatus $loanStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanStatus $loanStatus)
    {
        request()->validate(LoanStatus::$rules);

        $loanStatus->update($request->all());

        return redirect()->route('loan-statuses.index')
            ->with('flash_success', 'LoanStatus updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanStatus = LoanStatus::find($id)->delete();

        return redirect()->route('loan-statuses.index')
            ->with('flash_success', 'LoanStatus deleted successfully');
    }
}
