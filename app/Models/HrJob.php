<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HrJob
 *
 * @property $id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class HrJob extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [];



}
