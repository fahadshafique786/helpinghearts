		
		<form id="userreq_form" action="<?php echo base_url("UserRequest\SaveData");?>" method="post" class="contact-form" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12 section-heading">
					<h3 class="section_heading"> PERSONAL INFORMATION </h3>
 				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="text-black bold"> Name <span class="text-danger"> * </span> </label>
						<input type="text" class="form-control" name="name" data-validation="true" id="name" placeholder="Name"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>
					
				</div>
				<div class="col-md-4">
				  <div class="form-group">
					<label class="text-black bold"> State  <span class="text-danger"> * </span>  </label>
					<select  class="form-control" name="country"  id="country"  data-validation="true" >
						<option	value="">Select State</option>
						<option	value="1" selected>India</option>
					</select> 
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
				  </div>
			
				</div>
				
					<div class="col-md-4">

				  <div class="form-group">
					<label class="text-black bold"> City  <span class="text-danger"> * </span>  </label>
					<input type="email" class="form-control" name="email" data-validation="true" id="email" placeholder="e.g. abc@domain.com"   />
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
				  </div>					 
				  
				</div>			
				
				
			</div>
			  
			<div class="row">

				<div class="col-md-4">
				  

				  <div class="form-group">
					<label class="text-black bold"> Support Required For <span class="text-danger"> * </span> 	</label>
					<select  class="form-control" name="reason"  id="reason"  data-validation="true" >
						<option	value="">Select</option>
						<option	value="1"  >Family Support</option>
						<option	value="2"  >Medical Health</option>
						<option	value="3"  >Education</option>
						<option	value="4"  >Hospital Bills</option>
					</select> 
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>	
				  
				</div>
				
				<div class="col-md-4">

				  <div class="form-group">
					<label class="text-black bold"> Support  For <span class="text-danger"> * </span> 	</label>
					<select  class="form-control" name="support_reason"  id="support_reason"  data-validation="true" >
						<option	value="">Select</option>
						<option	value="1"  >My self</option>
						<option	value="2"  >My Wife</option>
						<option	value="3"  >Son</option>
						<option	value="4"  >Daughter</option>
					</select> 
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>						 
				  
				</div>
				
				
				
				<div class="col-md-4">
				  

				  <div class="form-group">
					<label class="text-black bold"> Mobile Number <span class="text-danger"> * </span> 	</label>
					<input type="text" class="form-control phone_number" data-validation="true"  name="phone" id="phone" placeholder="Mobile No."   />
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
				  </div>	
				  
				</div>				
				
				
			</div>
			  
 

			<div class="row">

				<div class="col-md-4">

				  <div class="form-group ">
					<label class="text-black bold block dp-block" style="display:block"> Eligble for  <span class="text-danger"> * </span>  </label>
					<label class="dp-block"  style=""> <input type="radio"  checked="zakath"   value="yes" name="isemployee" data-validation="false" id="isemployee_true" /> Zakath</label>
					<label class="dp-block"  style=""> <input type="radio"  checked="sadaqa"   value="yes" name="isemployee" data-validation="false" id="isemployee_true" /> Sadaqah</label>
					<label class="dp-block"  style=""> <input type="radio"  value="-1" name="isemployee" data-validation="false" id="isemployee_false"/>  Other
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</label>
					
					</div>
				</div>
			
				<div class="col-md-4">

				  <div class="form-group">
					<label class="text-black bold"> Upload Aadhar Card <span class="text-danger"> * </span>  </label>
					<input type="file" class="form-control" name="IDcard"  data-validation="true"  id="IDcard"  accept=".png,.jpg,.jpeg,.tiff,.bmp"   onchange="allowonlyImg(this)" />
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
				  </div>

					 
				</div>
				<div class="col-md-4">
				  
					<div class="form-group">
						<label class="text-black bold"> Upload Your Docments  <span class="text-danger"> * </span>  </label>
						<input type="file" class="form-control" name="document" data-validation="true"  id="document"  accept=".docx,.doc,.pdf"   onchange="allowonlyDoc(this)"  />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>

				</div>
			</div>
			  

			<div class="row">
				<div class="col-md-4">
			
					  <div class="form-group">
						<label class="text-black bold">Amount  <span class="text-danger"> * </span>  </label>
						<input type="number" class="form-control number_only" data-validation="true"  name="amount" id="amount" placeholder="xxxxx rupees"  />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					  </div>


	
				</div>
				<div class="col-md-4">
				  
					<div class="form-group">
						<label class="text-black bold">Email ID  <span class="text-danger"> * </span>  </label>
						<input type="email" class="form-control" data-validation="true"  name="email" id="email"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
						<small style="position:absolute;" class="text-danger"> <i class="fa fa-info"></i>   Note : You may receive verification email on this email id.</small>
					  </div>

				</div>
				
				

				<div class="col-md-4">

				  <div class="form-group ">
					<label class="text-black bold block dp-block" style="display:block"> Currently Employed?  <span class="text-danger"> * </span>  </label>
					<label class="dp-block"  style=""> <input onchange="employeeCheck(this.value)" type="radio"  checked="checked"   value="yes" name="isemployee" data-validation="false" id="isemployee_true" /> Yes</label>
					<label class="dp-block"  style=""> <input onchange="employeeCheck(this.value)"  type="radio"  	value="no" name="isemployee" data-validation="false" id="isemployee_false"/> No 
					<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					
					</label>
					
					<div class="form-group salary_slip_attach_div" id="salary_slip_attach_div">
						<label class="">Attach Current Salaray Slip / Proof of letter</label>
						<input type="file" class="form-control" name="salary_slip"  data-validation="false"  id="salary_slip"  accept=".doc,.docx,.pdf,.png,.jpg,.jpeg,.tiff,.bmp"   onchange="allowonlyImg(this);" />
					</div>					 

					<div class="form-group ref_letter_attach_div" id="ref_letter_attach_div">
						<label class="">Reference Letter</label>
						<input type="file" class="form-control" name="reference_letter"  data-validation="false"  id="reference_letter"  accept=".doc,.docx,.pdf,.png,.jpg,.jpeg,.tiff,.bmp"   onchange="allowonlyImg(this)" />
					</div>					 

				  </div>					 
				  
				</div>					
				
				
				
				
				
				
				
			</div>

			<div class="row">
				<div class="col-md-6">

					  <div class="form-group">
						<label class="text-black bold"> Address  <span class="text-danger"> * </span>  </label>
						<textarea maxlength="500" cols="30" rows="3" name="address" id="address" data-validation="false"  class="form-control" placeholder="500 characters max"></textarea>
					  </div>
					 

				</div>
			</div>	
			
			
			<div class="row">
				<div class="col-md-12 section-heading">
					<h3 class="section_heading"> BANK TRANSFER DETAILS </h3>
 				</div>
			</div>

			  
			<div class="row">
				<div class="col-md-12">

					  <div class="form-group">
						<p class="text-danger">
							Note : 
							<br/>
							Amount will not be transferred personal bank account for educational & Health support 
							<br/>
							For family support - Max amount is 3000 Rs 
						
						</p>
					  </div>					 


				</div>
			</div>
			  
		  
				  
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="text-black bold"> Account Name<span class="text-danger"> * </span> </label>
						<input type="text" class="form-control" name="account_name" data-validation="true" id="account_name" placeholder="Account Name"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="text-black bold"> Account Type <span class="text-danger"> * </span> </label>
						<input type="text" class="form-control" name="account_type" data-validation="true" id="account_type" placeholder="Account Type"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="text-black bold"> Bank Name <span class="text-danger"> * </span> </label>
						<input type="text" class="form-control" name="bank_name" data-validation="true" id="bank_name" placeholder="Bank Name"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>
					
				</div>
				
				
				<div class="col-md-6">
					<div class="form-group">
						<label class="text-black bold"> Bank IFSC CODE <span class="text-danger"> * </span> </label>
						<input type="text" class="form-control" name="bank_code" data-validation="true" id="bank_code" placeholder="Bank Code"   />
						<img class="info_validate" src="<?php echo ASSETS_URL.'images/info_validate.png';?>"/>
					</div>
					
				</div>
				
				
				
			</div>
			  
		  
				  
			<div class="row">
				<div class="col-md-12">
 
					  <div class="form-group text-center">
						<input type="submit" value="REGISTER NOW " class="bold btn-lg btn btn-black">
					  </div>

				</div>
			</div>
			  
		  
			  

		</form>
