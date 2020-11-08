<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donation extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Donation_Model");	
 	}
 
   	public function index()
	{
		$this->load->view('forms/vwDonationForm');	
	}

	public function getdata()	
	{
		$data    =array();
		$data['d_name']		=	$this->input->post('name',TRUE);	
		$data['email']		=	$this->input->post('email',TRUE);	
		$data['cell']  		=	$this->input->post('phone',TRUE);		
		$data['d_amount']	=	$this->input->post('amount',TRUE);		
		$inset_id           =   $this->Donation_Model->savedata($data,'donation');
		if($inset_id !==0)
		{
			$this->session->set_flashdata('Save', 'data saved successfully');
			redirect('Dashboard');
		}
		else
		{
			$this->session->set_flashdata('Error', 'Some Thing Wrong');
			redirect('Dashboard');
		}
	
	}
}
