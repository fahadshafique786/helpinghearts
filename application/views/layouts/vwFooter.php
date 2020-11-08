

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="<?php echo ASSETS_URL;?>js/jquery.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/popper.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/bootstrap.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery.easing.1.3.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery.waypoints.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery.stellar.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/owl.carousel.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/aos.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/jquery.animateNumber.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/scrollax.min.js"></script>
  <script src="<?php echo ASSETS_URL;?>js/main.js"></script>
    
  <!-- sweetalert JS-->
  <script src="<?php echo ASSETS_URL;?>js/sweetalert.min.js"></script>
  
<script>
function paymentConfirmation()
{
	var check = true;
		$(".require").each(function (item) {
			$(this).removeClass("error");
			if($(this).val() == "" || $(this).val() == " ")
			{
				$(this).addClass("error");
				check = false;
			}
		});
		
		if(!check)
		{
			swal("Error", "Please fill all required fields", "error");
			return false;
		}

		if(check)
		{
			var type 		= $("#contribution_type option:selected").text();
			var cname 		= $("#name").val();
			var cemail 		= $("#email").val();
			var contact 	= $("#contact_no").val();
			var amount 		= $("#amount").val();
			
			var	msg ="<table class='confirmation_table' border='1' style='border: 1px solid #ccc !important;box-shadow: 2px 1px 8px #ccc;border-collapse:collapse;;width:100%'><tr><td>Contribution Type</td><td>"+type+"</td></tr><tr><td>Name</td><td>"+cname+"</td></tr><tr><td>Email</td><td>"+cemail+"</td></tr><tr><td>Contact No.</td><td>"+contact+"</td></tr><tr><td>Amount</td><td>"+amount+"</td></tr></table>";
		  
			  const wrapper = document.createElement('div');
			  wrapper.innerHTML = msg;

			  swal({
				  title: "Please Review Your Donation",
				  content: wrapper, 
				  icon: "info",
				  className: "order_confirmation_swal",
				  buttons: [
					'Cancel',
					'Confirm Donation'
				  ],
				  dangerMode: false,
				}).then(function(isConfirm) {
				  if (isConfirm){
						$("#donation_form").attr("action",'<?= base_url("Home/SaveDonation");?>');
						$("#SaveBtn").trigger("click");
					} 
				});
		}	
}

function validate_email(email)
{
	var check = true;
	if(email != "")
	{
		var email_address = email;
		email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
		if(!email_regex.test(email)){ 
			check = false;  
		}
	}
	return check;
}

function allowonlyDoc(e){

	var id = e.id;
	if(id == '')
		return false;
	
	var files = $('#'+id)[0].files[0];
	if(files)
	{
		var filename = files.name;
		var fileNameExt = filename.substr(filename.lastIndexOf('.') + 1).toLowerCase();
		var validExtensions = ['docx','doc','pdf']; //array of valid extensions
		if ($.inArray(fileNameExt, validExtensions) == -1)
		{
			swal("Error", "Invalid file type", "error");
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
		var validExtensions = ['pdf','docx','doc','jpeg','jpg','png','tiff','bmp']; //array of valid extensions
		if ($.inArray(fileNameExt, validExtensions) == -1)
		{
			swal("Error", "Invalid file type", "error");
			$("#"+id).val('');
			return false;
		}
	}
}

function employeeCheck(value)
{
	if(value== 'yes')
	{
		$("#ref_letter_attach_div").hide();
		$("#salary_slip_attach_div").show();
	}
	else
	{
		$("#salary_slip_attach_div").hide();
		$("#ref_letter_attach_div").show();		
	}
}
$(document).ready(function(){
	
	$("form#userreq_form").submit(function(){
		valid = true;
		$('img.info_validate').hide();
		$(this).find('.error').removeClass('error');

		$("form#userreq_form input[data-validation='true'] , form#userreq_form select[data-validation='true']").each(function(){
			$(this).removeClass('error');
			//console.log($(this).val());

			if($(this).attr('type') ==  'radio' && $(this).attr('name') ==  'isemployee')
			{
				$("#salary_slip,#reference_letter").removeClass('error');
				if($(this).val() == "yes")
				{
						employeeCheck($(this).val());
					
//						$("#salary_slip").addClass('error');
						
						valid =  false;


				}				
				else if($(this).val() == "no")
				{
					//if( $("#reference_letter").val() == "")
					//{
						employeeCheck($(this).val());
						//$("#reference_letter").addClass('error');
 						valid =  false;
					//}
				}				
			}
			else
			{
				if($(this).val() == "")
				{

					$(this).next('img.info_validate').show();
					$(this).addClass('error');
					valid =  false;
				}				
			}

		});
		
		if(!valid)
		{
			swal("Error", "Please fill all required fields", "error");
			return false;
		}
		else
		{
			 return valid;

		}
	});
	
	
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

</script>

<style>

</style>
<!-- Modal -->
<div id="useerRequestModal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Register & <span class="text-primary">GET SUPPORT </span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

			<?php $this->load->view('forms/vwUserRequestForm'); ?>

      </div>
    </div>

  </div>
</div>	
	
	
  </body>
</html>