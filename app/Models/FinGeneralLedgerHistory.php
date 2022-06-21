<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinGeneralLedgerHistory extends Model {

    use HasFactory;

    protected $table = "fin_general_ledger_history";
    protected $fillable = ['finGeneralJournalId', 'ProcessComment', 'ProcessTo', 'IsProcessed', 'ActionType',
        'ProcessBy',
        'created_at',
        'updated_at'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'ProcessBy');
    }
}
