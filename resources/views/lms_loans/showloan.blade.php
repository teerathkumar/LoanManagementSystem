@extends('layouts.master')
@section('page_title', 'Financing Information')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Financing Information (A/c#: {{ $data->id }})</h6>
        {!! Qs::getPanelOptions() !!}
    </div>
    <div class="card-body">
        <style>
            
.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}


.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
        </style>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">{{$data->loan_borrower->fname." ". $data->loan_borrower->mname." ". $data->loan_borrower->lname}}</span><span class="text-black-50">test@gmail.com</span><span> </span></div>
        </div>
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Borrower Profile</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Account Number:</label>
                        <p ><strong>{{$data->id}}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">CNIC:</label>
                        <p ><strong>{{$data->loan_borrower->cnic}}</strong></p>
                    </div>
                    <div class="col-md-12"><label class="labels">Name</label><p ><strong>{{$data->loan_borrower->fname." ". $data->loan_borrower->mname." ". $data->loan_borrower->lname}}</strong></p></div>
                    
                    <div class="col-md-12"><label class="labels">Guardian Name:</label><p ><strong>{{$data->loan_borrower->guardian_fname." ". $data->loan_borrower->guardian_name." ". $data->loan_borrower->guardian_lname}}</strong></p></div>
                    
                    <div class="col-md-6"><label class="labels">Surname</label><p ><strong>{{$data->loan_borrower->caste}}</strong></p></div>
                    <div class="col-md-6"><label class="labels">Mobile:</label><p ><strong>{{$data->loan_borrower->mobile}}</strong></p></div>
                    
                    <div class="col-md-6"><label class="labels">Gender:</label><p ><strong>{{$data->loan_borrower->gender}}</strong></p></div>
                    <div class="col-md-6"><label class="labels">Date Of Birth:</label><p ><strong>{{$data->loan_borrower->dob}}</strong></p></div>
                    
                    <div class="col-md-12"><label class="labels">Address:</label><p ><strong>{{$data->loan_borrower->address}}</strong></p></div>                    

                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Financial Information</h4>
                </div>                
                <div class="row mt-3">
                    
                    <div class="col-md-6"><label class="labels">Product:</label><p ><strong>{{$data->loan_type_id}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Kibor:</label><p ><strong>{{$data->kibor_rate_id}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Tenure:</label><p ><strong>{{$data->loan_period}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Frequency:</label><p ><strong>{{$data->frequency}}</strong></p></div>                                    
                    <div class="col-md-12"><label class="labels">Disbursement Date:</label><p ><strong>{{$data->disb_date}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Total Principle:</label><p ><strong>{{ number_format($data->total_amount_pr,0) }}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Total Profit:</label><p ><strong>{{ number_format($data->total_amount_mu,0) }}</strong></p></div>                                    
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Due & Payment Information</h4>
                </div> 
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Total Due Principle:</label><p ><strong>{{ number_format($due->due_pr,0)}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Total Due Profit:</label><p ><strong>{{number_format($due->due_mu,0)}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Total Paid Principle:</label><p ><strong>{{number_format($paid->paid_pr,0)}}</strong></p></div>                                    
                    <div class="col-md-6"><label class="labels">Total Paid Profit:</label><p ><strong>{{number_format($paid->paid_mu,0)}}</strong></p></div>                                    
                </div>
<!--
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>-->
            </div>
        </div>
    </div>
</div>
</div>
</div>        

@endsection
