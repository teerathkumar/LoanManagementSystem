<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinGeneralLedgerDetail
 *
 * @property $id
 * @property $coa_id
 * @property $debit
 * @property $credit
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FinGeneralLedgerDetail extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['coa_id','fin_gen_id','debit','credit'];



}
