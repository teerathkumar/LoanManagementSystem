<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


namespace App\Models;

use Eloquent;

class LoanHistory extends Eloquent
{
    protected $table = 'loan_history';
    protected $fillable = [
        'borrower_id', 
        'group_id', 
        'office_id', 
        'total_amount', 
	'total_amount_pr', 
	'total_amount_mu', 
	'total_amount_tak', 
	'loan_type_id', 
	'loan_period', 
	'markup_rate', 
	'loan_frequency', 
	'loan_status_id', 
	'disb_date', 
	'rep_start_date', 
	'closed_date',
    ];
    //
    
    public function loan_borrower()
    {
        return $this->belongsTo(LoanBorrower::class, 'borrower_id');
    }
    public function loan_status()
    {
        return $this->belongsTo(LoanStatus::class, 'loan_status_id');
    }
    public function loan_group()
    {
        return $this->belongsTo(LoanGroup::class, 'group_id');
    }
    public function loan_office()
    {
        return $this->belongsTo(GeneralOffice::class, 'office_id');
    }

}