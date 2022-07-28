@extends('layouts.master')
@section('page_title', 'Financing Schedule')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Financing Schedule (A/c#: {{ $ttr_id }})</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#due" class="nav-link active" data-toggle="tab">Due Schedule</a></li>
            <li class="nav-item"><a href="#paid" class="nav-link" data-toggle="tab">Paid Installment</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade" id="paid">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Due ID</th>
                            <th>Principal</th>
                            <th>Profit</th>
                            <th>Total</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paidinfo as $mc)
                        <tr>
                            <td>{{ $mc->due_id }}</td>
                            <td align="right">{{ number_format($mc->amount_pr) }}</td>
                            <td align="right">{{ number_format($mc->amount_mu) }}</td>
                            <td align="right">{{  number_format(($mc->amount_total)) }}</td>
                            <td>{{ date("d M Y",strtotime($mc->recovered_date)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>








            <div class="tab-pane fade show active" id="due">                                  
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Inst.No</th>
                            
                            <th>Due Date</th>
                            <th>Principal</th>
                            <th>Profit</th>
                            <th>Installment Amount</th>
                            <th>Outstanding Principle</th>
                            <th>Desc.</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach($dueinfo as $mc)
                        
                        @if($mc->due_status==0)
                        <?php $mc->amount_pr = array_key_exists($mc->id, $duepaidinfo[2]) ? $mc->amount_pr+$duepaidinfo[2][$mc->id]->amount_pr : $mc->amount_pr ?>
                        <?php $mc->outstanding = array_key_exists($mc->id, $duepaidinfo[2]) ? $mc->outstanding-$duepaidinfo[2][$mc->id]->amount_pr : $mc->outstanding ?>
                        <tr>
                            <td>
                                <?php echo $i++ ?>
                                
                            </td>
                            <td>{{ date("d M Y",strtotime($mc->due_date)) }}</td>
                            <td>{{ number_format($mc->amount_pr,0) }}</td>
                            <td>{{ number_format($mc->amount_mu,0) }}</td>
                            <td>{{ number_format($mc->amount_total,0) }}</td>
                            <td>{{ number_format($mc->outstanding) }}</td>
                            <td><?php echo array_key_exists($mc->id, $duepaidinfo[2]) ? '<span class="badge badge-pill badge-success">PARTIAL</span>' : "" ?></td>
                            <td><?php echo $mc->payment_status ? '<span class="badge badge-pill badge-success">&nbsp;&nbsp;&nbsp;&nbsp;PAID&nbsp;&nbsp;&nbsp;&nbsp;</span>' : '<span class="badge badge-pill badge-danger">UN-PAID</span>' ?></td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>








        </div>
    </div>    























    <div class="card-body">
        <div class="tab-content">





        </div>
    </div>
</div>

{{--TimeTable Ends--}}

@endsection
