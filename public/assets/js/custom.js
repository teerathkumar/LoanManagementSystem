document.addEventListener('DOMContentLoaded', function() {
    $('.date-pick').datepicker();
});
var row=0;
$('.add-row').click(function(){
    if(row<50){
        row++;
        console.log(row);
        $(".gl_rows_"+row).show();
    }
});
$('.rem-row').click(function(){
    if(row>0){        
        $(".gl_rows_"+row).hide();
        $(".gl_rows_"+row).find("input").val("");
        row--;
        console.log(row);
    }
});
$(".debit").keyup(function(){
    var granddebit = 0;
    $(".debit").each(function(){
        console.log($(this).val())
        granddebit+=parseInt($(this).val());
    });
    $(".granddebit").html(granddebit);
});
$(".credit").keyup(function(){
    var grandcredit = 0;
    $(".credit").each(function(){
        console.log($(this).val())
        grandcredit+=parseInt($(this).val());
    });
    $(".grandcredit").html(grandcredit);    
});
