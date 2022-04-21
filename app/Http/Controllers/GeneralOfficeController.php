<?php

namespace App\Http\Controllers;

use App\Models\GeneralOffice;
use Illuminate\Http\Request;

/**
 * Class GeneralOfficeController
 * @package App\Http\Controllers
 */
class GeneralOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalOffices = GeneralOffice::get();

        return view('general-office.index', compact('generalOffices'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generalOffice = new GeneralOffice();
        return view('general-office.create', compact('generalOffice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(GeneralOffice::$rules);

        $generalOffice = GeneralOffice::create($request->all());

        return redirect()->route('general-offices.index')
            ->with('flash_success', 'GeneralOffice created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $generalOffice = GeneralOffice::find($id);

        return view('general-office.show', compact('generalOffice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $generalOffice = GeneralOffice::find($id);

        return view('general-office.edit', compact('generalOffice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  GeneralOffice $generalOffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralOffice $generalOffice)
    {
        request()->validate(GeneralOffice::$rules);

        $generalOffice->update($request->all());

        return redirect()->route('general-offices.index')
            ->with('flash_success', 'GeneralOffice updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $generalOffice = GeneralOffice::find($id)->delete();

        return redirect()->route('general-offices.index')
            ->with('flash_success', 'GeneralOffice deleted successfully');
    }
}
