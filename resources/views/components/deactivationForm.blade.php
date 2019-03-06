
<!-- start modal for item #myModalitem{{ $gift->id }} -->
<div class="modal fade" id="anniv-item-{{ $gift->id }}" tabindex="-1" role="dialog" aria-labelledby="anniv-item-label-{{ $gift->id }}">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
        
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="anniv-item-label-{{ $gift->id }}">Buy <small>({{ $gift->description }}) for {{ $creatorInfo->fullname }}</small></h4>
            </div>
        
            <div class="modal-body">
              <div class="row">
                  <form  method="post" action="/finalize/deactivate/item">
                    @csrf
                      <div class="col-lg-12">
                          <h3 style="margin-top:0">
                              Please fill in your details 
                          </h3>
                      </div>
                      <div class="col-lg-12">
                      <input  type="hidden" name="anniv_id" value="{{ $aInfo->id }}"  />
                      <input  type="hidden" name="id" value="{{ $gift->id }}"  />
                      <input  type="hidden" name="public_id" value="{{ $aInfo->public_id }}"  />
        
                        <input placeholder="Your Fullname" type="text" 
                                      class="form-control"
                                      name="activator_name" value="" autocomplete="off" /><br>
        
                                      <input placeholder="Your Email address" 
                                      class="form-control"
                                      type="email" name="activator_email" value="" autocomplete="off" /><br>
        
                                      
                                    
                                        
        
                      </div>
                      <div class="col-lg-4">
                          <select name="country_code" class="form-control ">
                              @foreach($countries as $country)
                              <?php
                                $selected = $country->phonecode == 234 ? 'selected="selected"' :'';
                              ?>
                              <option {!! $selected !!}
                               value="{{ $country->phonecode }}">{{ $country->nicename }} (+{{ $country->phonecode }})</option>";
                                
                              @endforeach
                          </select>
                      </div>
        
                        <div class="col-lg-8">
                        <input placeholder="Your Phone Number" 
                                      class="form-control"
                                      type="tel" name="activator_phone" value="" autocomplete="off" /><br>
                      </div>
        
                      <div class="col-lg-12">
                          <br>
                            <label>Notification type <small>How should we notify you?</small></label>
                                <select name="alert_type" class="form-control ">
                                    <option value="email">By Email</option>
                                    <option value="sms">By SMS</option>
                                </select><br>
                      </div>
        
                      <div class="col-lg-12">
                        <p class="ajax-message"></p>
                        <br>
                          <button class="btn btn-success ajax-submit">Buy  ({{ $gift->description }})</button>                               
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                      
                  </form>
              </div>
        </div>
        </div>
        </div>
        </div>
        <!-- end modal for item #myModalitem-{{ $gift->id }} -->