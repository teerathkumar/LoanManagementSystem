document.addEventListener('DOMContentLoaded', function() {
    $('.date-pick').datepicker();
});
var row=0;
$('.add-row').click(function(){
    if(row<10){
        row++;
        console.log(row);
        $(".gl_rows_"+row).show();
    }
});
$('.rem-row').click(function(){
    if(row>0){        
        $(".gl_rows_"+row).hide();
        row--;
        console.log(row);
    }
});
