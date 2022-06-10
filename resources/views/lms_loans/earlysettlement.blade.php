@extends('layouts.master')
@section('page_title', 'Early Settlement')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Early Settlement</span>
    </div>
    <div class="card-body">
                
        if($OutstandingData){
            $due_date = $OutstandingData->due_date;
            $installment_no = $OutstandingData->installment_no;
            //$outstanding = $OutstandingData->outstanding;
            if($installment_no<=12){
                $charges=4.5;
            } else if($installment_no<=24){
                $charges=3;
            } else if($installment_no<=36){
                $charges=1.5;
            } else {
                $charges=0;
            }
            $now = time(); // or your date as well
            $your_date = strtotime($due_date);
            $datediff = $now - $your_date;
            if($datediff<0){
                $datediff=$datediff*-1;
            }
            

            $days_diff= round($datediff / (60 * 60 * 24));            
            $days_diff=14;
            echo "Settlement Outstanding: ".$outstanding."<br>";
            $Profit = $outstanding*(($LoansInfo->kibor_rate+$LoansInfo->spread_rate)/100)/360*$days_diff;
            echo "Profit for ".$days_diff." days: ".($Profit)."<br>";
            $SettlementCharges = $outstanding*($charges/100);
            echo "Settlement Charges: ".($SettlementCharges)."<br>";
            $FED = $SettlementCharges*(13/100);
            echo "FED on Settlement Charges: ".($FED)."<br>";
            $TotalSettlement = $outstanding+$Profit+$SettlementCharges+$FED;
            echo "Total Settlement Amount: ".($TotalSettlement)."<br>";
        }

    </div>
</div>

@endsection
