<?php

namespace App\Http\Controllers;

use App\Models\FinGeneralLedger;
use App\User;
use App\Models\FinChartOfAccount;
use Illuminate\Http\Request;

/**
 * Class FinGeneralLedgerController
 * @package App\Http\Controllers
 */
class FinGeneralLedgerController extends Controller
{
    public static function addDigits($i, $zeroes) {
        // 1 - 5
        $ret = '';
        $num = mb_strlen($i);
        $Net = $zeroes - $num;
        for ($j = 0; $j < $Net; $j++) {
            $ret .= "0";
        }
        return $ret . $i;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finGeneralLedgers = FinGeneralLedger::get();

        return view('fin-general-ledger.index', compact('finGeneralLedgers'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $finGeneralLedger = new FinGeneralLedger();
        $chartOfAccounts = FinChartOfAccount::where("level","L5")->orderBy("code")->get();
        $TxnDate = date("M d Y");
        $Reference = "BPV001";
        
        return view('fin-general-ledger.create', compact('finGeneralLedger','chartOfAccounts', 'Reference', 'TxnDate'));
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FinGeneralLedger::$rules);
        
        
        $LastSeries = FinGeneralLedger::orderBy("id", "desc")->first()->txn_series;
        extract($request->all());
        $TxnDate = date("Y-m-d", strtotime($TxnDate));
        //dd($request->all());
        $userId = \Illuminate\Support\Facades\Auth::user()->id;
        
        //Maintain General Ledger
        $Model_GL = \App\Models\FinGeneralLedger::create([
                    'user_id' => $userId,'details'=>$purpose, 'debit' => 0, 'credit' => 0, 'txn_date' => $TxnDate, 'txn_type' => 1,'txn_series'=>$LastSeries, 'office_id' => 1
        ]);
        $FinGL_Id = $Model_GL->id;
        
        $TotalDebit=0;
        $TotalCredit=0;
        foreach($chartofaccount as $key=>$val){
            if(isset($val)){     
                $TotalDebit+=$debit[$key];
                $TotalCredit+=$credit[$key];
                \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id'=>$FinGL_Id, 'coa_id' => $val, 'debit' => $debit[$key], 'credit' => $credit[$key]]);
            }
        }
        FinGeneralLedger::find($FinGL_Id)->update(['debit'=>$TotalDebit,'credit'=>$TotalCredit]);

        return redirect()->route('fin-general-ledgers.index')
            ->with('flash_success', 'Entry Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $finGeneralLedger = FinGeneralLedger::find($id);

        return view('fin-general-ledger.show', compact('finGeneralLedger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finGeneralLedger = FinGeneralLedger::find($id);

        return view('fin-general-ledger.edit', compact('finGeneralLedger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FinGeneralLedger $finGeneralLedger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinGeneralLedger $finGeneralLedger)
    {
        request()->validate(FinGeneralLedger::$rules);

        $finGeneralLedger->update($request->all());

        return redirect()->route('fin-general-ledgers.index')
            ->with('flash_success', 'FinGeneralLedger updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finGeneralLedger = FinGeneralLedger::find($id)->delete();

        return redirect()->route('fin-general-ledgers.index')
            ->with('flash_success', 'FinGeneralLedger deleted successfully');
    }
}
