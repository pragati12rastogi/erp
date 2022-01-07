@extends('layouts.master')
@section('title', 'Item Summary')

@push('style')
  <style>
    .other_image_delete_style{
        position: absolute;
        top: 46px;
        left: 12px;

    }
  </style>
@endpush

@push('custom-scripts')
    <script>
        $(function() {
            $("#item_table").DataTable();
            jQuery('#item_form').validate({ // initialize the plugin
              rules: {
                  name:{
                    required:true,
                  },
                  category_id:{
                    required:true,
                  },
                  hsn_id:{
                    required:true,
                  },
                  gst_percent_id:{
                    required:true,
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

            @foreach($items as $item)
              jQuery('#item_form_{{$item->id}}').validate({ // initialize the plugin
                  rules: {
                    name:{
                      required:true,
                    },
                    category_id:{
                      required:true,
                    },
                    hsn_id:{
                      required:true,
                    },
                    gst_percent_id:{
                      required:true,
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
            @endforeach
        });
        
    </script>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12">
        @include('flash-msg')
  </div>
</div>


@include('item.list')
@include('item.create')
@foreach($items as $item)
    <div id="{{$item->id}}_item" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete this item? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
            <form method="post" action="{{url('/item/'.$item->id)}}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                                
                            
            
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    @include('item.edit')
@endforeach
@endsection