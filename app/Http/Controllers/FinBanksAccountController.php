<?php

namespace App\Http\Controllers;

use App\Models\FinBanksAccount;
use Illuminate\Http\Request;

/**
 * Class FinBanksAccountController
 * @package App\Http\Controllers
 */
class FinBanksAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finBanksAccounts = FinBanksAccount::get();

        return view('fin-banks-account.index', compact('finBanksAccounts'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $finBanksAccount = new FinBanksAccount();
        return view('fin-banks-account.create', compact('finBanksAccount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FinBanksAccount::$rules);

        $finBanksAccount = FinBanksAccount::create($request->all());

        return redirect()->route('fin-banks-accounts.index')
            ->with('flash_success', 'FinBanksAccount created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finBanksAccount = FinBanksAccount::find($id);

        return view('fin-banks-account.show', compact('finBanksAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finBanksAccount = FinBanksAccount::find($id);

        return view('fin-banks-account.edit', compact('finBanksAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FinBanksAccount $finBanksAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinBanksAccount $finBanksAccount)
    {
        request()->validate(FinBanksAccount::$rules);

        $finBanksAccount->update($request->all());

        return redirect()->route('fin-banks-accounts.index')
            ->with('flash_success', 'FinBanksAccount updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finBanksAccount = FinBanksAccount::find($id)->delete();

        return redirect()->route('fin-banks-accounts.index')
            ->with('flash_success', 'FinBanksAccount deleted successfully');
    }
}
