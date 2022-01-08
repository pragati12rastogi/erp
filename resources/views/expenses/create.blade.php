@if(Auth::user()->hasPermissionTo('expenses.create') || Auth::user()->hasRole(App\Custom\Constants::ROLE_ADMIN) )
<div id="add_expense_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content bg-inverse-light">
            <div class="modal-header">
                <h4 class="modal-heading">Add Expense</h4>
                <button type="button" class="close m-0 p-0" data-dismiss="modal">&times;</button> 
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <form id="expense_form" method="post" enctype="multipart/form-data" action="{{url('expenses')}}" data-parsley-validate class="form-horizontal form-label-left">
                          {{csrf_field()}}
                          
                          <div class="row">
                              
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label" for="first-name">
                                          Expense Name: <span class="required">*</span>
                                      </label>
                                      <input name="name" type="text" maxlength="255" class="form-control text-capitalize" >
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
                                          Expense Amount: <span class="required">*</span>
                                      </label>
                                      <input name="amount" min="0" type="number" class="form-control " >
                                      @error('amount')
                                          <span class="invalid-feedback d-block" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label" for="first-name">
                                          Date Time : <span class="required">*</span>
                                      </label>
                                      <input name="datetime" type="datetime-local" maxlength="255" class="form-control " >
                                      @error('name')
                                          <span class="invalid-feedback d-block" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>
                              
                          </div>
                          
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-dark ">Save</button>  
                              <button type="reset" class="btn btn-inverse-dark" data-dismiss="modal">Cancel</button>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif