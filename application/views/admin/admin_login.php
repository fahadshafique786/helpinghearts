<?php require_once 'layouts/login_header.php';?>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">    </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <!-- login page with video background start-->
        <div class="auth-bg-video">
          <video id="bgvid" poster="<?php echo ADMIN_ASSET_URL; ?>images/other-images/coming-soon-bg.jpg" playsinline="" autoplay="" muted="" loop="">
            <source src="<?php echo ADMIN_ASSET_URL; ?>video/auth-bg.mp4" type="video/mp4">
          </video>
          <div class="authentication-box">
            <div class="mt-4">
              <div class="card-body">
                <div class="cont text-center">
                  <div> 
                    <form class="theme-form" id="login_form" action="<?= base_url("login\adminchecklogin");?>" method="post">
				      <?php echo create_csrfinput(); ?>	
                      <h4>LOGIN</h4>
                      <h6>Enter your Username and Password</h6>
					  
						<?php if(!empty($this->session->flashdata('msg'))){?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong><?php echo $this->session->flashdata('msg'); ?></strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php } ?>
						
                      <div class="form-group">
                        <label class="col-form-label pt-0">Your Name</label>
                        <input class="form-control" type="text" name="user_name" id="user_name" required="">
                      </div>

                      <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required="">
                      </div>

                      <div class="checkbox p-0">
                        <input id="checkbox1" type="checkbox">
                        <label for="checkbox1">Remember me</label>
                      </div>

                      <div class="form-group row mt-3 mb-0">
                        <button class="btn btn-primary btn-block" type="submit">LOGIN</button>
                      </div>
                       </form>
                      </div>           
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- login page with video background end-->
      </div>
    </div>
<?php require_once 'layouts/login_footer.php';?>