<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HrEmployee
 *
 * @property $id
 * @property $fname
 * @property $lname
 * @property $fathers_name
 * @property $dob
 * @property $address
 * @property $bank_account_number
 * @property $mobile
 * @property $cnic
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class HrEmployee extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fname','lname','fathers_name','dob','address','bank_account_number','mobile','cnic','created_date'];



}
