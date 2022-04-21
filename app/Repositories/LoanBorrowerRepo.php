<?php


namespace App\Repositories;

use App\Models\LoanBorrower;


class LoanBorrowerRepo
{

    public function create($data)
    {
        return LoanBorrower::create($data);
    }

    public function getAll($order = 'id')
    {
        return LoanBorrower::orderBy($order)->get();
    }

    public function getLoanBorrower($data)
    {
        return LoanBorrower::where($data)->get();
    }

    public function update($id, $data)
    {
        return LoanBorrower::find($id)->update($data);
    }

    public function find($id)
    {
        return LoanBorrower::find($id);
    }


}