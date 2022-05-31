<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanKiborRate
 *
 * @property $id
 * @property $kibor_rate
 * @property $spread_rate
 * @property $start_date
 * @property $end_date
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanKiborRate extends Model
{
    protected $table = "loan_kibor_rates";
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kibor_rate','spread_rate','start_date','end_date','status'];



}
