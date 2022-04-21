<?php

namespace App\Http\Controllers;

use App\Models\FinGeneralLedgerDetail;
use Illuminate\Http\Request;

/**
 * Class FinGeneralLedgerDetailController
 * @package App\Http\Controllers
 */
class FinGeneralLedgerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finGeneralLedgerDetails = FinGeneralLedgerDetail::get();

        return view('fin-general-ledger-detail.index', compact('finGeneralLedgerDetails'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $finGeneralLedgerDetail = new FinGeneralLedgerDetail();
        return view('fin-general-ledger-detail.create', compact('finGeneralLedgerDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FinGeneralLedgerDetail::$rules);

        $finGeneralLedgerDetail = FinGeneralLedgerDetail::create($request->all());

        return redirect()->route('fin-general-ledger-details.index')
            ->with('flash_success', 'FinGeneralLedgerDetail created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finGeneralLedgerDetail = FinGeneralLedgerDetail::find($id);

        return view('fin-general-ledger-detail.show', compact('finGeneralLedgerDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finGeneralLedgerDetail = FinGeneralLedgerDetail::find($id);

        return view('fin-general-ledger-detail.edit', compact('finGeneralLedgerDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FinGeneralLedgerDetail $finGeneralLedgerDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinGeneralLedgerDetail $finGeneralLedgerDetail)
    {
        request()->validate(FinGeneralLedgerDetail::$rules);

        $finGeneralLedgerDetail->update($request->all());

        return redirect()->route('fin-general-ledger-details.index')
            ->with('flash_success', 'FinGeneralLedgerDetail updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finGeneralLedgerDetail = FinGeneralLedgerDetail::find($id)->delete();

        return redirect()->route('fin-general-ledger-details.index')
            ->with('flash_success', 'FinGeneralLedgerDetail deleted successfully');
    }
}
