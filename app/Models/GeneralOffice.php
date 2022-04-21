<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GeneralOffice
 *
 * @property $id
 * @property $name
 * @property $code
 * @property $parent_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class GeneralOffice extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','code','parent_id'];



}
