<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AmlBlacklist
 *
 * @property $id
 * @property $name
 * @property $guardian
 * @property $cnic
 * @property $district
 * @property $province
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AmlBlacklist extends Model
{
    protected $table = "aml_blacklist";
    
    static $rules = [
		'cnic' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','guardian','cnic','district','province','status'];



}
