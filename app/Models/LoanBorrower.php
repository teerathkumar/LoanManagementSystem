<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanBorrower
 *
 * @property $id
 * @property $fname
 * @property $mname
 * @property $lname
 * @property $gender
 * @property $dob
 * @property $caste
 * @property $cnic
 * @property $mobile
 * @property $address
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanBorrower extends Model
{
    
    static $rules = [
		'fname' => 'required',
		'dob' => 'required',
		'cnic' => 'required',
		'mobile' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fname','mname','lname','gender','dob','caste','cnic','mobile','address'];



}
