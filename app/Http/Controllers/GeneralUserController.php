<?php

namespace App\Http\Controllers;

use App\Models\GeneralUser;
use Illuminate\Http\Request;

/**
 * Class GeneralUserController
 * @package App\Http\Controllers
 */
class GeneralUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalUsers = \App\User::get();

        return view('general-user.index', compact('generalUsers'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generalUser = new GeneralUser();
        return view('general-user.create', compact('generalUser'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(GeneralUser::$rules);

        $generalUser = GeneralUser::create($request->all());

        return redirect()->route('general-users.index')
            ->with('flash_success', 'GeneralUser created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $generalUser = GeneralUser::find($id);

        return view('general-user.show', compact('generalUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $generalUser = GeneralUser::find($id);

        return view('general-user.edit', compact('generalUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  GeneralUser $generalUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralUser $generalUser)
    {
        request()->validate(GeneralUser::$rules);

        $generalUser->update($request->all());

        return redirect()->route('general-users.index')
            ->with('flash_success', 'GeneralUser updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $generalUser = GeneralUser::find($id)->delete();

        return redirect()->route('general-users.index')
            ->with('flash_success', 'GeneralUser deleted successfully');
    }
}
