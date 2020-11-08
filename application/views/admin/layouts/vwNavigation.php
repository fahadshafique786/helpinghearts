<?php 
	$SiteData = GetSiteData(); 
	$color = (!empty($SiteData) && isset($SiteData->color_code)) ? $SiteData->color_code : "#d0ac67";
?>
        <!-- Page Sidebar Start-->
        <header class="main-nav color2-sidebar">
          <div class="logo-wrapper">
		  <a href="<?php echo BASE_URL."admin";?>">
		 <!--- <img class="img-fluid" src="<?php echo ADMIN_ASSET_URL; ?>images/logo/logo.png" alt=""></a> 	--->
			<span class="logo-text" style="font-size:2em"> <?php echo (!empty($SiteData) && isset($SiteData->title)) ? $SiteData->title : "";?> </span>
		  </div>
          <div class="logo-icon-wrapper"><a href="<?php echo BASE_URL."admin";?>"><img class="img-fluid" src="<?php echo (!empty($SiteData) && isset($SiteData->logo)) ? UPLOAD_DIR.$SiteData->logo : "";?>" alt=""></a></div>
          <nav>
            <div class="main-navbar ">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                  <li class="back-btn">
                    <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                  </li>

					<?php
						$GetMenuData = GetMenuData();
						//debug($GetMenuData,false);
						if(!empty($GetMenuData))
						{
							foreach($GetMenuData as $index => $menu)
							{
								$link_short_code = $menu->short_code."_view";
								if(isset($this->permissionData->$link_short_code))
								{
					?>
									<li class="dropdown"><a class="nav-link menu-title link-nav" href="<?php echo BASE_URL.$menu->link;?>"><i data-feather="<?php echo $menu->icon;?>"></i><span><?php echo $menu->m_name;?></span></a></li>
					<?php
								}
								
								if($this->session->userdata('is_super') == 1 && $menu->is_superadmin == $this->session->userdata('is_super') )
								{
					?>
									<li class="dropdown"><a class="nav-link menu-title link-nav" href="<?php echo BASE_URL.$menu->link;?>"><i data-feather="<?php echo $menu->icon;?>"></i><span><?php echo $menu->m_name;?></span></a></li>
					<?php
								}
								
							}
						}
					?>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </header>
        <!-- Page Sidebar Ends-->