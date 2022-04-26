<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinGeneralLedger
 *
 * @property $id
 * @property $slip_id
 * @property $user_id
 * @property $debit
 * @property $credit
 * @property $txn_date
 * @property $txn_type
 * @property $office_id
 * @property $created_date
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class FinGeneralLedger extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['slip_id','loan_id','user_id', 'details', 'debit','credit','txn_date','txn_type','cheque_number', 'txn_series','office_id'];

    
    public function userinfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function officeinfo()
    {
        return $this->belongsTo(GeneralOffice::class, 'office_id');
    }
    


}
