     <!-- Container-fluid starts-->
     <?php $this->load->view('admin/layouts/vwHeader');?> 
     <div class="container-fluid">
            <div class="row">
            
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <h5>Sit map</h5>
                      </div>
                      <form class="theme-form" action="<?= base_url("menu\savevalue");?>" method="post">
                      <?php echo create_csrfinput(); ?>	
                        <div class="card-body">

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label" for="">Menu name</label>
                              <div class="col-sm-9">
                                <input class="form-control" id="menuname"  name="menuname" type="text" placeholder="Menu name">
                              </div>
                          </div>
                        
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label" for="parentlevel" >Parent Level</label>
                               <div class="col-sm-9">
                              <select class="form-control input-air-primary digits" id="parentlevel" name="parentlevel">
                              <option value='0'> Select Menu </option>
                              <?php
                                foreach($parentlist as $obj){
                                ?>
                                <option value="<?php echo $obj->id; ?>"> <?php echo  $obj->m_name; ?></option> 
                                <?php
                                }
                              ?>
                              </select>
                             </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label" for="m_status">Status</label>
                              <div class="col-sm-9">
                              <select class="form-control input-air-primary digits" id="m_status" name="m_status">
                                <option value="1">Active</option>
                                <option value="0">NonActive</option>               
                              </select>
                            </div>
                            </div>
                        </div>
                        
                         <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Check Option</label>
                            <div class="col-sm-9">
                              <div class="form-group m-checkbox-inline mb-0">
                                <div class="checkbox checkbox-primary">
                                  <input id="inline-form-1" type="checkbox" id="checkc" name="checkc">
                                  <label class="mb-0" for="inline-form-1">Controller </label>
                                </div>
                                <div class="checkbox checkbox-primary">
                                  <input id="inline-form-2" type="checkbox" id="checkv" name="checkv">
                                  <label class="mb-0" for="inline-form-2">View </label>
                                </div>
                              </div>
                            </div>
                          </div>

                        <div class="card-footer">
                          <input class="btn btn-primary" name="save" type="submit" value="Submit"/>
                          <button class="btn btn-secondary">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
              </div>
              </div>

              <?php  $this->load->view('admin/layouts/vwFooter'); ?>