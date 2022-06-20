<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index() {
        
        $finGeneralLedgers = \App\Models\FinGeneralLedger::get();

        return view('fin-general-ledger.vouchers', compact('finGeneralLedgers'))->with('i');
    }
    
}
