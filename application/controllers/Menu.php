<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller{


    function __construct(){
                 parent::__construct();

                 $this->load->model('Menu_Model');
                 $this->load->model('Common_Model');
               //  $this->load->library('form_validation');
               
                }
  

    function index()
    {

        $data =  array();
        $where                =  array();       
        $getdata['select']    =  '*';
        $getdata['table']     =  'menu';
        $getdata['whereArr']  =  $where;
        $parentvalue          =  $this->Common_Model->getAllParameters($getdata);
        $data['parentlist']   =  $parentvalue;
        
      
        
        $this->load->view('forms/vwMenu',$data);	
      
        
    }

    function savevalue($isjson = false)
    {
        $paradata['select']      =  'id';
        $paradata['table']       =  'menu';
        $paradata['num_rows']    =  true;
        $paradata['whereArr']    =   array('m_name' => strtolower($this->input->post('menuname')));
        $total_data              =   $this->Common_Model->getParameters($paradata);
        
        if(empty($total_data))
        {
            if ($this->input->post('save'))
            {
                $data['m_name']     =   $this->input->post('menuname');              
                $shortcode  = "";
                $shortcode  = str_replace(' ','_',(strtolower($this->input->post('menuname'))));   

                $data['parent_id']  =   $this->input->post('parentlevel');
                $checkcontr         =   $this->input->post('checkc');
                $checkview          =   $this->input->post('checkv');

                if ($this->input->post('parentlevel') == "")
                {
                    $data['parent_id']  =  0;
                    $data['level']      =  0;    
                }

                $paradata1['select']    =   'level';
                $paradata1['table']     =   'menu';
                $paradata1['whereArr']  =   array('id' => $this->input->post('parentlevel'));
                $getData                =   $this->Common_Model->getParameters($paradata1);
                $level                  =   $getData->level;
               
               
                if ($checkcontr !='' && $checkview !='') 
                {
                    $link = str_replace(" ","_",ucfirst($this->input->post('menuname')));
                    
                }
                else
                {

                    $link = "#";
                }

                
                $data['link']          =   $link;
                $data['level']         =   $level + 1; 
                $data['m_status']      =   $this->input->post('m_status');
                $data['short_code']    =   $shortcode;
                $inset_id              =   $this->Common_Model->Save($data,'menu');

                if($inset_id !==0)
                {
                    if (($link) !=='#')
                    {
                    $Paradata['cname'] = $this->input->post('menuname');
                    $Paradata['vname'] = $this->input->post('menuname');
                    createControllerFile($Paradata);
                    createViewFile($Paradata);
                    }

                    $this->session->set_flashdata('checkdata', 'data saved successfully');
                    redirect('menu');
                }
                else
                {
                    $this->session->set_flashdata('checkdata', 'Some Thing Wrong');
                    redirect('menu');
                }
            }
        }  
        else
        {
            echo $this->session->set_flashdata('checkdata', 'Menu Name Already Exist');
//            redirect('menu');
        } 
    }
}
?>