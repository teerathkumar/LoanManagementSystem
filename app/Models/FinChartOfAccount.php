<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinChartOfAccount
 *
 * @property $id
 * @property $title
 * @property $code
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FinChartOfAccount extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','code','level','created_at'];



}
