	<!----- SITE HEADER VIEW ----->
	<?php
		$this->load->view('layouts/vwHeader');
	?>
    
    <div class="hero-wrap"  id="home" style="background-image: url('<?php echo ASSETS_URL;?>images/bg_111.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
          <div class="col-md-6 order-md-last ftco-animate mt-5" data-scrollax=" properties: { translateY: '70%' }">
            <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">We can help to save the world</h1>
            <p><a href="#donate_now" class="btn py-3 px btn-black">DONATE NOW</a> 
			<a type="button" class="btn py-3 px  btn-primary text-white" data-toggle="modal" data-target="#useerRequestModal">REGISER & GET SUPPORT</a></p>
          </div>
          <div class="col-md-6 d-none d-md-block hide">
          	<div class="play-video pb-5 d-flex align-items-center hide">
           	</div>
          </div>
        </div>
      </div>
    </div>
	
	
	

    <section class="ftco-section ftco-no-pt ftco-no-pb ftco-volunteer"  id=""  >
    	<div class="container">
    		<div class="row">
    			<div class="col-md-7 img-volunteer" style="background-image: url('<?php echo ASSETS_URL;?>images/about.jpg');">
    				<div class="row no-gutters justify-content-end hide">
    					<div class="col-lg-7">
    						<div class="text py-5 pl-md-4 pr-md-3">
    							<h2 class="mb-4">We need volunteers in India</h2>
    							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics</p>
    							<p><a href="#" class="btn btn-primary py-3 px-4">Join now</a></p>
    						</div>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-5 d-flex align-items-center bg-black">
    				<div class="about-text py-5 pl-md-5">
    					<h2>Donation so far <span>INR</span><strong class="number" data-number="3000">0</strong></h2>
    					<p>Any Help or donation , no matter how small will be deeply appreciated and is much needed
						</p>
    					<p><a href="#donate_now" class="btn btn-black py-3 px-4">Donate now</a></p>
    				</div>
    			</div>
    		</div> 
    	</div>
    </section>
	
    <section class="ftco-section ftco-causes" id="ourmission">
    	<div class="container">
    		<div class="row justify-content-center pb-3">
          <div class="col-md-10 heading-section text-center ftco-animate">
            <h2 class="mb-4">OUR MISSION </h2>
            <p>			</p>
          </div>
        </div>
    	</div>
    	<div class="container">
        <div class="row">
        	<div class="col-md-12">
				<p>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
					Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
					when an unknown printer took a galley of type and scrambled it to make a type specimen book.
					It has survived not only five centuries, but also the leap into electronic typesetting, 
					remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset 
					sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus 
					PageMaker including versions of Lorem Ipsum.
				</p>
			</div>
        	<div class="col-md-12 hide">
        		<div class="carousel-causes owl-carousel hide">
        			<div class="item">
		        		<a href="causes.html" class="causes text-center">
		        			<div class="img" style="background-image: url('<?php echo ASSETS_URL;?>images/causes-1.jpg');"></div>
		        			<h2>Adoption, Fostering &amp; Children Care</h2>
		        		</a>
        			</div>
        			<div class="item">
	        			<a href="causes.html" class="causes text-center">
		        			<div class="img" style="background-image: url('<?php echo ASSETS_URL;?>images/causes-2.jpg');"></div>
		        			<h2>Disadvantages Young People</h2>
		        		</a>
	        		</div>
	        		<div class="item">
	        			<a href="causes.html" class="causes text-center">
		        			<div class="img" style="background-image: url('<?php echo ASSETS_URL;?>images/causes-3.jpg');"></div>
		        			<h2>Meditation &amp; Crisis Services</h2>
		        		</a>
	        		</div>
	        		<div class="item">
	        			<a href="causes.html" class="causes text-center">
		        			<div class="img" style="background-image: url(<?php echo ASSETS_URL;?>images/causes-4.jpg);"></div>
		        			<h2>Providing Children Care and Education</h2>
		        		</a>
	        		</div>
	        		<div class="item">
	        			<a href="causes.html" class="causes text-center">
		        			<div class="img" style="background-image: url(<?php echo ASSETS_URL;?>images/causes-5.jpg);"></div>
		        			<h2>Safeguarding &amp; Consultancy Services</h2>
		        		</a>
	        		</div>
        		</div>
        	</div>
        </div>
    	</div>
    </section>
	<?php $data['donation_type'] = (isset($donation_type)) ? $donation_type : false ; ?>
	<!----- Donation FORM VIEW ----->
	<?php $this->load->view('forms/vwDonationForm',$data); ?>

    <footer class="ftco-footer ftco-section  ">
      <div class="container">
       <div class="row">
          <div class="col-md-12 text-center">

            <p> 
				Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
			</p>
          </div>
        </div>
      </div>
    </footer>
    
	<!----- SITE Footer VIEW ----->
	<?php
		 $this->load->view('layouts/vwFooter');
	?> 
	<?php
			if(!empty($this->session->flashdata('flag')))
			{
	?>
				<script>
					swal("<?php echo $this->session->flashdata('title'); ?>", "<?php echo $this->session->flashdata('message'); ?>", "<?php echo $this->session->flashdata('flag'); ?>");
				</script>
	<?php
			}
	?>