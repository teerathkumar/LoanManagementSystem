<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GeneralUser
 *
 * @property $id
 * @property $emp_id
 * @property $user_type_id
 * @property $user_name
 * @property $password
 * @property $token
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class GeneralUser extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['emp_id','user_type_id','user_name','token','created_date'];



}
