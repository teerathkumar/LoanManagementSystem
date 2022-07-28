@extends('layouts.master')
@section('page_title', 'Fin General Ledger')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">Create Fin General Ledger</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('fin-general-ledgers.store') }}" id="myform" role="form" enctype="multipart/form-data">
            @csrf

            @include('fin-general-ledger.form')

        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        var row = 0;
        $('.add-row').click(function () {
            if (row < 50) {
                row++;
                console.log(row);
                $(".gl_rows_" + row).show();
                $("#chartofaccount_" + row).prop("required", "true");
                $("#debit_" + row).prop("required", "true");
                $("#credit_" + row).prop("required", "true");
            }
        });
        $('.rem-row').click(function () {
            if (row > 0) {
                $(".gl_rows_" + row).hide();
                $("#chartofaccount_" + row).removeAttr("required");
                $("#debit_" + row).val("");
                $("#debit_" + row).removeAttr("required");
                $("#credit_" + row).val("");
                $("#credit_" + row).removeAttr("required");
                row--;
                console.log(row);
            }
        });
        $(".debit").keyup(function () {
            var granddebit = 0;
            $(".debit").each(function () {
                console.log($(this).val())
                granddebit += parseInt($(this).val());
            });
            $(".granddebit").html(granddebit);
        });
        $(".credit").keyup(function () {
            var grandcredit = 0;
            $(".credit").each(function () {
                console.log($(this).val())
                grandcredit += parseInt($(this).val());
            });
            $(".grandcredit").html(grandcredit);
        });


        $("#reference").change(function () {
            console.log(parseInt($("#reference").val()));
            if (parseInt($("#reference").val()) == 5) {
                //$("#reference").val();
                console.log("thats it: " + parseInt($("#reference").val()));
                //$("#chqnum").attr("disabled", "disabled");
                $(".chequenum").hide();
            } else {
                $(".chequenum").show();
            }
        });
        $(".submitbtn").click(function () {
            var totaldebit = $(".granddebit").html();
            var totalcredit = $(".grandcredit").html();

            if (parseInt(totaldebit) == 0 || parseInt(totalcredit) == 0 || parseInt(totaldebit) != parseInt(totalcredit)) {
                alert("Please make it sure that Grand debit and credit are equal");
            
            } else {
                $(".submitbtn").prop("type", "submit").trigger("click");
                $("#myform").submit();
            }
        });

    });
</script>
@endsection
