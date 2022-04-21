<?php


namespace App\Repositories;

use App\Models\LoanHistory;
use App\Models\LoanBorrower;

class LoanHistoryRepo
{

    public function create($data)
    {
        return LoanHistory::create($data);
    }

    public function getAll($order = 'id')
    {
        
        return LoanHistory::orderBy($order)->with('loan_borrower')->get();
    }

    public function getDorm($data)
    {
        return LoanHistory::where($data)->get();
    }

    public function update($id, $data)
    {
        return LoanHistory::find($id)->update($data);
    }

    public function find($id)
    {
        return LoanHistory::find($id);
    }


}