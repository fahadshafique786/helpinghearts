<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
class Donation_Model extends CI_Model
{

   function __construct()
   {
            parent::__construct();
   }

	 function savedata($data)
	 {
		 $this->db->insert('donation',$data);
		 return $this->db->insert_id();
	 }

}

?>