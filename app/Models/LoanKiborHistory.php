<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanKiborHistory
 *
 * @property $id
 * @property $loan_id
 * @property $start_date
 * @property $end_date
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanKiborHistory extends Model
{
    protected $table = "loan_kibor_history";
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['loan_id','start_date','end_date','status'];



}
