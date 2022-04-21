<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanBankslip
 *
 * @property $id
 * @property $name
 * @property $amount
 * @property $bankAccountId
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanBankslip extends Model
{
    
    static $rules = [
		'name' => 'required',
		'amount' => 'required',
		'bankAccountId' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','slipDate', 'amount','bankAccountId'];

    public function recovered()
    {
        return $this->hasMany(LoanPaymentRecovered::class, 'bank_slip_id');
    }
    public function accounts()
    {
        return $this->belongsTo(FinBanksAccount::class, 'bankAccountId');
    }


}
