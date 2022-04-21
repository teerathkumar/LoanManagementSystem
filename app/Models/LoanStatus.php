<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanStatus
 *
 * @property $id
 * @property $title
 * @property $status
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanStatus extends Model
{
    protected $table = 'loan_status';
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','status','created_date'];



}
