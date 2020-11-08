<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function GetSiteData()
{	
	$CI =& get_instance();
	$CI->load->model("Common_model","common");
		
	$para 				= array();
	$para['select'] 	= '*';
	$para['table'] 		= 'site_option';
	$data			 	= $CI->common->getParameters($para);
	return $data;
}

function calculateTimeDifference($date1)
{
	if($date1)
	{
		$date2 =  date('Y-m-d H:i:s') ;
		
		$datetime1 = new DateTime($date2);
		$datetime2 = new DateTime($date1);
		$interval = $datetime2->diff($datetime1);
		
		$data['hours']	= $interval->format('%h');		
		$data['minutes']	= $interval->format('%i');		
		$data['seconds']	= $interval->format('%s');		
		
		return $data;
	}
	else
	{
		return false;
	}

}

function create_csrfinput()
{
	$CI =& get_instance();
	$csrf = array(
		'name' => $CI->security->get_csrf_token_name(),
		'hash' => $CI->security->get_csrf_hash()
	);
							
	$input = '<input type="hidden" name="'.$csrf['name'].'" value="'.$csrf['hash'].'" />';
	return $input;
}

function setExcelDateExcludeTiming($date)
{
	$time = strtotime($date);
	$final_date = floor($time/86400)*86400;		
	return $final_date;
}

function download($data)
{	
	$path 				= (!empty($data) && isset($data['path'])) ? $data['path'] : '';
	$uniqueFileName 	= (!empty($data) && isset($data['uniqueFileName'])) ? $data['uniqueFileName'] : '';
	$originalFileName 	= (!empty($data) && isset($data['originalFileName'])) ? $data['originalFileName'] : '';
	
	if(!empty($path))
	{
		$path .='/'. $uniqueFileName;
		if(file_exists ($path ))
		{	
			$file = fopen($path,"r");
			$content=fread($file,filesize($path));
			fclose($file);
				
			$size = strlen($content);
			header('Content-Type: application/octet-stream');
			header('Content-Length: '.$size);
			header('Content-Disposition: attachment; filename='.$uniqueFileName);
			header('Content-Transfer-Encoding: binary');
			echo $content;
			//@unlink($path);
		 exit;
		}
	} 
}

function debug($data,$flag = true)
{
	echo "<pre>"; print_r($data); echo "</pre>"; 
	if($flag)
		die;
}
		
function GetMenuData($check = false)
{	
	$CI =& get_instance();
	$CI->load->model("Common_model","common");
		
	$para 				= array();
	$para['select'] 	= '*';
	$para['table'] 		= 'menu';
	$para['whereArr'] 	= array( 'is_deleted' => 0, 'm_status' => 1 );
	if($check)
		$para['whereArr']['is_superadmin'] = 0;
	
	$data			 	= $CI->common->getAllParameters($para);
	return $data;
}

function GetAllPermissions()
{	
	$Permissions = array();
	$CI =& get_instance();
	$CI->load->model("Common_model","common");
		
	$para 					= array();
	$para['select'] 		= 'permissions.*,menu.short_code';
	$para['table'] 			= 'permissions';
	$para['whereArr'] 		= array( 'permissions.is_status' => 1 , 'permissions.is_deleted' => 0 );
	
							  $CI->db->join("menu"," menu.id = permissions.menu_id","inner");
	$data			 		= $CI->common->getAllParameters($para);
	if(!empty($data))
	{
		foreach($data as $index => $single)
		{
			$Permissions[$single->short_code][] = $single;
		}
	}
	return $Permissions;	
}

function GetUserPermissions()
{
	$CI =& get_instance();
	$CI->load->model("Common_model","common");

	$permissions = array();
	$uid = $CI->session->userdata('uid');
	if(!empty($uid))
	{
		$para = array();
		$para['select'] 	= '*';
		$para['table'] 		= 'roles';
		$para['whereArr'] 	= array( 'user.id' => $uid, "roles.role_status" => 1, "roles.is_deleted" => 0 );
							  $CI->db->join("user","user.role_id = roles.id","inner");
		$roleUserData		= $CI->common->getParameters($para);
		$permissions 		= (!empty($roleUserData) && !empty($roleUserData->role_permission_array)) ? json_decode($roleUserData->role_permission_array) : false;
	}
	
	return $permissions;
}

function UploadFile($data)
{
	$reponse = array();
	$reponse['uploadstatus'] 	= false;
	$reponse['message'] 		= "Something went wrong";	
	$reponse['filetype'] 		= false;
	$reponse['filesize'] 		= false;
	$reponse['unique_filename'] = false;
	$reponse['actual_filename'] = false;
					
	if (isset($data['name']) && $data['name'] != "") {
			
		$file_name 		 	= $data['name'];
		$file_size 		 	= $data['size'];
		$file_tmp  		 	= $data['tmp_name'];
		$file_type 		 	= $data['type'];
		$file_type_array	= explode('/',$file_type);
		$filetype			= (!empty($file_type_array) && isset($file_type_array[0])) ? $file_type_array[0] : false;
		$file_ext_array  	= explode('.', $file_name);
		$file_ext 		 	= (!empty($file_ext_array) && isset($file_ext_array[1])) ? strtolower($file_ext_array[1]) : false;
		
		$fileformatArray 	= "";
		if(!empty($filetype))
		{
			if($filetype == "image")
				$fileformatArray 	= Allow_Only_Img;
			else if($filetype == "application")
				$fileformatArray 	= Allow_Only_Doc;
		}
		

		if(!empty($fileformatArray) && !empty($file_ext))
		{
			if (in_array($file_ext, $fileformatArray))
			{
				$uniquefilename = round(microtime(true)).rand(1000,9999) . '.' . $file_ext;
				if(move_uploaded_file($file_tmp, ABS_UPLOAD_DIR . $uniquefilename))
				{
					$reponse['filetype'] 		= $file_type;
					$reponse['filesize'] 		= $file_size;
					$reponse['uploadstatus'] 	= true;
					$reponse['message'] 		= "File Successfully Uploaded";
					$reponse['unique_filename'] = $uniquefilename;
					$reponse['actual_filename'] = $file_name;
				}
			}
		}
	}
	
	return $reponse;
	
}

if (!function_exists('array_key_first')) {
	function array_key_first(array $array){
		if (count($array)) {
			reset($array);
			return key($array);
		}
		return null;
	}
}

if( !function_exists('local_to_mysql()'))
{
	function local_to_mysql($date){
		return date('Y-m-d', strtotime(str_replace('-', '/', $date)));
	}
}

if( !function_exists('mysql_to_local()'))
{
	function mysql_to_local($date){
		return date('m-d-y', strtotime(str_replace('-', '/', $date)));
	}
}
 
?>
