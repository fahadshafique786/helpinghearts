<?php 
	$SiteData = GetSiteData(); 
	$color = (!empty($SiteData) && isset($SiteData->color_code)) ? $SiteData->color_code : "#d0ac67";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?php echo (!empty($SiteData) && isset($SiteData->favicon)) ? UPLOAD_DIR.$SiteData->favicon : "";?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo (!empty($SiteData) && isset($SiteData->favicon)) ? UPLOAD_DIR.$SiteData->favicon : "";?>" type="image/x-icon">
    <title><?php echo (!empty($SiteData) && isset($SiteData->title)) ? $SiteData->title : "";?> Admin Panel</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/chartist.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/date-picker.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo ADMIN_ASSET_URL; ?>css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/responsive.css">
	<!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_ASSET_URL; ?>css/datatables.css">
	
	<!-- Toast CSS File -->
    <link  href="<?php echo ASSETS_URL;?>css/jquery.toast.min.css" rel="stylesheet">
    <link  href="<?php echo ADMIN_ASSET_URL;?>css/custom.css" rel="stylesheet">
  
	 <style>
	 
		.jq-toast-wrap
		{
			width:20% !important;
		}
		
		.switch {
			position: relative;
			display: inline-block;
			width: 60px;
			height: 34px;
		}

		.switch input { 
			opacity: 0;
			width: 0;
			height: 0;
		}

		.slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.slider:before {
			position: absolute;
			content: "";
			height: 26px;
			width: 26px;
			left: 4px;
			bottom: 4px;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		input:checked + .slider {
			background-color: #2196F3;
		}

		input:focus + .slider {
			box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
			-webkit-transform: translateX(26px);
			-ms-transform: translateX(26px);
			transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
			border-radius: 34px;
		}

		.slider.round:before {
			border-radius: 50%;
		}
		.pointer {
			cursor: pointer;
			font-size: 18px;
		}
		#customloader-wrapper {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 100000000;
			background-color: #EEF1F6 !important;
			opacity: 0.50 !important;
		}
		#customloader {
			background: transparent url(<?php echo ASSETS_IMG_URL;?>screen_loader.gif) no-repeat scroll 0 0 !important;
			display: block;
			height: 200px;
			left: 46%;
			position: relative;
			top: 40%;
			/*width: 88px;*/
		}
		.customizer-links{
			display:none;
		}
		.logo-text {
			color: <?php echo $color; ?> !important;
		}
		
		.page-wrapper .page-body-wrapper .page-header .breadcrumb .breadcrumb-item a {
			color: <?php echo $color; ?> !important;
		}

	</style>

  </head>
  <body onload="">
	<!---startTime()--->
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
	<p id="txt" class="hide"></p>
	<div id="customloader-wrapper" style="display: none;">
		<div id="customloader"></div>
	</div>
	 <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
	
		<!-- Page Header Start-->
		  <div class="page-main-header close_icon">
			<div class="main-header-right row m-0">
			  <div class="main-header-left">
				<div class="logo-wrapper">
				<a href="<?php echo BASE_URL."admin";?>">
				<span class="logo-text"> <?php echo (!empty($SiteData) && isset($SiteData->title)) ? $SiteData->title : "";?> </span>
				</a></div>
			  </div>
			  <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle"></i></div>
			  <div class="left-menu-header col">
				<ul>
				  <!--
				  <li>
					<form class="form-inline search-form hide">
					  <div class="search-bg"><i class="fa fa-search"></i></div>
					  <input class="form-control-plaintext" placeholder="Search here.....">
					</form>
					<span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
				  </li>
					--->
				</ul>
			  </div>
			  <div class="nav-right col pull-right right-menu">
				<ul class="nav-menus">

				  <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
				  <li class="onhover-dropdown p-0">
					<div class="media profile-media"><img class="b-r-10" src="<?php echo ADMIN_ASSET_URL; ?>images/dashboard/profile.jpg" alt="">
					  <div class="media-body"><span><?php echo $this->session->userdata('name'); ?></span>
						<p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
					  </div>
					</div>
					<ul class="profile-dropdown onhover-show-div">
					  <li><a href="<?php echo BASE_URL.'Login/adminlogout';?>"><i data-feather="log-out"></i><span>Log Out</span></a></li>
					</ul>
				  </li>
				</ul>
			  </div>
			  <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
			</div>
		  </div>
		  <!-- Page Header Ends -->