<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

    function __construct(){
		parent::__construct();
		if ($this->session->userdata('log_in') !==TRUE){
            redirect('admin/vwLogin');
            $this->load->library("session");
		}
    }

    function index()
    {
        if ($this->session->userdata('roleid') ==='1')
        { 
            $this->load->view('admin/vwDashboard');  
        }
        else{
            echo "Access Denied";
        }
    }

    function checkuser()
    {
        if ($this->session->userdata('roleid')=='2')
        {
            $this->load->view('admin/vwDashboard');
        }
        else
        {
            echo "Access Denied";
        }
    }



}
?>