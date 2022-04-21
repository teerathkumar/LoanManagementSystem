<?php

namespace App\Http\Controllers;

use App\Models\HrEmployee;
use Illuminate\Http\Request;

/**
 * Class HrEmployeeController
 * @package App\Http\Controllers
 */
class HrEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hrEmployees = HrEmployee::get();

        return view('hr-employee.index', compact('hrEmployees'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hrEmployee = new HrEmployee();
        return view('hr-employee.create', compact('hrEmployee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(HrEmployee::$rules);

        $hrEmployee = HrEmployee::create($request->all());

        return redirect()->route('hr-employees.index')
            ->with('flash_success', 'HrEmployee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hrEmployee = HrEmployee::find($id);

        return view('hr-employee.show', compact('hrEmployee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hrEmployee = HrEmployee::find($id);

        return view('hr-employee.edit', compact('hrEmployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  HrEmployee $hrEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrEmployee $hrEmployee)
    {
        request()->validate(HrEmployee::$rules);

        $hrEmployee->update($request->all());

        return redirect()->route('hr-employees.index')
            ->with('flash_success', 'HrEmployee updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $hrEmployee = HrEmployee::find($id)->delete();

        return redirect()->route('hr-employees.index')
            ->with('flash_success', 'HrEmployee deleted successfully');
    }
}
