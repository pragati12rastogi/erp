@extends('layouts.master')
@section('title', 'Edit Item')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            
            jQuery('#item_form').validate({ // initialize the plugin
                rules: {

                    
                    hsn:{
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
                <h4 class="card-title">Edit Item</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a href="{{url('item')}}" class="btn btn-inverse-primary btn-sm"><i class="mdi mdi-redo-variant"></i>{{__("Back")}}</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <form id="item_form" method="post" enctype="multipart/form-data" action="{{url('item/'.$item->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Item Name: <span class="required">*</span>
                            </label>
                            <input name="name" value="{{$item->name}}" type="text" maxlength="255" class="form-control text-capitalize" >
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                Category: <span class="required">*</span>
                            </label>
                            <select class="form-control select2" name="category_id" >
                                <option value="">Select Category</option>
                                @foreach($categories as $ind => $cat)
                                    <option value="{{$cat->id}}" {{($item->category_id == $cat->id)?'selected':''}}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                HSN: <span class="required">*</span>
                            </label>
                            <select class="form-control select2" name="hsn_id" >
                                <option value="">Select Hsn</option>
                                @foreach($hsns as $ind => $hsn)
                                    <option value="{{$hsn->id}}" {{($item->hsn_id == $hsn->id)?'selected':''}}>{{$hsn->hsn_no}}</option>
                                @endforeach
                            </select>
                            @error('hsn_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="first-name">
                                GST: <span class="required">*</span>
                            </label>
                            <select class="form-control select2" name="gst_percent_id" >
                                <option value="">Select GST</option>
                                @foreach($gsts as $ind => $gst)
                                    <option value="{{$gst->id}}" {{($item->gst_percent_id == $gst->id)?'selected':''}}>{{$gst->name}}({{$gst->percent}} %)</option>
                                @endforeach
                            </select>
                            @error('gst_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label" for="address">
                                        Image: 
                                    </label>
                                    <br>
                                    <input type="file" id="photo" name="photo" accept="image/*">
                                    <br>
                                    <small class="txt-desc">(Photo accept jpeg,png and jpg)</small>
                                    @error('photo')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                @if($item->image != '' && file_exists(public_path().'/uploads/items/'.$item->image))
                                <div class="card-inverse-secondary ">
                                    <center>
                                        
                                            <img class="img-avatar" src=" {{url('/uploads/items/'.$item->image)}}">
                                       
                                    </center>    
                                </div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-xs-12 ">
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