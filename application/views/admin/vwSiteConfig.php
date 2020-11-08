<?php $this->load->view('admin/layouts/vwheader'); ?> 
 <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php $this->load->view('admin/layouts/vwNavigation'); ?>

        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col-lg-12">
                  <h3>Site Config</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL."admin/siteConfig";?>"><i data-feather="layers"></i></a></li>
                    <li class="breadcrumb-item">Site Config</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Site Config</h5>
                  </div>
                  <form class="form theme-form" id="SiteConfig_form" action="<?= base_url("admin\saveSiteConfig");?>" method="post" enctype="multipart/form-data">
					<?php echo create_csrfinput(); ?>	
					<input type="hidden" name="pri_id" id="pri_id" value="<?php echo isset($site_data->id); ?>" />
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" placeholder="Name" id="name" name="name" required title="Name" value="<?php echo (isset($site_data->s_name)) ? $site_data->s_name : ""; ?>" >
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" placeholder="Title" id="title" name="title" required title="Title" value="<?php echo (isset($site_data->title)) ? $site_data->title : ""; ?>" >
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="email" placeholder="Email" id="email" name="email" required title="Email" value="<?php echo (isset($site_data->email)) ? $site_data->email : ""; ?>" >
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                              <input class="form-control m-input digits" type="tel" placeholder="Phone" id="phone" name="phone" required title="Phone" value="<?php echo (isset($site_data->phone)) ? $site_data->phone : ""; ?>" >
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Company Name</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" placeholder="Company Name" id="company" name="company" required title="Company Name" value="<?php echo (isset($site_data->company)) ? $site_data->company : ""; ?>" >
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Site Url</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="url" placeholder="Site Url" id="site_url" name="site_url" required title="Site Color" value="<?php echo (isset($site_data->link)) ? $site_data->link : ""; ?>" >
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Site Color</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="color" id="site_color" name="site_color" required title="Site Color" value="<?php echo (isset($site_data->color_code)) ? $site_data->color_code : ""; ?>" >
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Site Log</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="file" id="site_log" name="site_log" onchange="allowonlyImg(this)" title="Allow only <?php echo implode(',',Allow_Only_Img);?> file format" >
							  <?php if(isset($site_data->logo) && !empty($site_data->logo)){ ?>
								<img src="<?php echo UPLOAD_DIR.$site_data->logo; ?>" alt="" data-original-title="" title="" height="100" width="100">
							  <?php } ?>
							</div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Site Favicon</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="file" id="site_favicon" name="site_favicon" onchange="allowonlyImg(this)" title="Allow only <?php echo implode(',',Allow_Only_Img);?> file format" >
							  <?php if(isset($site_data->favicon) && !empty($site_data->favicon)){ ?>
								<img src="<?php echo UPLOAD_DIR.$site_data->favicon; ?>" alt="" data-original-title="" title="" height="100" width="100">
							  <?php } ?>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Footer Note</label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="2" cols="5" placeholder="Footer Note" id="footer_note" name="footer_note" required title="Footer Note" ><?php echo (isset($site_data->footer_note)) ? $site_data->footer_note : ""; ?></textarea>
                            </div>
                          </div>
						  <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="2" cols="5" placeholder="Address" id="address" name="address" required title="Address" ><?php echo (isset($site_data->address)) ? $site_data->address : ""; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
					<?php 
						$short_code = "siteConfig_edit";
						if(isset($this->permissionData->$short_code))
						{
					?>
							<div class="card-footer">
							  <div class="col-sm-9 offset-sm-3">
								<button class="btn btn-primary" type="submit">Submit</button>
								<input class="btn btn-light" type="reset" value="Cancel">
							  </div>
							</div>
				<?php 	} ?>
                  </form>
                </div>
              </div>
			</div>
		</div>
          <!-- Container-fluid Ends-->
    </div>
<?php $this->load->view('admin/layouts/vwfooter'); ?>
