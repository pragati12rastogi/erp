
$(function() {
    
    $("#transaction_type").on('change',function(){
      var value = this.value;
      if(value == 'cheque'){
        $("#cheque_div").show();
        $("#online_div").hide();
      }else if(value == 'online'){
        $("#cheque_div").hide();
        $("#online_div").show();
      }else{
        $("#cheque_div").hide();
        $("#online_div").hide();
      }
    })

    
    jQuery('#payment_form').validate({ // initialize the plugin
        rules: {
            transaction_type:{
              required:true,
            },
            amount:{
              required:true,
            },
            transaction_id:{
              required:true,
            },
            cheque_no:{
              required:true,
            },
            bank_name:{
              required:true
            },
            ifsc:{
              required:true
            },
            account_name:{
              required:true
            }
        },
        errorPlacement: function(error,element)
        {
            if($(element).attr('type') == 'radio')
            {
                error.insertAfter(element.parent());
            }
            else if($(element).is('select'))
            {
                error.insertAfter(element.parent());
            }
            else{
                error.insertAfter(element);
            }
                
        }
    });
});