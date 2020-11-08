<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Common_Model","common");		
 	}
 
   	public function index()
	{
		$this->load->view('admin/admin_login');	
	}

	public function adminchecklogin()	
	{
		$user_name		=	(isset($_POST['user_name']) && !empty($_POST['user_name'])) ? $_POST['user_name'] : false;
		$password		=	(isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : false;
		if(!empty($user_name) && !empty($user_name))
		{
			$parameter = array();
			$parameter['select'] 	= '*';
			$parameter['table'] 	= 'user';
			$parameter['whereArr'] 	= array( 'user_name' => $user_name, 'password' => md5($password), "u_status" => 1, "is_block" => 0, "is_deleted" => 0 );
			$userData				= $this->common->getParameters($parameter);
			
			if(!empty($userData))
			{
				$uid		=	$userData->id;
				$full_name	=	$userData->u_name;
				$uname		=	$userData->user_name;
				$roleid		=	$userData->role_id;
				$is_super	=	$userData->is_super;
				$sessionData=array(
					'uid' 			=> $uid,
					'name' 			=> $full_name,
					'username' 		=> $uname,
					'log_in'   		=> TRUE,
					'type'			=> "admin",
					'is_super'		=> $is_super
				);
				$this->session->set_userdata($sessionData);
				redirect('admin');
			}
			else{
				$this->session->set_flashdata('msg','User name or Password wrong');
				redirect('login/');
			}
		}
		else{
			$this->session->set_flashdata('msg','User name or Password wrong');
			redirect('login/');
		}
	}
	
	
	public function adminlogout()
	{ 		
		$data = array(
                'uid' 		=> "",
				'name' 		=> "",
				'username' 	=> "",
				'log_in'   	=> "",
				'type'		=> "",
				'is_super'	=> ""
               );
		$this->session->unset_userdata($data);
		$this->session->sess_destroy();
		$this->session->set_flashdata('msg', 'You are Successfully Logout.!');
		redirect('/login/','refresh');
	}
	
}
