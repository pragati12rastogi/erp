@extends('layouts.master')
@section('title', 'Invoice Master')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            
            jQuery('#invoice_master_form').validate({ // initialize the plugin
                rules: {

                    
                    prefix:{
                        required:true,
                    },
                    suffix_number_length:{
                        digits: true,
                        required: true
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
        
    </script>
@endpush

@section('content')
<div class="row">

  <div class="col-lg-12 grid-margin stretch-card">
      
    <div class="card">
    @include('flash-msg')
    
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Invoice Master</h4>
            </div>
            
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="invoice_master_form" method="post" enctype="multipart/form-data" action="{{route('save.invoice.master')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                
                @foreach($invoice_setting as $in => $setting)
                <div class="row">
                    <div class="col-md-12">
                        <b>Invoice Master for {{$setting->user->name}} :</b>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Invoice Number Prefix: <span class="required">*</span>
                            </label>
                            <input name="prefix[{{$setting['id']}}]" value="{{!empty($setting['prefix'])?$setting['prefix']:''}}" type="text" maxlength="255" class="form-control text-capitalize" >
                            @error('prefix.'.$setting->id)
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Suffix Invoice Number: <span class="required">*</span>
                            </label>
                            <input name="suffix_number_length[{{$setting['id']}}]" value="{{!empty($setting['suffix_number_length'])?$setting['suffix_number_length']:''}}" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" >
                            @error('suffix_number_length.'.$setting->id)
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    

                </div>
                @endforeach

                <div class="col-xs-12">
                    <hr>
                    <button type="submit" class="btn btn-dark mt-3">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection