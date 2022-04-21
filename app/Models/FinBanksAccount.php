<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinBanksAccount
 *
 * @property $id
 * @property $bank_name
 * @property $bank_account
 * @property $trans_amount
 * @property $slip_date
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FinBanksAccount extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['bank_name','bank_account','trans_amount','slip_date'];



}
