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
<!--                    <form class="ajax-store" method="post" action="{{ route('storestep') }}">-->
                    <form method="post" action="{{ route('storestep') }}">
                        @csrf
                        <input type="hidden" name="loanId" value="{{$loanId}}" />
                        <div class="form-group row">
                            <br>
                            <div class="row col-md-12">
                                    <label class="col-md-3 col-form-label font-weight-semibold">Partial Percent:</label>
                                    <input name="percent" type="number" class="col-md-9 form-control  col-form-label font-weight-semibold" placeholder="Partial Percent">
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
