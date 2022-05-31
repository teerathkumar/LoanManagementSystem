@extends('layouts.master')
@section('page_title', 'Manage Financing')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Generate Financing Schedule</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            @if(Qs::userIsTeamSA())
            <li class="nav-item"><a href="#add-tt" class="nav-link active" data-toggle="tab">Create Schedule</a></li>
            @endif
        </ul>


        <div class="tab-content">

            <div class="tab-pane fade show active" id="add-tt">

                <div class="col-md-8">
<!--                    <form class="ajax-store" method="post" action="{{ route('storestep') }}">-->
                    <form method="post" action="{{ route('storestep') }}">
                        @csrf
                        <input type="hidden" name="loanId" value="{{$loaninfo->id}}" />
                        <div class="form-group row">
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Takaful Amount: </label>
                                    <input name="takaful_amount" type="checkbox" class="col-md-9 form-control  col-form-label font-weight-semibold" placeholder="Takaful Amount">
                            </div>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">FED:</label>
                                    <input name="fed_amount" type="checkbox" class="col-md-9 form-control  col-form-label font-weight-semibold" placeholder="Takaful Amount">
                            </div>
                            
                            <!-- 
                            processing fees box, legal charges, valuation charges, income estimation charges, stamp paper charges.
                            -->
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Processing Fees:</label>
                                    <input name="processing_amount" type="text" class="col-md-9 form-control  col-form-label font-weight-semibold" >
                            </div>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Legal Charges:</label>
                                    <input name="legal_amount" type="text" class="col-md-9 form-control  col-form-label font-weight-semibold" >
                            </div>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Valuation Charges:</label>
                                    <input name="valuation_amount" type="text" class="col-md-9 form-control  col-form-label font-weight-semibold" >
                            </div>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Income Estimation Charges:</label>
                                    <input name="inc_est_amount" type="text" class="col-md-9 form-control  col-form-label font-weight-semibold" >
                            </div>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Stamp Paper Charges:</label>
                                    <input name="stamp_paper_amount" type="text" class="col-md-9 form-control  col-form-label font-weight-semibold" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-success float-right" >Save and Generate</button>
                        </div>
                    </form>
                </div>


            </div>


        </div>
    </div>
</div>

{{--TimeTable Ends--}}

@endsection
