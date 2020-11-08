	<section class="ftco-mission  bg-light" id="donate_now">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-6 py-4 py-md-5 ftco-animate">
					<form action="#" class="" method="post" id="donation_form">
					  <div class="form-group">
						<h2 class="mb-4 text-black">Donate <span class="text-primary">Now</span></h2>
					  </div>
					  <div class="form-group">
						<select  class="form-control require" name="contribution_type" id="contribution_type" required />
							<option	value="">Contribution Type </option>
							<?php 
							
								if(!empty($donation_type))
								{
									foreach($donation_type as $index => $type)
									{
							?>
										<option	value="<?php echo $type->id; ?>" ><?php echo $type->type_name; ?></option>
						<?php
									}
								}
							?>							
								<option	value="-1" >Other</option>
						</select> 
					  </div>
					  <div class="form-group">
						<input type="text" class="form-control require" name="name" id="name" placeholder="Name" required >
					  </div>
					  <div class="form-group">
						<input type="email" class="form-control require" name="email" id="email" placeholder="Email">
					  </div>
					  <div class="form-group">
						<input type="number" class="form-control require" name="contact_no" id="contact_no" placeholder="Contact No.">
					  </div>
					  <div class="form-group">
						<input type="number" class="form-control require" name="amount" id="amount" placeholder="Donation Amount">
					  </div>
					  <div class="form-group">
						<label class="payumoney_label">
							<input type="radio" class="custom_radio_btn form-control payumoney_radiobtn" checked placeholder="" required />
							<img src="<?php echo ASSETS_URL;?>images/payumoney.png" class="payumoney_image" width="100" />
						</label>
					  </div>
					  <div class="form-group">
						<input type="button" value="DONATE" name="submit" class="bold btn btn-primary py-3 px-5" onclick="paymentConfirmation()" />
						<input type="submit" name="submit" id="SaveBtn" hidden />
					  </div>
					</form>
    			</div>

    			<div class="col-md-1 py-4 py-md-5 img"></div>
    			<div class="col-md-5 py-4 py-md-5 img" style="background-image: url(<?php echo ASSETS_URL;?>images/secure_payment2.jpg) ; background-size: contain;"></div>
    		</div>
    	</div>
    </section>
