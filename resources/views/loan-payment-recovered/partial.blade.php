@extends('layouts.master')
@section('page_title', 'Partial Payment')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Partial Payment</h6>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#add-tt" class="nav-link active" data-toggle="tab">Partial Payment</a></li>
        </ul>


        <div class="tab-content">

            <div class="tab-pane fade show active" id="add-tt">


                <div class="col-md-8">

                    <form method="post" action="{{ route('loan-payment-recovereds.store_partial') }}">
                        @csrf
                        <input type="hidden" name="loanId" value="{{$loanId}}" />
                        <div class="form-group row">
                            <br>
                            <div class="row col-md-12">
                                <label class="col-md-3 col-form-label font-weight-semibold">Partial Percent:</label>
                                <input name="percent" type="number" min="1" max="100" class="col-md-9 form-control  col-form-label font-weight-semibold" placeholder="Partial Percent">
                            </div>
                            <br>
                            <div class="row col-md-12">
                                <label class="col-md-3 col-form-label font-weight-semibold">Date:</label>
                                <input name="date" type="date" class="col-md-9 form-control  col-form-label font-weight-semibold" placeholder="Date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-success float-right" >Save and Pay</button>
                        </div>
                    </form>
                </div>

                @if(isset($percent))
                
                <span>
                    Partial Percent: <strong>{{ $percent }}%</strong> <br>
                    Total Outstanding: <strong>{{ number_format($outstanding,0)  }}</strong> <br>
                    Partial Amount: <strong>{{ number_format($partial,0) }} </strong><br>
                    
                    Upper Partial: <strong>{{ number_format($upper_partial,0) }} </strong><br>
                    Upper Percent: <strong>{{ $upper_percent }}% </strong><br>
                    Extra Partial: <strong>{{ number_format($extra_partial,0) }} </strong><br>
                </span>
                
                @endif

            </div>


        </div>
    </div>
</div>

{{--TimeTable Ends--}}

@endsection
