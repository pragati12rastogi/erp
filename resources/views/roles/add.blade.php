@extends('layouts.master')
@section('title', 'Add Role')

@push('style')

@endpush

@push('custom-scripts')
    <script>
        $(function() {
            jQuery('#role_form').validate({ // initialize the plugin
                rules: {

                    name: {
                        required: true,
                    }
                    'permission[]':{
                        required: true
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
      <div class="card-body">
        <div class="border-bottom mb-3 row">
            <div class="col-md-10">
                <h4 class="card-title">Add Role</h4>
            </div>
            <div class="col-md-2 text-right" >
                <a class="btn btn-inverse-primary btn-sm" href="{{ route('roles.index') }}"><i class="mdi mdi-redo-variant"></i> Back</a>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
          <form id="role_form" method="post" enctype="multipart/form-data" action="{{url('roles')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br/>
                            <div class="row">
                            @foreach($permission as $value)
                            <label class="col-md-2">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            
                            @endforeach
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