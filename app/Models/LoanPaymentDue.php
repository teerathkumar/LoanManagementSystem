<?php

namespace App\Models;

use Eloquent;

class LoanPaymentDue extends Eloquent
{
    protected $table = 'loan_payment_due';
    protected $fillable = ['loan_id', 'amount_total','amount_pr', 'amount_mu','amount_takaful','outstanding', 'due_date', 'installment_no','due_status','payment_status'];
    //
    public function loan_history()
    {
        return $this->belongsTo(LoanHistory::class, 'loan_id');
    }
}