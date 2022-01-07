$(function() {
            
    jQuery('#user_form').validate({ // initialize the plugin
        rules: {

            role: {
                required: true,
            },
            name:{
                required:true,
            },
            email:{
                required:true,
            },
            mobile:{
                required:true,
            },
            firm_name:{
                required:true
            },
            gst_no:{
                required:true
            },
            state_id:{
                required:true
            },
            district:{
                required:true
            },
            address:{
                required:false
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

    $("#user_table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
            extend:'excelHtml5',
            exportOptions: {
                columns: [ 0, 1, 2,3,4 ] 
            }
            }
        ]
    });
});