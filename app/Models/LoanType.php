<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanType
 *
 * @property $id
 * @property $name
 * @property $parent_id
 * @property $createdOn
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanType extends Model
{
    
    static $rules = [
		'createdOn' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','parent_id','createdOn'];



}
