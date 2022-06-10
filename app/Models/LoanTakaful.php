<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanTakaful
 *
 * @property $id
 * @property $start_date
 * @property $end_date
 * @property $policy_number
 * @property $renewal_date
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanTakaful extends Model
{
    protected $table="loan_takaful";
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['loan_id','start_date','type','covered_amount', 'end_date','policy_number','renewal_date'];



}
