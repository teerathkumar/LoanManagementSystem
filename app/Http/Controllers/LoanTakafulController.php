<?php

namespace App\Http\Controllers;

use App\Models\LoanTakaful;
use Illuminate\Http\Request;

/**
 * Class LoanTakafulController
 * @package App\Http\Controllers
 */
class LoanTakafulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanTakafuls = LoanTakaful::get();

        return view('loan-takaful.index', compact('loanTakafuls'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanTakaful = new LoanTakaful();
        return view('loan-takaful.create', compact('loanTakaful'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(LoanTakaful::$rules);

        $loanTakaful = LoanTakaful::create($request->all());

        return redirect()->route('loan-takafuls.index')
            ->with('flash_success', 'LoanTakaful created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanTakaful = LoanTakaful::find($id);

        return view('loan-takaful.show', compact('loanTakaful'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanTakaful = LoanTakaful::find($id);

        return view('loan-takaful.edit', compact('loanTakaful'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LoanTakaful $loanTakaful
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanTakaful $loanTakaful)
    {
        request()->validate(LoanTakaful::$rules);

        $loanTakaful->update($request->all());

        return redirect()->route('loan-takafuls.index')
            ->with('flash_success', 'LoanTakaful updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $loanTakaful = LoanTakaful::find($id)->delete();

        return redirect()->route('loan-takafuls.index')
            ->with('flash_success', 'LoanTakaful deleted successfully');
    }
}
