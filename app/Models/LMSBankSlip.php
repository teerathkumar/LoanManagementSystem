<?php

namespace App\Models;

use Eloquent;

class LMSBankSlip extends Eloquent {

    protected $table = 'fin_banks_accounts';
    protected $fillable = [
        'bank_name', 'bank_account', 'trans_amount', 'slip_date'
    ];

    //
}
