<?php

namespace App\Models;

use Eloquent;

class LoanBorrower extends Eloquent {

    protected $table = 'loan_borrowers';
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'gender',
        'dob',
        'caste',
        'cnic',
        'mobile',
        'address'
    ];

    //
}
