<?php

namespace App\Http\Controllers;

use App\Models\FinGeneralLedger;
use App\User;
use App\Models\FinChartOfAccount;
use Illuminate\Http\Request;

/**
 * Class FinGeneralLedgerController
 * @package App\Http\Controllers
 */
class FinGeneralLedgerController extends Controller {

    public $ar = [1 => 'BPv', 'BRV', 'CPV', 'CRV', 'JV'];
    public $voucher_status = [1 => "Prepared", "Checked", "Approved", "Recieved"];

    public function filemanager() {
        //echo app_path() . '/helpers/filemanager/config/config.php';
        //die;
        $config = include_once(app_path() . '\helpers\filemanager\config\config.php');
        $languages = include_once(app_path() . '\helpers\filemanager\lang\languages.php');
        $utils = include_once(app_path() . '\helpers\filemanager\include\utils.php');
        return view('filemanager.dialog', compact('config', 'utils', 'languages'));
    }

    public function upload() {
        
    }

    public function getDocuments($id) {
        $finGeneralLedger = FinGeneralLedger::where('fin_general_ledgers.id', $id)->with('ledgerdetails')->first();
        return view('fin-general-ledger.showvoucher', compact('finGeneralLedger'));
    }

    public function getVoucherStatus($status) {
        $statusAr = [1 => "Prepared", "Checked", "Approved", "Recieved"];
        $LoanStatus = "";
        $title = $statusAr[$status];

        $class = [1 => "warning", 2 => "notice", 3 => "primary", 4 => "success"];
        return '<span class="badge badge-pill badge-' . ($class[$status]) . '">' . $title . '</span>';
    }

    public static function addDigits($i, $zeroes) {
        // 1 - 5
        $ret = '';
        $num = mb_strlen($i);
        $Net = $zeroes - $num;
        for ($j = 0; $j < $Net; $j++) {
            $ret .= "0";
        }
        return $ret . $i;
    }

    public static function getReference($reference, $i, $zeroes) {
        $ar = [1 => 'BPV', 'BRV', 'CPV', 'CRV', 'JV'];
        $reference = $ar[$reference];
        return $reference . "" . self::addDigits($i, $zeroes);
    }

    public static function getVoucherHeading($reference) {
        $ar = [1 => 'BANK PAYMENT VOUCHER', 'BANK RECEIPT VOUCHER', 'CASH PAYMENT VOUCHER', 'CASH RECEIPT VOUCHER', 'JOURNAL VOUCHER'];
        $reference = $ar[$reference];
        $value = "9843";
        //echo self::convertNumberToWord($value);

        return $reference;
    }

    static function getChartOfAccountTitle($id) {
        $COA_Data = FinChartOfAccount::where('id', $id)->select('code', 'title')->first();
        return $COA_Data->code . " - " . $COA_Data->title;
    }

    static function convertNumberToWord($num = false) {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && (int) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process($id) {

        $finGeneralLedger = FinGeneralLedger::where('fin_general_ledgers.id', $id)->with('ledgerdetails')->first();
        $GJH_Result = \App\Models\FinGeneralLedgerHistory::where('finGeneralJournalId', $id)->with('user')->get();
  
        return view('fin-general-ledger.process', compact('finGeneralLedger', 'GJH_Result'));
    }

    public function index() {
        $finGeneralLedgers = FinGeneralLedger::where(['voucher_status'=>">=3"])->get();

        return view('fin-general-ledger.index', compact('finGeneralLedgers'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $finGeneralLedger = new FinGeneralLedger();
        $chartOfAccounts = FinChartOfAccount::where("level", "L5")->orderBy("code")->get();
        $TxnDate = date("M d Y");
        $Reference = "BPV001";

        $data = FinGeneralLedger::where('cheque_number', '!=', 'NULL')->orderBy("id", "desc")->first();
//        dd($data);
        if ($data) {
            $chqnum = (int) $data->cheque_number;
            $chqnum += 1;
        } else {
            $chqnum = "1";
        }

//        $chqnum = "1";

        return view('fin-general-ledger.create', compact('finGeneralLedger', 'chartOfAccounts', 'Reference', 'TxnDate', 'chqnum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(FinGeneralLedger::$rules);
//
//        echo "<pre>";
//        print_r($request->file);
//        echo "</pre>";
//        dd($request->all());
        //$reference = $request->get("reference");
        extract($request->all());

        $file = $request->file('filesupload');

//        //Display File Name
//        echo 'File Name: ' . $file->getClientOriginalName();
//        echo '<br>';
//
//        //Display File Extension
//        echo 'File Extension: ' . $file->getClientOriginalExtension();
//        echo '<br>';
//        
//        
//
//        //Display File Real Path
//        echo 'File Real Path: ' . $file->getRealPath();
//        echo '<br>';
//
//        //Display File Size
//        echo 'File Size: ' . $file->getSize();
//        echo '<br>';
//
//        //Display File Mime Type
//        echo 'File Mime Type: ' . $file->getMimeType();


        $LastSeries = FinGeneralLedger::where(['txn_type' => $reference])->orderBy("id", "desc")->first();
        if (!$LastSeries) {
            $LastSeries = 1;
        } else {
            $LastSeries = $LastSeries->txn_series + 1;
        }

        $TxnDate = date("Y-m-d", strtotime($TxnDate));
        $ChqNum = $chqnum;
        //dd($request->all());
        $userId = \Illuminate\Support\Facades\Auth::user()->id;

        //Maintain General Ledger
        $Model_GL = \App\Models\FinGeneralLedger::create([
                    'user_id' => $userId, 'details' => $purpose, 'debit' => 0, 'credit' => 0, 'txn_date' => $TxnDate, 'txn_type' => $reference, 'txn_series' => $LastSeries, 'cheque_number' => $ChqNum, 'office_id' => 1
        ]);
        $FinGL_Id = $Model_GL->id;
        
                //Move Uploaded File
        $destinationPath = base_path() . '/public/uploads/'.$FinGL_Id;
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        
        foreach($file as $key=>$file){
            $fileName = date("YmdHis")."_".$FinGL_Id."_".$key.".".$file->getClientOriginalExtension();
            //$file->move($destinationPath, $file->getClientOriginalName());
            $file->move($destinationPath, $fileName);
        }

        $TotalDebit = 0;
        $TotalCredit = 0;
        foreach ($chartofaccount as $key => $val) {
            if (isset($val)) {
                $TotalDebit += $debit[$key];
                $TotalCredit += $credit[$key];

                \App\Models\FinGeneralLedgerDetail::create(['fin_gen_id' => $FinGL_Id, 'detail' => $detail[$key], 'coa_id' => $val, 'debit' => $debit[$key], 'credit' => $credit[$key]]);
            }
        }
        FinGeneralLedger::find($FinGL_Id)->update(['debit' => $TotalDebit, 'credit' => $TotalCredit]);

        return redirect()->route('fin-general-ledgers.index')
                        ->with('flash_success', 'Entry Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $finGeneralLedger = FinGeneralLedger::where('fin_general_ledgers.id', $id)->with('ledgerdetails')->first();
        return view('fin-general-ledger.show', compact('finGeneralLedger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function submitvouchers(Request $request) {
        $userId = \Illuminate\Support\Facades\Auth::user()->id;
        //dd($request->all());
        $userComment = $request->get("userComment");
        $gj_id = $request->get("gj_id");
        $action = $request->get("action");

        $VoucherStatus = FinGeneralLedger::where('id', $gj_id)->first()->voucher_status;
        FinGeneralLedger::where('id', $gj_id)->update(['voucher_status' => $VoucherStatus + 1]);

        $insert = \App\Models\FinGeneralLedgerHistory::create(['finGeneralJournalId' => $gj_id, 'ProcessComment' => $userComment, 'ProcessTo' => 1, 'IsProcessed' => $action, 'ActionType' => $action, 'ProcessBy' => $userId]);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id) {

        $finGeneralLedger = new FinGeneralLedger();
        $finGeneralLedger = FinGeneralLedger::find($id);
        $chartOfAccounts = FinChartOfAccount::where("level", "L5")->orderBy("code")->get();
        $TxnDate = date("M d Y");
        $Reference = "BPV001";

        $data = FinGeneralLedger::where('cheque_number', '!=', 'NULL')->orderBy("id", "desc")->first();
//        dd($data);
        if ($data) {
            $chqnum = (int) $data->cheque_number;
            $chqnum += 1;
        } else {
            $chqnum = "1";
        }

//        $chqnum = "1";

        return view('fin-general-ledger.create', compact('finGeneralLedger', 'chartOfAccounts', 'Reference', 'TxnDate', 'chqnum'));

//        
//        $finGeneralLedger = FinGeneralLedger::find($id);
//
//        return view('fin-general-ledger.edit', compact('finGeneralLedger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FinGeneralLedger $finGeneralLedger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinGeneralLedger $finGeneralLedger) {
        request()->validate(FinGeneralLedger::$rules);

        $finGeneralLedger->update($request->all());

        return redirect()->route('fin-general-ledgers.index')
                        ->with('flash_success', 'FinGeneralLedger updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $finGeneralLedger = FinGeneralLedger::find($id)->delete();

        return redirect()->route('fin-general-ledgers.index')
                        ->with('flash_success', 'FinGeneralLedger deleted successfully');
    }

}
