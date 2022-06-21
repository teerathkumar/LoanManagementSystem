@extends('layouts.master')
@section('page_title', 'Fin General Ledger')

@section('content')


<div class="card">
    <div class="card-header">
        <div class="float-left">
            <span class="card-title">Show Fin General Ledger</span>
        </div>
        <div class="float-right">
            <a class="btn btn-primary" href="{{ route('fin-general-ledgers.index') }}"> Back</a>
            <a class="btn btn-primary" onclick="printScrn()"> Print</a>
        </div>
    </div>

    <div class="card-body" id="voucher-body">
        
<!--        <link rel="stylesheet" href="{{ asset('global_assets/mystyle/bootstrap.min.css') }}" >-->
        <script src="{{ asset('global_assets/css/style.css') }}"></script>
        <script src="{{ asset('global_assets/mystyle/bootstrap.min.js') }}" ></script>
        <script type="text/javascript" language="Javascript" src="{{ asset('global_assets/mystyle/jquery.min.js') }}" ></script>


        <style>
            .noradius{
                border-radius: 0px !important;
            }
            .down-fixed {
                padding:8px;
                position:fixed;
                bottom:0;
                width:100%;
            }
            .alert-position{
                position: fixed;
                right: 50px;
                top: 30px;
                width: 30%;
            }
            .mediastyle {
                background-color:#FFFFFF;
                border: 0 solid #ccc;
                box-shadow: 0 0 2px 1px #ccc;
                margin-bottom: -5px;
                padding: 5px;
            }
            .main-contain {
                margin: 5px auto;
                width: 95%;
                background-color: rgba(200, 200, 200, 0.1);
                padding: 10px;
                border: 2px solid #ccc;
                border-radius: 5px;
                height: 640px;
                overflow-y: scroll;
            }

            #loadingDiv{
                position:fixed;
                top:0px;
                right:0px;
                width:100%;
                height:100%;
                background-color:#EEEEEE;
                background-image:url('/global_assets/ajax-loader.gif');
                background-repeat:no-repeat;
                background-position:center;
                z-index:10000000;
                display:none;
                opacity: 0.4;
                filter: alpha(opacity=40); /* For IE8 and earlier */
            }
            .carousel-control {
                width:4% !important;
            }
            .carousel-inner {
                position: relative;
                width: 100%;
                overflow: hidden;
                border: 2px solid #FFFFFF;
                box-shadow: 0px 0px 9px 3px #CCCCCC;
            }
            .carousel-inner iframe {
                margin: 1% auto !important;
                width: 91% !important;
                height: 110% !important;
            }
            .media-heading {
                margin-top: 10px !important;
            }
        </style>

        <div id="loadingDiv"></div>
            <fieldset>
                <legend>Basic Reviews:</legend>
                <div class="col-md-12">
                    <div class="alert alert-default col-md-12" style="border:1px solid #CCCCCC;">
                        <div data-toggle="collapse" data-target="#demo_inc" class="panel-heading collapsed" aria-expanded="false">Review Attached Documents</div>
                        <div id="demo_inc" class="collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <p>
                                    <?php echo app('App\Http\Controllers\VoucherController')->GetVouchersDocuments($finGeneralLedger->id) ?>
                                </p>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-default col-md-12" style="border:1px solid #CCCCCC;">
                        <div data-toggle="collapse" data-target="#demo_voucher" class="panel-heading collapsed" aria-expanded="false">Review Attached Voucher</div>
                        <div id="demo_voucher" class="collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <p><?php echo app('App\Http\Controllers\VoucherController')->getVoucher($finGeneralLedger->id) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset><br>
            <div id="Div_HistoryContainer">

                @if ($GJH_Result)
                <fieldset>
                    <legend>Current Voucher Status:</legend>
                    <div class="col-lg-12 alert alert-info" align="center"><?php echo app('App\Http\Controllers\FinGeneralLedgerController')->voucher_status[$finGeneralLedger->voucher_status] ?></div>
                </fieldset>
                <fieldset>
                    <legend>Comments:</legend>

                    @foreach ( $GJH_Result as $row)

                        <div class="media col-md-12 mediastyle">
                            <div class="media-left">
                                <a href="#">
                                    <img alt="64x64" class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;" src="{{ asset('global_assets/mystyle/comment2.png') }}" data-holder-rendered="true">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <strong>{{ $row->user->name }}</strong> 
                                    <span style="font-style:italic;">({{ $row->user->user_type }})</span>
                                    @if($row->IsProcessed)
                                    <span style='color:#449d44;'>{{ $row->ActionType ? "Processed" : "" }}</span>
                                    
                                    @else
                                    <span style='color:#C9302C;'>Reversed</span>
                                    @endif
                                    On <strong>{{ date("F j, Y g:i a", strtotime($row->created_at)) }}</strong> : </h5>
                                    <strong style="color:#449d44;">{{ $row->ProcessComment }}</strong>
                            </div>
                        </div>
                    @endforeach
                </fieldset>
                @endif
            </div><br>

            @php
            $ReversedButtonDisabled = "";
            @endphp
            <fieldset>
                <div class="col-md-12">
                    <div class="alert alert-success alert-position" style="display:none;">Updated Successfully</div>
                </div>

                <div class="col-md-12">
                    @csrf
                    <input type="hidden" id="id" value="{{ $finGeneralLedger->id }}" />

                    <textarea class="form-control noradius" name="comment" id="comment" placeholder="Comments here..."></textarea>
                </div>
                <div class="col-md-12 btn-group btn-group-justified" role="group" >
                    <div class="btn-group" role="group">
                        <input action="0" class="btn btn-lg btn-danger noradius {{ $ReversedButtonDisabled }}" id="cancel" value="Reverse" type="button">
                    </div>                
                    <div class="btn-group" role="group">
                        <input action="1" class="btn btn-lg btn-success noradius" id="process" value="Process" type="button">
                    </div>
                </div>
            </fieldset>
        </div>

        @php
        $CommentsByLoop = "";
        $CommentsLoop = "";
@endphp
    
</div>
<script  type="text/javascript" language="Javascript">

                jQuery("#loadingDiv").show();
                $(document).ready(function () {
                    jQuery("#loadingDiv").hide();
                    jQuery(".btn").click(function () {
                        //jQuery(".btn")
                        var do_action = jQuery(this).attr("action");
                        var comment_gj_id = jQuery("#id").val();
                        var comment_user = jQuery("#user").val();
                        var comment_text = jQuery("#comment").val();
                        if (comment_text != "") {
                            jQuery("#loadingDiv").show();
                            jQuery("#comment").removeClass("alert-danger");
                            jQuery.post("../submitvouchers", {
                                action: do_action,
                                _token: jQuery("input[name='_token']").val(),
                                userComment: comment_text,
                                user_id: comment_user,
                                gj_id: comment_gj_id
                            },
                                    function (data) {

                                        if (data) {
                                            jQuery("#Div_HistoryContainer").html(data);
                                            jQuery("#comment").val("");
                                            jQuery(".alert").fadeIn(300);
                                            setTimeout(function () {
                                                jQuery("#loadingDiv").hide();
                                                jQuery(".alert").fadeOut(700);
                                                //window.location.replace("../vouchers/");
                                                window.location.href = "../vouchers";
                                            }, 1500);
                                        }
                                    });
                        } else {
                            alert("Please Enter Comment First");
                            jQuery("#comment").focus();
                            jQuery("#comment").addClass("alert-danger");
                        }
                    });
                });
</script>
@endsection
