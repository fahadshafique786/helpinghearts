          <!-- footer start-->
          <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2018 © Cuba All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/bootstrap/popper.min.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/icons/feather-icon/feather.min.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/sidebar-menu.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/chartist/chartist.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/knob/knob.min.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/knob/knob-chart.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/apex-chart/apex-chart.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/chart/apex-chart/stock-prices.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/notify/bootstrap-notify.min.js"></script>
	<?php 
	if($this->uri->segment(2) == "dashboard")
	{
		echo '<script src="<?php echo ADMIN_ASSET_URL; ?>js/dashboard/default.js"></script>';
	}
	?>
	<script src="<?php echo ADMIN_ASSET_URL; ?>js/notify/index.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/datepicker/date-picker/datepicker.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/script.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/theme-customizer/customizer.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
	
	<!-- Plugins JS start-->
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo ADMIN_ASSET_URL; ?>js/datatable/datatables/datatable.custom.js"></script>
	
	<!-- Toast JS File -->
    <script  src="<?php echo ASSETS_URL;?>js/jquery.toast.min.js"></script>
  
	<script>
		function checkFileFormat(e){

			var id = e.id;
			if(id == '')
				return false;
			
			var files = $('#'+id)[0].files[0];
			if(files)
			{
				var filename = files.name;
				var fileNameExt = filename.substr(filename.lastIndexOf('.') + 1).toLowerCase();
				var validExtensions = ['jpeg','jpg','png','tiff','bmp','mp4','3gp','wmv','avi','mov']; //array of valid extensions
				if ($.inArray(fileNameExt, validExtensions) == -1)
				{
				   alert("Invalid file type");
				   $("#"+id).val('');
				   return false;
				}
			}
		}

		function allowonlyImg(e){

			var id = e.id;
			if(id == '')
				return false;
			
			var files = $('#'+id)[0].files[0];
			if(files)
			{
				var filename = files.name;
				var fileNameExt = filename.substr(filename.lastIndexOf('.') + 1).toLowerCase();
				var validExtensions = ['jpeg','jpg','png','tiff','bmp']; //array of valid extensions
				if ($.inArray(fileNameExt, validExtensions) == -1)
				{
				   alert("Invalid file type");
				   $("#"+id).val('');
				   return false;
				}
			}
		}

		function allowonlyVideo(e){

			var id = e.id;
			if(id == '')
				return false;
			
			var files = $('#'+id)[0].files[0];
			if(files)
			{
				var filename = files.name;
				var fileNameExt = filename.substr(filename.lastIndexOf('.') + 1).toLowerCase();
				var validExtensions = ['mp4','3gp','wmv','avi','mov','flv']; //array of valid extensions
				if ($.inArray(fileNameExt, validExtensions) == -1)
				{
				   alert("Invalid file type");
				   $("#"+id).val('');
				   return false;
				}
			}
		}

		$(document).ready(function(){
			
			$('.decimal_only').keypress(function(event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			});
			
			$('.number_only').keyup(function () { 
			   this.value = this.value.replace(/[^0-9]/g,'');
			});		
			
			$('.phone_number').keyup(function () { 
			   this.value = this.value.replace(/[^0-9+-]/g,'');
			});
		
		});
		
		function toastMsg(type,msg)
		{
			$.toast({
				heading: type,
				text: "<b>"+msg+"</b>",
				showHideTransition: 'fade',
				icon: type,
				position: 'top-right',
				hideAfter: 5000,
			})
		}
		
	</script>
    </body>
</html>