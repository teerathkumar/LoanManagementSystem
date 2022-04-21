<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace App\Models;

use Eloquent;

class LoanRepayment extends Eloquent {

    protected $table = 'loan_payment_recovered';
    protected $fillable = [
        'due_id',
        'loan_id',
        'amount_total',
        'amount_pr',
        'amount_mu',
        'amount_penalty',
        'recovered_by',
        'recovered_date',
        'bank_slip_id'
    ];

    //
}
