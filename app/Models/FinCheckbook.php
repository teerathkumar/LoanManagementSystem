<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinCheckbook
 *
 * @property $id
 * @property $checkbook_title
 * @property $bank_id
 * @property $checknum_start
 * @property $checknum_end
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FinCheckbook extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['checkbook_title','bank_id','checknum_start','checknum_end'];



}
