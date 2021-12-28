$("#prod_quantity, #prod_price, #total_price").on('keyup',function(){
    calculate_product();
})
function calculate_product(){debugger
    var prod_quantity = $("#prod_quantity").val();
    var prod_price = $("#prod_price").val();

    var calculate_gst = (prod_price * gst_percent)/100;
    prod_price = parseFloat(prod_price) + parseFloat(calculate_gst);

    var calc_total = parseInt(prod_quantity)*parseFloat(prod_price);
    
    $("#total_price").val(calc_total);

    $('#total_price_span').empty();
    $('#total_price_span').text("Note: gst of "+gst_percent+"% is added.")
}

$("#per_freight_price").change(function(){
    calculate_final_price();
    user_percent_calculation();
    // var = '<div id="myModal" class="modal fade" role="dialog">'+
    //         '<div class="modal-dialog">'+
    //             '<div class="modal-content">'+
    //                 '<div class="modal-header">'+
    //                     '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
    //                     '<h4 class="modal-title">Modal Header</h4>'+
    //                 '</div>'+
    //                 '<div class="modal-body">'+
    //                     '<table class="table">'+
    //                         '<tr>'+
    //                             '<th></th>'
    //                         '</tr>'+
    //                         '<tr></tr>'+
    //                     '</table>'+
    //                 '</div>'+
    //                 '<div class="modal-footer">'+
    //                     '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
    //                 '</div>'+
    //             '</div>'+

    //         '</div>'+
    //     '</div>';
})
function calculate_final_price (){
    var per_freight_price = $("#per_freight_price").val();
    var prod_quantity = $("#prod_quantity").val();
    var total_price = $("#total_price").val();
    
    var calc_total = (parseInt(per_freight_price)*parseInt(prod_quantity))+parseInt(total_price);
    
    var final_price = $("#final_price").val(calc_total);

}

$("#user_percent").change(function(){
    user_percent_calculation()
})

function user_percent_calculation(){
    var prod_price = $("#prod_price").val();
    var calculate_gst = (prod_price * gst_percent)/100;
    prod_price = parseFloat(prod_price) + parseFloat(calculate_gst);

    var per_freight_price = $("#per_freight_price").val();
    var user_percent = $("#user_percent").val();

    prod_price = parseFloat(prod_price) + parseFloat(per_freight_price);
    var get_percent = parseFloat(prod_price)*(user_percent/100);

    var user_price = (parseFloat(prod_price)+parseFloat(get_percent)).toFixed(2);
    $("#price_for_user").val(user_price);
}