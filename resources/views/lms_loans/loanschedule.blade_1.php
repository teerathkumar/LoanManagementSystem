@extends('layouts.master')
@section('page_title', 'Loan Schedule')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Loan Schedule (A/c#: {{ $ttr_id }})</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#showall" class="nav-link active" data-toggle="tab">Loan Schedule</a></li>
            <li class="nav-item"><a href="#add-payment" class="nav-link" data-toggle="tab">Pay Installment</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade" id="add-payment">
                <div class="col-md-8">
                    <form class="ajax-store" method="post" ">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Enter Amount:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input name="amount" required type="text" class="form-control" placeholder="Payment Amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">Bank Slip: <span class="text-danger">*</span></label>
                            <div class="col-lg-9">                                
                                <select required data-placeholder="Select Bank Slip" class="form-control select" name="bankslip_id" id="bankslip_id">
                                    <option value="">Select Bankslip</option>
                                    @foreach($bankinfo as $bi)
                                    <option value="{{$bi->id}}">{{$bi->bank_name}} ({{ $bi->bank_account }})</option>
                                    @endforeach;
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button id="ajax-btn" type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>


            
            
            
            
            
            
            <div class="tab-pane fade show active" id="showall">                                  
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Inst.No</th>
                            <th>Principal</th>
                            <th>Profit</th>
                            <th>Total</th>
                            <th>Due Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dueinfo as $mc)
                        <tr>
                            <td>{{ $mc->installment_no }}</td>
                            <td>{{ number_format($mc->amount_pr,2) }}</td>
                            <td>{{ number_format($mc->amount_mu,2) }}</td>
                            <td>{{ number_format($mc->amount_total,2) }}</td>
                            <td>{{ date("d M Y",strtotime($mc->due_date)) }}</td>
                            <td>{{ $mc->payment_status==1 ? "Paid" : "Unpaid" }}</td>
                        </tr>
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
