<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_Model extends CI_Model{


   function __construct(){
    parent::__construct();
	}

	 function validate($user_name,$password)
	 {
		$this->db->where('user_name',$user_name);
		$this->db->where('password',$password);	
		$result  =	$this->db->get('accounts',1);
		return 		$result;

	}


    }

?>