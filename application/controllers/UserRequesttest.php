<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRequest extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("UserRequest_Model");
		$this->load->library('upload');		
		$this->load->library("session");
		$this->load->library('email');
 	}
 
   	public function index()
	{
		$this->load->view('forms/vwUserRequestForm');	
	}

	
	public function getdata()	
	{
		$this->load->config('email');
		$data    =array();
		$data['u_name']	    =	$this->input->post('name',TRUE);	
		$data['country']	=	$this->input->post('country',TRUE);	
		$data['phone']  	=	$this->input->post('phone',TRUE);	
		$data['amount']		=	$this->input->post('amount',TRUE);	
		$data['address']	=	$this->input->post('address',TRUE);	
		if ($this->input->post('address')=="")
		{
		$data['address']   =  "";
		}
		$config['upload_path']   =  "./uploads/";
		$config['allowed_types'] =  "gif|jpg|png|jpeg|pdf";
		$config['overwrite']     =  TRUE;
		$config['max_size']      =  "2048000";
		$config['max_height']    =  "768";
		$config['max_width']     =  "1024";

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$inset_id = "1";
					if (!$this->upload->do_upload('id_card')) {
						$error = array('error' => $this->upload->display_errors());
							print_r($error);
						echo "Error";
					} else {
						$this->upload->data();	
						$data['id_card']         =  $_FILES['id_card']['name'];	
					}

					if (!$this->upload->do_upload('id_document')) {
						$error = array('error' => $this->upload->display_errors());
							print_r($error);
						echo "Error";
					} else {
						$this->upload->data();	
						$data['id_document']     =  $_FILES['id_document']['name'];	 

					
					}
	
	
		$from = $this->config->item('majidhans25@gmail.com');
        $to = $this->input->post('majidali25@hotmail.com');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) 
		{
            echo 'Email has been sent successfully';
        } 
		else 
		{
            show_error($this->email->print_debugger());
        }
	
	

die;
			$inset_id =   $this->UserRequest_Model->savedata($data,'user_request');
	
		if($inset_id !==0)
		{

	        $this->session->set_flashdata('success', 'Data Saved Successfully');
			redirect('Dashboard');	
	
		}
		else
		{
			$this->session->set_flashdata('failed', 'Some Thing Wrong');
			redirect('Dashboard');
		}
	
	}
}




