<?php

namespace App\Http\Controllers;

use App\Models\AmlBlacklist;
use Illuminate\Http\Request;

/**
 * Class AmlBlacklistController
 * @package App\Http\Controllers
 */
class AmlBlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amlBlacklists = AmlBlacklist::get();

        return view('aml-blacklist.index', compact('amlBlacklists'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $amlBlacklist = new AmlBlacklist();
        return view('aml-blacklist.create', compact('amlBlacklist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(AmlBlacklist::$rules);

        $amlBlacklist = AmlBlacklist::create($request->all());

        return redirect()->route('aml-blacklists.index')
            ->with('flash_success', 'AmlBlacklist created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amlBlacklist = AmlBlacklist::find($id);

        return view('aml-blacklist.show', compact('amlBlacklist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $amlBlacklist = AmlBlacklist::find($id);

        return view('aml-blacklist.edit', compact('amlBlacklist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  AmlBlacklist $amlBlacklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AmlBlacklist $amlBlacklist)
    {
        request()->validate(AmlBlacklist::$rules);

        $amlBlacklist->update($request->all());

        return redirect()->route('aml-blacklists.index')
            ->with('flash_success', 'AmlBlacklist updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $amlBlacklist = AmlBlacklist::find($id)->delete();

        return redirect()->route('aml-blacklists.index')
            ->with('flash_success', 'AmlBlacklist deleted successfully');
    }
}
