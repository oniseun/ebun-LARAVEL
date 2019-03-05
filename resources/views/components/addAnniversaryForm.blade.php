<?php
$anv = new Anniversary;
$anniv_types = $anv->anniversary_types();
$item_types = $anv->item_types();

?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add anniversary</h4>
      </div>
      <div class="modal-body">
        <div class="row">
                                <form  method="post" action="ajax/add-anniversary.php" enctype="multipart/form-data">
                                    <div class="col-lg-12">
                                        <h3>
                                            <i class="fa fa-gift" style="color: crimson" aria-hidden="true"></i> Add an Anniversary
                                        </h3>
                                    </div>
                                    <div class="col-lg-12">

                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon3">Hey there, <?=htmlentities($prof->get_info()['fullname'])?>'s </span>
                                    <input type="text" name="title" class="form-control " placeholder="[birthday],[wedding], [graduation]" />
                                    </div>
                                        
                                    <br>
                                        <textarea name="description" style="min-height:150px" class="form-control " placeholder="Tell us more about the anniversary.."></textarea>
                                    <br></div>
                                    <div class="col-lg-4">
                                    <label >Is comin up on</label>
                                        <input id="datepicker" type="date" class="form-control " name="anniv_date" 
                                        placeholder="Select Annivesary date" editable="false"/>
                                    </div>
                                        
                                   
                                    <div class="col-lg-8">
                                    <label>Anniversary type</label>
                                        <select name="anniv_type" class="form-control ">
                                        <option value=""></option>
                                        <?php
                                            foreach ($anniv_types as $AT):
                                        ?>
                                            <option value="<?=$AT['id']?>"><?=$AT['description']?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                        </select>
                                    </div>

                                        
                                        <div class="col-lg-12">
                                        <hr>
                                        <a href="#" class="append-item-button btn btn-default btn-block"> <i class="fa fa-gift" aria-hidden="true"></i> Add gifts </a>
                                        <span style="display: block; clear: both; margin-bottom:25px;"></span>
                                        <div class="row">
                                                <div class="item-list"></div>
                                        </div>
                                                
                                                
                                                

                                                
                                                

                                        </div>


                                    <div class="col-lg-12">
                                    <br>
                                    <hr>
         <button class="btn btn-danger ajax-submit"> <i class="fa fa-send" aria-hidden="true"></i> Save anniversary</button>                               
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <br>
        <p class="ajax-message"></p>
        
                                    </div>
                                    
                                </form>
                            </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
          

    
          