<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanPaymentRecovered
 *
 * @property $id
 * @property $due_id
 * @property $loan_id
 * @property $amount_total
 * @property $amount_pr
 * @property $amount_mu
 * @property $amount_penalty
 * @property $recovered_by
 * @property $recovered_date
 * @property $bank_slip_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanPaymentRecovered extends Model
{
    protected $table = 'loan_payment_recovered';
    static $rules = [
            'amount_total' => 'required|min:6',
            'recovered_by' => 'required',
            'recovered_date' => 'required',
            'bank_slip_id' => 'required',
        
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['due_id','loan_id','amount_total','amount_pr','amount_mu','amount_fed','amount_settlement','amount_takaful','amount_penalty','recovered_by','recovered_date','bank_slip_id','payment_type'];



}
