<?php

namespace App\Http\Controllers;

use App\Models\FinChartOfAccount;
use Illuminate\Http\Request;

/**
 * Class FinChartOfAccountController
 * @package App\Http\Controllers
 */
class FinChartOfAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finChartOfAccounts = FinChartOfAccount::get();

        return view('fin-chart-of-account.index', compact('finChartOfAccounts'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $finChartOfAccount = new FinChartOfAccount();
        return view('fin-chart-of-account.create', compact('finChartOfAccount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FinChartOfAccount::$rules);

        $finChartOfAccount = FinChartOfAccount::create($request->all());

        return redirect()->route('fin-chart-of-accounts.index')
            ->with('flash_success', 'FinChartOfAccount created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finChartOfAccount = FinChartOfAccount::find($id);

        return view('fin-chart-of-account.show', compact('finChartOfAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finChartOfAccount = FinChartOfAccount::find($id);

        return view('fin-chart-of-account.edit', compact('finChartOfAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FinChartOfAccount $finChartOfAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinChartOfAccount $finChartOfAccount)
    {
        request()->validate(FinChartOfAccount::$rules);

        $finChartOfAccount->update($request->all());

        return redirect()->route('fin-chart-of-accounts.index')
            ->with('flash_success', 'FinChartOfAccount updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finChartOfAccount = FinChartOfAccount::find($id)->delete();

        return redirect()->route('fin-chart-of-accounts.index')
            ->with('flash_success', 'FinChartOfAccount deleted successfully');
    }
}
