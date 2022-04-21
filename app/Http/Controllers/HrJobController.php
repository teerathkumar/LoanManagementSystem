<?php

namespace App\Http\Controllers;

use App\Models\HrJob;
use Illuminate\Http\Request;

/**
 * Class HrJobController
 * @package App\Http\Controllers
 */
class HrJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hrJobs = HrJob::get();

        return view('hr-job.index', compact('hrJobs'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hrJob = new HrJob();
        return view('hr-job.create', compact('hrJob'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(HrJob::$rules);

        $hrJob = HrJob::create($request->all());

        return redirect()->route('hr-jobs.index')
            ->with('flash_success', 'HrJob created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hrJob = HrJob::find($id);

        return view('hr-job.show', compact('hrJob'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hrJob = HrJob::find($id);

        return view('hr-job.edit', compact('hrJob'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  HrJob $hrJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrJob $hrJob)
    {
        request()->validate(HrJob::$rules);

        $hrJob->update($request->all());

        return redirect()->route('hr-jobs.index')
            ->with('flash_success', 'HrJob updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $hrJob = HrJob::find($id)->delete();

        return redirect()->route('hr-jobs.index')
            ->with('flash_success', 'HrJob deleted successfully');
    }
}
