<?php  
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_Model extends CI_Model
{

   function __construct()
   {
            parent::__construct();
   }

	 function savedata($data)
	 {
		 $this->db->insert('menu',$data);
		 return $this->db->insert_id();
	 }

}

?>