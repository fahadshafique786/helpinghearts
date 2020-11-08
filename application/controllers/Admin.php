<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	 
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('log_in') !==TRUE){
			redirect('login');
		}
		
		if ($this->session->userdata('type') != "admin"){
			$this->not_found_page();
		}
	
		$this->load->model("Common_Model","common");
		$this->permissionData = GetUserPermissions();
    }
	
	public function not_found_page()
	{
		$this->load->view('layouts/not_found_page');
	}
	
	public function UploadImgOnly($data)
	{
		$reponse = array();
		$reponse['uploadstatus'] 	= false;
		$reponse['message'] 		= "Something went wrong";	
		$reponse['filetype'] 		= false;
		$reponse['filesize'] 		= false;
		$reponse['unique_filename'] = false;
		$reponse['actual_filename'] = false;
						
		if (isset($data['name']) && $data['name'] != "") {
                
			$file_name 		 = $data['name'];
			$file_size 		 = $data['size'];
			$file_tmp  		 = $data['tmp_name'];
			$file_type 		 = $data['type'];
			$file_ext_array  = explode('.', $file_name);
			$file_ext 		 = (!empty($file_ext_array) && isset($file_ext_array[1])) ? strtolower($file_ext_array[1]) : false;
			$fileformatArray = Allow_Only_Img;

			if(!empty($fileformatArray) && !empty($file_ext))
			{
				if (in_array($file_ext, $fileformatArray))
				{
					
					$file_type_array = explode('/',$file_type);
					$filetype = (!empty($file_type_array) && isset($file_type_array[0])) ? $file_type_array[0] : false;
					$newfilename = round(microtime(true)).rand(1000,9999) . '.' . $file_ext;
					if(move_uploaded_file($file_tmp, ABS_UPLOAD_DIR . $newfilename))
					{
						$reponse['filetype'] 		= $file_type;
						$reponse['filesize'] 		= $file_size;
						$reponse['uploadstatus'] 	= true;
						$reponse['message'] 		= "File Successfully Uploaded";
						$reponse['unique_filename'] = $newfilename;
						$reponse['actual_filename'] = $file_name;
					}
				}
			}
		}
		
		return $reponse;
		
	}
	
	public function IsExistCheck($data)
	{
		$parameter = array();
		$parameter['select'] 	= (isset($data['select']) && !empty($data['select'])) ? $data['select'] : false;
		$parameter['table'] 	= (isset($data['table']) && !empty($data['table'])) ? $data['table'] : false;
		$parameter['whereArr'] 	= (isset($data['whereArr']) && !empty($data['whereArr'])) ? $data['whereArr'] : false;
		$reponse 				= $this->common->getParameters($parameter);
		
		return $reponse;
	}

	public function index()
	{
		$access = (!empty($this->permissionData) && isset($this->permissionData)) ? explode("_",array_key_first((Array)$this->permissionData))[0] : false;
		if(!empty($access))
			redirect('admin/'.$access);
		else
			$this->not_found_page();	
	}
	
	public function dashboard()
	{
		$link_short_code = "dashboard_view";
		if(isset($this->permissionData->$link_short_code))
			$this->load->view('admin/vwDashboard');
		else
			$this->not_found_page();
	}
	
	public function siteConfig()
	{
		$link_short_code = "siteConfig_view";
		if(isset($this->permissionData->$link_short_code))
		{
			$parameter = array();
			$parameter['select'] 	= '*';
			$parameter['table'] 	= 'site_option';
			$parameter['whereArr'] 	= array( 'id' => 1 );
			$data['site_data'] 		= $this->common->getParameters($parameter);
			$this->load->view('admin/vwSiteConfig',$data);
		}
		else
			$this->not_found_page();
	}
	
	public function saveSiteConfig()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		$name 			= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		$email 			= (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
		$phone 			= (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : false;
		$title 			= (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : false;
		$company 		= (isset($_POST['company']) && !empty($_POST['company'])) ? $_POST['company'] : false;
		$site_url 		= (isset($_POST['site_url']) && !empty($_POST['site_url'])) ? $_POST['site_url'] : false;
		$site_color 	= (isset($_POST['site_color']) && !empty($_POST['site_color'])) ? $_POST['site_color'] : false;
		$gc_img_url 	= (isset($_POST['gc_img_url']) && !empty($_POST['gc_img_url'])) ? $_POST['gc_img_url'] : false;
		$footer_note 	= (isset($_POST['footer_note']) && !empty($_POST['footer_note'])) ? $_POST['footer_note'] : false;
		$address 		= (isset($_POST['address']) && !empty($_POST['address'])) ? $_POST['address'] : false;
		
		$site_log 		= $_FILES['site_log'];
		$site_favicon 	= $_FILES['site_favicon'];
		$gc_img 		= $_FILES['gc_img'];
		
		$site_log_data 		= $this->UploadImgOnly($site_log);
		$site_favicon_data 	= $this->UploadImgOnly($site_favicon);
		$gc_img_data 		= $this->UploadImgOnly($gc_img);
				
		$save_array['s_name'] 				= $name;
		$save_array['email'] 				= $email;
		$save_array['phone'] 				= $phone;
		$save_array['title'] 				= $title;
		$save_array['company'] 				= $company;
		$save_array['link'] 				= $site_url;
		$save_array['color_code'] 			= $site_color;
		$save_array['footer_note'] 			= $footer_note;
		$save_array['address'] 				= $address;
		
		if($site_log_data['uploadstatus'])
			$save_array['logo'] 				= $site_log_data['unique_filename'];
		
		if($site_favicon_data['uploadstatus'])
			$save_array['favicon'] 				= $site_favicon_data['unique_filename'];
		
		if($gc_img_data['uploadstatus'])
		{
			$save_array['gc_img_actual_name']	= $gc_img_data['actual_filename'];
			$save_array['gc_img_unique_name'] 	= $gc_img_data['unique_filename'];
		}
		
		$save_array['gc_img_url'] 			= $gc_img_url;
		$save_array['updated_by'] 			= $this->session->userdata('uid');
		
		$table = "site_option";
		if(!empty($pri_id))
		{
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}else{
			$save_array['created_by'] 		= $this->session->userdata('uid');
			$this->common->Save($save_array,$table);
		}
		
		redirect('admin/siteConfig');
	
	}
	
	public function pageConfig()
	{
		$link_short_code = "pageConfig_view";
		if(isset($this->permissionData->$link_short_code))
			$this->load->view('admin/vwPagesConfig');
		else
			$this->not_found_page();
	}
	
	public function showPageConfig()
	{	
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->PageConfigDataFilter($whereArray,true);
			
						$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->PageConfigDataFilter($whereArray,false);

			$data = array();

			$output1 = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$edit_access = false;
				$short_code = "pageConfig_edit";
				if(isset($this->permissionData->$short_code))
					$edit_access = true;
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$i++;
					$p_description = ( !empty($single->p_description)) ? mb_strimwidth($single->p_description, 0, 30, '...') : $single->p_description;
							
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->p_name;
					$row[] = $single->p_flag;
					$row[] = $single->p_banner_text;
					$row[] = '<a href="'.UPLOAD_DIR.$single->p_banner_img_name.'" target="_blank">View Banner</a>';
					$row[] = $single->p_banner_img_url;					
					$row[] = '<span class="" title="'.$single->p_description.'">'.$p_description.'</span>';
					
					$action_button = '';
					if($edit_access)
						$action_button = '<button class="btn btn-primary" type="button" data-id="'.$single->id.'" onclick="editpage(this)"> <i class="fa fa-edit"></i></button>';
					
					$row[] = $action_button;
					
					$data[] = $row;
					
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}
	
	public function savePageConfig()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		$name 			= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		$bnr_img_url 	= (isset($_POST['bnr_img_url']) && !empty($_POST['bnr_img_url'])) ? $_POST['bnr_img_url'] : false;
		$bnr_text 		= (isset($_POST['bnr_text']) && !empty($_POST['bnr_text'])) ? $_POST['bnr_text'] : false;
		$description 	= (isset($_POST['description']) && !empty($_POST['description'])) ? $_POST['description'] : false;

		$bnr_img 		= $_FILES['bnr_img'];
		
		$bnr_img_data 	= $this->UploadImgOnly($bnr_img);
				
		$save_array['p_name'] 			= $name;
		$save_array['p_banner_img_url'] = $bnr_img_url;
		$save_array['p_banner_text'] 	= $bnr_text;
		$save_array['p_description'] 	= $description;
		
		if($bnr_img_data['uploadstatus'])
		{
			$save_array['p_banner_img_actual_name']	= $bnr_img_data['actual_filename'];
			$save_array['p_banner_img_name'] 		= $bnr_img_data['unique_filename'];
		}
		
		$save_array['updated_by'] 			= $this->session->userdata('uid');
		
		$table = "page_option";
		if(!empty($pri_id))
		{
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}else{
			$save_array['created_by'] 		= $this->session->userdata('uid');
			$this->common->Save($save_array,$table);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Saved"
		));
		die;
		
	}

	public function editPageConfig()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$parameter = array();
			$parameter['select'] = '*';
			$parameter['table'] = 'page_option';
			$parameter['whereArr'] = array( 'id' => $pri_id );
			$data = $this->common->getParameters($parameter);
		}
		
		echo json_encode($data);
		die;
	}
	
	public function userRequest()
	{
		$link_short_code = "userRequest_view";
		if(isset($this->permissionData->$link_short_code))
			$this->load->view('admin/vwUserRequest');
		else
			$this->not_found_page();
	}
	
	public function showUserRequests()
	{		
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->UserRequestDataFilter($whereArray,true);
			
						$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->UserRequestDataFilter($whereArray,false);

			$data = array();

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$edit_access = false;
				$delete_access = false;
				$edit_short_code = "userRequest_edit";
				$delete_short_code = "userRequest_delete";
				if(isset($this->permissionData->$edit_short_code))
					$edit_access = true;
				if(isset($this->permissionData->$delete_short_code))
					$delete_access = true;
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$i++;
					$address 	= ( !empty($single->address)) ? mb_strimwidth($single->address, 0, 30, '...') : $single->address;
					$status 	= (!empty($single->is_status)) ? "Active" : "In-Active";
							
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->u_name;
					$row[] = $single->email;
					$row[] = $single->phone;
					$row[] = $status;
					$row[] = $single->amount;
					$row[] = '<a href="'.UPLOAD_DIR.$single->IDcard_unique_name.'" target="_blank">View</a>';
					$row[] = '<a href="'.UPLOAD_DIR.$single->document_unique_name.'" target="_blank">View</a>';					
					$row[] = '<span class="" title="'.$single->address.'">'.$address.'</span>';
					
					$action_button = '';
					if($edit_access)
						$action_button .= '<button class="btn btn-primary" type="button" data-id="'.$single->id.'" onclick="edituserRequest(this)"> <i class="fa fa-edit"></i></button>';
					
					if($delete_access)
						$action_button .= '<button class="btn btn-danger" type="button" data-id="'.$single->id.'" onclick="deleteuserRequest(this)"> <i class="fa fa-trash"></i></button>';
					
					$row[] = $action_button;

					$data[] = $row;
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}
	
	public function saveUserRequest()
	{
		exit(1);
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		$name 			= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		$email 			= (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
		$phone 			= (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : false;
		$status_id 		= (isset($_POST['status_id']) && !empty($_POST['status_id'])) ? $_POST['status_id'] : false;
		$vndr_img_url 	= (isset($_POST['vndr_img_url']) && !empty($_POST['vndr_img_url'])) ? $_POST['vndr_img_url'] : false;
		$address 		= (isset($_POST['address']) && !empty($_POST['address'])) ? $_POST['address'] : false;
		
		$vndr_img 		= $_FILES['vndr_img'];
		
		$vndr_img_data 	= $this->UploadImgOnly($vndr_img);
				
		$save_array['c_name'] 		= $name;
		$save_array['c_email'] 		= $email;
		$save_array['c_phone'] 		= $phone;
		$save_array['c_status'] 	= $status_id;
		$save_array['c_img_url'] 	= $vndr_img_url;
		$save_array['c_address'] 	= $address;
		
		if($vndr_img_data['uploadstatus'])
		{
			$save_array['c_img_actual_name']	= $vndr_img_data['actual_filename'];
			$save_array['c_img_unique_name'] 	= $vndr_img_data['unique_filename'];
		}
		
		$save_array['updated_by'] 			= $this->session->userdata('uid');
		
		$table = "requests";
		if(!empty($pri_id))
		{
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}else{
			$save_array['created_by'] 		= $this->session->userdata('uid');
			$this->common->Save($save_array,$table);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Saved"
		));
		die;
		
	}

	public function editUserRequest()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$parameter = array();
			$parameter['select'] = '*';
			$parameter['table'] = 'requests';
			$parameter['whereArr'] = array( 'id' => $pri_id );
			$data = $this->common->getParameters($parameter);
		}
		
		echo json_encode($data);
		die;
	}

	public function deleteUserRequest()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$table = "requests";
			$save_array['is_deleted'] = 1;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Deleted"
		));
		die;
		
	}

	public function countries()
	{
		$link_short_code = "countries_view";
		if(isset($this->permissionData->$link_short_code))
			$this->load->view('admin/vwCountries');
		else
			$this->not_found_page();
	}
	
	public function showCountries()
	{
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->CountryDataFilter($whereArray,true);
			
						$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->CountryDataFilter($whereArray,false);

			$data = array();

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$edit_access = false;
				$delete_access = false;
				$edit_short_code = "countries_edit";
				$delete_short_code = "countries_delete";
				if(isset($this->permissionData->$edit_short_code))
					$edit_access = true;
				if(isset($this->permissionData->$delete_short_code))
					$delete_access = true;
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$ABS_flag_path = ABS_FLAG_DIR.$single->flag_img;
					if(file_exists($ABS_flag_path))
						$flag_path = FLAG_PATH_DIR.$single->flag_img;
					else
						$flag_path = FLAG_PATH_DIR."default.png";
					
					$i++;
					$checked 	= (!empty($single->is_status)) ? "checked" : "";
					$status 	= '<label class="switch"><input type="checkbox" name="status" id="status" '.$checked.' data-id="'.$single->id.'" onchange="updatecountry(this)"><span class="slider round"></span></label>';
							
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->nicename;
					$row[] = $single->phonecode;
					$row[] = "<img src='".$flag_path."' width='70px' height='50px'>";
					
					$action_button = '';
					if($edit_access)
						$row[] = $status;
					else
						$row[] = (!empty($single->is_status)) ? "Active" : "In-Active";
					
					if($delete_access)
						$action_button .= '<button class="btn btn-danger" type="button" data-id="'.$single->id.'" onclick="deletecountry(this)"> <i class="fa fa-trash"></i></button>';
					
					$row[] = $action_button;
				
					$data[] = $row;
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}

	public function updateCountry()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		
		$status = 0;
		if(isset($_POST['status']) && !empty($_POST['status']))
		{
			if($_POST['status'] != "false")
				$status = 1;
		} 
		
		if(!empty($pri_id))
		{
			$table = "countries";
			$save_array['is_status'] = $status;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Updated"
		));
		die;
	}

	public function deleteCountry()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$table = "countries";
			$save_array['is_deleted'] = 1;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Deleted"
		));
		die;
		
	}
		
	public function roles()
	{
		$this->load->view('admin/vwRoles');
	}
	
	public function showRoles()
	{		
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->RoleDataFilter($whereArray,true);
			
						$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->RoleDataFilter($whereArray,false);

			$data = array();

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$i++;
					$status 	= (!empty($single->role_status)) ? "Active" : "In-Active";
							
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->role_name;
					$row[] = '<a href="javascript:void(0)" data-id="'.$single->id.'" onclick="showrole(this)" >View Permissions</a>';
					$row[] = $status;
					$row[] = '<button class="btn btn-primary" type="button" data-id="'.$single->id.'" onclick="editrole(this)"> <i class="fa fa-edit"></i></button> 
					<button class="btn btn-danger" type="button" data-id="'.$single->id.'" onclick="deleterole(this)"> <i class="fa fa-trash"></i></button>';

					$data[] = $row;
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}
		
	public function saveRole()
	{	
		$table 				= "roles";
		$pri_id 			= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		$name 				= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		
		$checkWhere['role_name'] = trim($name);
		if(!empty($pri_id))
			$checkWhere['id !='] = $pri_id;
		
		$para['select'] 	= 'id';
		$para['table'] 		= $table;
		$para['whereArr'] 	= $checkWhere;
		$check = $this->IsExistCheck($para);
		if(!empty($check))
		{
			echo json_encode(array(
				'status' => false,
				'msg' => "Your Rule Name already Exist"
			));
			die;
		}
		
		$status_id 			= (isset($_POST['status_id']) && !empty($_POST['status_id'])) ? $_POST['status_id'] : false;
		$permission 		= (isset($_POST['permission']) && !empty($_POST['permission'])) ? $_POST['permission'] : false;
		$permissionJSON 	=  json_encode($permission);
				
		$save_array['role_name'] 				= $name;
		$save_array['role_status'] 				= $status_id;
		$save_array['role_permission_array']	= $permissionJSON;
		$save_array['updated_by'] 				= $this->session->userdata('uid');
		
		if(!empty($pri_id))
		{
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}else{
			$save_array['created_by'] 		= $this->session->userdata('uid');
			$this->common->Save($save_array,$table);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Saved"
		));
		die;
	}

	public function editRole()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$parameter = array();
			$parameter['select'] = '*';
			$parameter['table'] = 'roles';
			$parameter['whereArr'] = array( 'id' => $pri_id );
			$data = $this->common->getParameters($parameter);
		}
		
		echo json_encode($data);
		die;
	}

	public function deleteRole()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$table = "roles";
			$save_array['is_deleted'] = 1;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Deleted"
		));
		die;
		
	}

	public function users()
	{
		$link_short_code = "users_view";
		if(isset($this->permissionData->$link_short_code))
		{
			$parameter = array();
			$parameter['select'] 	= '*';
			$parameter['table'] 	= 'roles';
			$parameter['whereArr'] 	= array( 'role_status' => 1, 'is_deleted' => 0 );
			$data['role_data']		= $this->common->getAllParameters($parameter);

			$this->load->view('admin/vwUsers',$data);
		}
		else
			$this->not_found_page();
	}

	public function showUsers()
	{		
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->UserDataFilter($whereArray,true);
			
						$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->UserDataFilter($whereArray,false);

			$data = array();

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$edit_access = false;
				$delete_access = false;
				$edit_short_code = "users_edit";
				$delete_short_code = "users_delete";
				if(isset($this->permissionData->$edit_short_code))
					$edit_access = true;
				if(isset($this->permissionData->$delete_short_code))
					$delete_access = true;
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$i++;
					$status 	= (!empty($single->u_status)) ? "Active" : "In-Active";
							
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->u_name;
					$row[] = $single->user_name;
					$row[] = $single->u_email;
					$row[] = $single->role_name;
					$row[] = $status;
					
					$action_button = '';
					if($edit_access)
						$action_button .= '<button class="btn btn-primary" type="button" data-id="'.$single->id.'" onclick="edituser(this)"><i class="fa fa-edit"></i></button>';
					
					if($delete_access)
						$action_button .= '  <button class="btn btn-danger" type="button" data-id="'.$single->id.'" onclick="deleteuser(this)"><i class="fa fa-trash"></i></button>';
					
					$row[] = $action_button;
				
					$data[] = $row;
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}
		
	public function saveUser()
	{
		$table 				= "user";
		$pri_id 			= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		$uname 				= (isset($_POST['uname']) && !empty($_POST['uname'])) ? $_POST['uname'] : false;
		$email 				= (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
		
		$UserNameWhere['user_name'] = trim($uname);
		if(!empty($pri_id))
			$UserNameWhere['id !='] = $pri_id;
		
		$para['select'] 	= 'id';
		$para['table'] 		= $table;
		$para['whereArr'] 	= $UserNameWhere;
		$UserNamecheck 		= $this->IsExistCheck($para);
		if(!empty($UserNamecheck))
		{
			echo json_encode(array(
				'status' => false,
				'msg' => "Your User Name already Exist"
			));
			die;
		}
		
		$UserEmailWhere['u_email'] = trim($email);
		if(!empty($pri_id))
			$UserEmailWhere['id !='] = $pri_id;
		
		$para['select'] 	= 'id';
		$para['table'] 		= $table;
		$para['whereArr'] 	= $UserEmailWhere;
		$UserEmailcheck 	= $this->IsExistCheck($para);
		if(!empty($UserEmailcheck))
		{
			echo json_encode(array(
				'status' => false,
				'msg' => "Your User Email already Exist"
			));
			die;
		}
		
		$passCheck = true;
		if(!empty($pri_id))
			$passCheck = (isset($_POST['change_password'])) ? true : false;
		
		$name 		= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		$password 	= (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : false;
		$status_id 	= (isset($_POST['status_id']) && !empty($_POST['status_id'])) ? $_POST['status_id'] : false;
		$role_id 	= (isset($_POST['role_id']) && !empty($_POST['role_id'])) ? $_POST['role_id'] : false;
		$phone 		= (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : false;
				
		$save_array['u_name'] 		= trim($name);
		$save_array['u_email'] 		= trim($email);
		$save_array['user_name'] 	= trim($uname);
		
		if($passCheck)
			$save_array['password']		= md5($password);
		
		$save_array['role_id'] 		= $role_id;
		$save_array['u_status'] 	= $status_id;
		$save_array['phone']		= $phone;
		$save_array['updated_by']	= $this->session->userdata('uid');
		
		if(!empty($pri_id))
		{
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}else{
			$save_array['created_by'] 		= $this->session->userdata('uid');
			$this->common->Save($save_array,$table);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Saved"
		));
		die;
	}

	public function editUser()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$parameter = array();
			$parameter['select'] = '*';
			$parameter['table'] = 'user';
			$parameter['whereArr'] = array( 'id' => $pri_id );
			$data = $this->common->getParameters($parameter);
		}
		
		echo json_encode($data);
		die;
	}

	public function deleteUser()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$table = "user";
			$save_array['is_deleted'] = 1;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Deleted"
		));
		die;
		
	}

	public function donations()
	{
		$link_short_code = "donations_view";
		if(isset($this->permissionData->$link_short_code))
			$this->load->view('admin/vwvDonations');
		else
			$this->not_found_page();
	}
	
	public function showDonations()
	{		
		if($this->session->userdata('uid') == NULL)
		{
			$data = array();
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"iTotalDisplayRecords" => 0,
				"recordsFiltered" => 0,
				"iTotalRecords" => 0,
				"islogin" => 0
			);	
			$output["data"] = $data;
			echo json_encode($output);
			exit(1);
		}else{
			
			$starting_offset = $_POST['start'];
			$limit = $_POST['length'];

			$total_Data = 0;
			$datanew = array();
			$whereArray = array();
			
			$total_Data = $this->common->PaymentDataFilter($whereArray,true);
			
			$this->db->limit($limit, $starting_offset);
			$datanew = 	$this->common->PaymentDataFilter($whereArray,false);

			$data = array();

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"iTotalDisplayRecords" => 0,
				"iTotalRecords" => 0,
				"islogin" => 1
			);
			if(!empty($datanew)){
				
				$i = $starting_offset;
				foreach($datanew as $index => $single){
					
					$i++;
					$row = array();				
					$row["DT_RowClass"] = 'tr_row_'.$single->id;
					$row[] = $i;
					$row[] = $single->txnid;
					$row[] = $single->type_name;
					$row[] = ucwords($single->name);
					$row[] = $single->email;
					$row[] = $single->cell;
					$row[] = number_format($single->amount);
					$row[] = strtoupper($single->status);

					$data[] = $row;
				}
				
				$output["recordsFiltered"] = sizeof($data);
			}
		
			if(!empty($total_Data)){
				$output["recordsTotal"] = $total_Data;
				$output["iTotalDisplayRecords"] = $total_Data;
				$output["iTotalRecords"] = $total_Data;
			}
			
			$output["data"] = $data;

			echo json_encode($output);
			exit(1);			
		}	
	}

	public function updateOrder()
	{
		$data = array();
		$pri_id = (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		
		$status = 0;
		if(isset($_POST['status']) && !empty($_POST['status']))
		{
			if($_POST['status'] != "false")
				$status = 1;
		} 
		
		if(!empty($pri_id))
		{
			$table = "customers";
			$save_array['status'] = $status;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Updated"
		));
		die;
	}

	public function deleteOrder()
	{
		$pri_id 		= (isset($_POST['pri_id']) && !empty($_POST['pri_id'])) ? $_POST['pri_id'] : false;
		if(!empty($pri_id))
		{
			$table = "customers";
			$save_array['is_deleted'] = 1;
			$save_array['updated_by'] = $this->session->userdata('uid');
			$where = array( "id" => $pri_id );
			$this->common->update($save_array,$table,$where);
		}
		
		echo json_encode(array(
			'status' => true,
			'msg' => "Data Successfully Deleted"
		));
		die;
		
	}
}
