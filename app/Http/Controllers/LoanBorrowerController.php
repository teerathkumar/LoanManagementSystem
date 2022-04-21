<?php

namespace App\Http\Controllers;

use App\Models\LoanBorrower;
use Illuminate\Http\Request;

/**
 * Class LoanBorrowerController
 * @package App\Http\Controllers
 */
class LoanBorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanBorrowers = LoanBorrower::get();

        return view('loan-borrower.index', compact('loanBorrowers'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanBorrower = new LoanBorrower();
        return view('loan-borrower.create', compact('loanBorrower'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanBorrower::$rules);

        $loanBorrower = LoanBorrower::create($request->all());

        return redirect()->route('loan-borrowers.index')
            ->with('flash_success', 'LoanBorrower created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanBorrower = LoanBorrower::find($id);

        return view('loan-borrower.show', compact('loanBorrower'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanBorrower = LoanBorrower::find($id);

        return view('loan-borrower.edit', compact('loanBorrower'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanBorrower $loanBorrower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanBorrower $loanBorrower)
    {
        request()->validate(LoanBorrower::$rules);

        $loanBorrower->update($request->all());

        return redirect()->route('loan-borrowers.index')
            ->with('flash_success', 'LoanBorrower updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanBorrower = LoanBorrower::find($id)->delete();

        return redirect()->route('loan-borrowers.index')
            ->with('flash_success', 'LoanBorrower deleted successfully');
    }
}
