@extends('layouts.master')
@section('title', 'Expenses Creation')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#expense_table").DataTable({
                dom: 'Blfrtip',
                buttons: [
                {
                    extend:'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2,3 ] 
                    }
                },
                {
                    extend:'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2,3  ] //Your Column value those you want
                    }
                }
                
                ]
            });
            $.validator.addMethod('decimal', function(value, element) {
            return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
            }, "Please enter a correct number, format 0.00");

            jQuery('#expense_form').validate({ // initialize the plugin
                rules: {
                    name:{
                        required:true,
                    },
                    amount:{
                        required:true,
                        decimal:true,
                        min:0
                    },
                    datetime:{
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

            jQuery('#expense_form_upd').validate({ // initialize the plugin
                rules: {
                    name:{
                        required:true,
                    },
                    amount:{
                        required:true,
                        decimal:true,
                        min:0
                    },
                    datetime:{
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
        
        function edit_expense_modal(edit_id){
            var submit_edit_url = '{{url("expenses")}}/'+edit_id;
            var get_edit_url = submit_edit_url +'/edit';
            
            $.ajax({
                type:"GET",
                dataType:"JSON",
                url:get_edit_url,
                success:function(result){

                    if(result != ''){
                        var inputs = result.expense;
                        $('#expense_form_upd').attr('action',submit_edit_url);
                        $('#name_upd').val(inputs.name);
                        $('#amount_upd').val(inputs.amount);
                        $('#datetime_upd').val(inputs.datetime);
                        $("#expense_edit_modal").modal('show');
                    }else{
                        alert('some error occured, please refresh page and try again');
                    }

                },
                error:function(error){
                    console.log(error.responseText);
                }
            })
        }
    </script>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 ">
      
        @include('flash-msg')
      
    </div>
</div>

@include('expenses.list')

@include('expenses.create')
@include('expenses.edit')
@foreach($expenses as $e)
    <div id="{{$e->id}}_expense" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this expense? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/expenses/'.$e->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    
@endforeach

@endsection