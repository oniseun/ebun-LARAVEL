  <!-- start modal for item #myModalitem{{ $aInfo->id }} -->
  <div class="modal fade" id="add-item-form" tabindex="-1" role="dialog" aria-labelledby="add-item-form-label">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
        
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="add-item-form-label">Add Gift Item</small></h4>
            </div>
        
            <div class="modal-body">
              <div class="row">
                  <form  method="post" action="/admin/finalize/add/item">
                    @csrf
                      <input  type="hidden" name="anniv_id" value="{{ $aInfo->id }}"  />
                      <input  type="hidden" name="public_id" value="{{ $aInfo->public_id }}"  />
        
                      <div class="col-lg-12">
        
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon4">
                        Gift type
                        </span>
                          <select name="type" class="form-control " aria-describedby="basic-addon4">
                          <option value=""></option>
                          @foreach ($itemTypes as $iTypes)
        
                              <option value="{{ $iTypes->id }}">{{ $iTypes->description }}</option>";
                          
                          @endforeach
                          </select> <br>
                      </div><br>
        
                        <input placeholder="Brief description of the gift" type="text" 
                                      class="form-control"
                                      name="description" value="" autocomplete="off" /><br>
        
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">
                        <i class="fa fa-globe" aria-hidden="true"></i> Link
                        </span>
                        <input type="text" class="form-control" placeholder="Web Link to gift  (optional) "
                        name="link" aria-describedby="basic-addon3">
                      </div>
                                    
                      </div>
        
        
                      <div class="col-lg-12">
                        <p class="ajax-message"></p>
                        <br>
                          <button class="btn btn-success ajax-submit">Add Gift</button>                               
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        
                      </div>
                      
                  </form>
              </div>
        </div>
        </div>
        </div>
        </div>
        