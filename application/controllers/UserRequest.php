<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRequest extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("UserRequest_Model");
		$this->load->model('Common_Model','common');
		$this->load->library('upload');		
		$this->load->library("session");
		$this->load->library('email');
 	}
 
   	public function index()
	{
		$this->load->view('forms/vwUserRequestForm');	
	}

	public function SaveData()
	{
		$flag 		= 'error';
		$title 		= 'Request Failed.!';
		$message 	= 'Something went wrong.';

		$email 	= (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
		$phone 	= (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : false;
		if(!empty($phone) && !empty($email))
		{
			$table 				= "requests";
			$para 				= array();
			$para['select'] 	= 'id';
			$para['table'] 		= $table;
			$para['whereArr'] 	= array( "email" => $email );
			$emailCheck			= $this->common->getParameters($para);
			if(empty($emailCheck))
			{
				$para 				= array();
				$para['select'] 	= 'id';
				$para['table'] 		= $table;
				$para['whereArr'] 	= array( "phone" => $phone );
				$phoneCheck			= $this->common->getParameters($para);
				if(empty($phoneCheck))
				{
					$save_array['u_name']	= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
					$save_array['country'] 	= (isset($_POST['country']) && !empty($_POST['country'])) ? $_POST['country'] : false;
					$save_array['email']	= $email;
					$save_array['phone']	= $phone;
					$save_array['amount']	= (isset($_POST['amount']) && !empty($_POST['amount'])) ? $_POST['amount'] : false;
					$save_array['address']	= (isset($_POST['address']) && !empty($_POST['address'])) ? $_POST['address'] : false;
					
					$cardData 		= UploadFile($_FILES['IDcard']);
					$documentData 	= UploadFile($_FILES['document']);
					
					$save_array['IDcard_name']			= (!empty($cardData) && isset($cardData['actual_filename']) && !empty($cardData['actual_filename'])) ? $cardData['actual_filename'] : false;
					$save_array['IDcard_unique_name']	= (!empty($cardData) && isset($cardData['unique_filename']) && !empty($cardData['unique_filename'])) ? $cardData['unique_filename'] : false;

					$save_array['document_name']		= (!empty($documentData) && isset($documentData['actual_filename']) && !empty($documentData['actual_filename'])) ? $documentData['actual_filename'] : false;
					$save_array['document_unique_name']	= (!empty($documentData) && isset($documentData['unique_filename']) && !empty($documentData['unique_filename'])) ? $documentData['unique_filename'] : false;

					$lastId 	= $this->common->Save($save_array,$table);
					
					if(!empty($lastId))
					{
						$flag 		= 'success';
						$title 		= 'Thank you for Your Request.!';
						$message 	= "Your Request has been successfully Submitted.";
					}
				}
				else
				{
					$flag 		= 'error';
					$title 		= 'Request Failed.!';
					$message 	= 'Your Phone No. is already Registered.';
				}
			}
			else
			{
				$flag 		= 'error';
				$title 		= 'Request Failed.!';
				$message 	= 'Your Email is already Registered.';
			}
		}
		
		$this->session->set_flashdata('flag', $flag);
		$this->session->set_flashdata('title', $title);
		$this->session->set_flashdata('message', $message);
		
		redirect('/');
		
	}

}

?>