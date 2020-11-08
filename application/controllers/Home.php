<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Common_Model","common");	
 	}
	
	public function index()
	{
		$para = array();
		$para['select'] 		= '*';
		$para['table'] 			= 'donation_type';
		$para['whereArr'] 		= array( "donation_type.is_status" => 1, "donation_type.is_deleted" => 0 );
		$data['donation_type']	= $this->common->getAllParameters($para);
			
		$this->load->view('vwHome',$data);
	}
	
	public function SaveDonation()
	{
		$name 				= (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
		$email 				= (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
		$phone 				= (isset($_POST['contact_no']) && !empty($_POST['contact_no'])) ? $_POST['contact_no'] : false;
		$contribution_type 	= (isset($_POST['contribution_type']) && !empty($_POST['contribution_type'])) ? $_POST['contribution_type'] : false;
		$amount 			= (isset($_POST['amount']) && !empty($_POST['amount'])) ? $_POST['amount'] : false;
						
		$reference_no 				= 'Txn-'.time().rand(111111,999999);
		
		$save_array['name'] 		= $name;
		$save_array['email'] 		= $email;
		$save_array['cell'] 		= $phone;
		$save_array['type_id'] 		= $contribution_type;
		$save_array['amount'] 		= $amount;
		$save_array['status'] 		= "Pending";
		$save_array['reference_no'] = $reference_no;
		
		$table 		= "donation";
		$lastId 	= $this->common->Save($save_array,$table);
		
		$donation_type_name = '';
		if(!empty($contribution_type))
		{
			$para = array();
			$para['select'] 		= 'type_name';
			$para['table'] 			= 'donation_type';
			$para['whereArr'] 		= array( "donation_type.id" => $contribution_type, "donation_type.is_status" => 1, "donation_type.is_deleted" => 0 );
			$donation_type			= $this->common->getParameters($para);
			
			$donation_type_name 	= (!empty($donation_type) && isset($donation_type->type_name)) ? $donation_type->type_name : false;
		}

		$success_url 		= base_url("Home/PaymentSuccessUrl");
		$failure_url 		= base_url("Home/PaymentFailureUrl");
		
		$key				= "UCbeHt";
		$salt 				= "sHko2aRi";
		$udf5 				= "BOLT_KIT_PHP7";
		$surl 				= $success_url;
		$furl 				= $failure_url;
		$txnid 				= $reference_no ;

	
		$hash				= hash('sha512', $key.'|'.$txnid.'|'.$amount.'|'.$donation_type_name.'|'.$name.'|'.$email.'|||||'.$udf5.'||||||'.$salt);
		
		$payParameter 						= array();
		$payParameter['key'] 				= $key;
		$payParameter['salt'] 				= $salt;
		$payParameter['udf5'] 				= $udf5;
		$payParameter['surl'] 				= $surl;
		$payParameter['furl'] 				= $furl;
		$payParameter['txnid'] 				= $txnid;
		$payParameter['name'] 				= $name;
		$payParameter['email'] 				= $email;
		$payParameter['phone'] 				= $phone;
		$payParameter['amount'] 			= $amount;
		$payParameter['hash'] 				= $hash;
		$payParameter['productinfo'] 		= $donation_type_name;
		
		$this->RequestforPayment($payParameter);
		
	}

	public function testpayment()
	{
		echo 'coming';
		exit(1);
		$success_url 		= base_url("Home/PaymentSuccessUrl");
		$failure_url 		= base_url("Home/PaymentFailureUrl");

		$key				= "UCbeHt";
		$salt 				= "sHko2aRi";
		$udf5 				= "BOLT_KIT_PHP7";
		$surl 				= $success_url;
		$furl 				= $failure_url;
		$txnid 				= "Txn-1601135887671852";
		$name 				= "fahad shafique";
		$email 				= "fahadshafique1994@gmail.com";
		$phone 				= "917760970971";
		$amount 			= "10";
		$donation_type_name = "Zakath";
	
		$hash				= hash('sha512', $key.'|'.$txnid.'|'.$amount.'|'.$donation_type_name.'|'.$name.'|'.$email.'|||||'.$udf5.'||||||'.$salt);
		
		$payParameter 						= array();
		$payParameter['key'] 				= $key;
		$payParameter['salt'] 				= $salt;
		$payParameter['udf5'] 				= $udf5;
		$payParameter['surl'] 				= $surl;
		$payParameter['furl'] 				= $furl;
		$payParameter['txnid'] 				= $txnid;
		$payParameter['name'] 				= $name;
		$payParameter['email'] 				= $email;
		$payParameter['phone'] 				= $phone;
		$payParameter['amount'] 			= $amount;
		$payParameter['hash'] 				= $hash;
		$payParameter['productinfo'] 		= $donation_type_name;
		
		$this->RequestforPayment($payParameter);
	}
	
	public function RequestforPayment($Paradata)
	{
		$data['data'] = $Paradata;
		$this->load->view('payumoney/index',$data);
	}
	
	public function PaymentSuccessUrl()
	{
		$flag 		= 'error';
		$title 		= 'Something went wrong.!';
		$message 	= '';
		
		$txnid 		= (isset($_POST['txnid']) && !empty($_POST['txnid'])) ? $_POST['txnid'] : false;
		$paraData 	= (isset($_POST) && !empty($_POST)) ? $_POST : false;
		if(!empty($paraData))
		{
			$output = $this->SavePaymentData($paraData);
			if(!empty($output))
			{
				$flag 		= 'success';
				$title 		= 'Thank you for Donation.!';
				$message 	= "Your Transaction ID : ".$txnid;
			}
		}
		
		$this->session->set_flashdata('flag', $flag);
		$this->session->set_flashdata('title', $title);
		$this->session->set_flashdata('message', $message);
		
		redirect('/');
	}
	
	public function PaymentFailureUrl()
	{
		$flag 		= 'error';
		$title 		= 'Something went wrong.!';
		$message 	= '';
		
		$txnid 		= (isset($_POST['txnid']) && !empty($_POST['txnid'])) ? $_POST['txnid'] : false;
		$paraData 	= (isset($_POST) && !empty($_POST)) ? $_POST : false;
		if(!empty($paraData))
		{
			$output = $this->SavePaymentData($paraData);
			if(!empty($output))
			{
				$flag 		= 'error';
				$title 		= 'Payment Failed';
				$message 	= "Your Transaction ID : ".$txnid;
			}
		}
		
		$this->session->set_flashdata('flag', $flag);
		$this->session->set_flashdata('title', $title);
		$this->session->set_flashdata('message', $message);
		
		redirect('/');
	}
	
	public function SavePaymentData($data)
	{
		$output 		= false;
		$txnid 			= (isset($data['txnid']) && !empty($data['txnid'])) ? $data['txnid'] : false;
		$save_array 	= array();
		if(!empty($txnid))
		{
			$table 					= "donation";
			$para 					= array();
			$para['select'] 		= 'id';
			$para['table'] 			= $table;
			$para['whereArr'] 		= array( "donation.reference_no" => $txnid );
			$donation_data			= $this->common->getParameters($para);
			
			$donation_id 			= (!empty($donation_data) && isset($donation_data->id)) ? $donation_data->id : false;
			if(!empty($donation_id))
			{
				$save_array['donation_id'] 			= $donation_id;
				$save_array['txnid'] 				= $txnid;
				$status 							= (isset($data['status']) && !empty($data['status'])) ? $data['status'] : false;
				$save_array['bankcode']				= (isset($data['bankcode']) && !empty($data['bankcode'])) ? $data['bankcode'] : false;
				$save_array['discount'] 			= (isset($data['discount']) && !empty($data['discount'])) ? $data['discount'] : false;
				$save_array['hash']					= (isset($data['hash']) && !empty($data['hash'])) ? $data['hash'] : false;
				$save_array['status'] 				= $status;
				$save_array['isConsentPayment']		= (isset($data['isConsentPayment']) && !empty($data['isConsentPayment'])) ? $data['isConsentPayment'] : false;
				$save_array['error'] 				= (isset($data['error']) && !empty($data['error'])) ? $data['error'] : false;
				$save_array['addedon']				= (isset($data['addedon']) && !empty($data['addedon'])) ? $data['addedon'] : false;
				$save_array['encryptedPaymentId']	= (isset($data['encryptedPaymentId']) && !empty($data['encryptedPaymentId'])) ? $data['encryptedPaymentId'] : false;
				$save_array['bank_ref_num']			= (isset($data['bank_ref_num']) && !empty($data['bank_ref_num'])) ? $data['bank_ref_num'] : false;
				$save_array['payuMoneyId'] 			= (isset($data['payuMoneyId']) && !empty($data['payuMoneyId'])) ? $data['payuMoneyId'] : false;
				$save_array['mihpayid']				= (isset($data['mihpayid']) && !empty($data['mihpayid'])) ? $data['mihpayid'] : false;
				$save_array['name_on_card']			= (isset($data['name_on_card']) && !empty($data['name_on_card'])) ? $data['name_on_card'] : false;
				$save_array['txnStatus']			= (isset($data['txnStatus']) && !empty($data['txnStatus'])) ? $data['txnStatus'] : false;
				$save_array['txnMessage']			= (isset($data['txnMessage']) && !empty($data['txnMessage'])) ? $data['txnMessage'] : false;
				$api_response						= (isset($data) && !empty($data)) ? $data : false;
				$save_array['api_response']			= json_encode($api_response);
				
				$payment_table 	= "payments";
				$lastId 		= $this->common->Save($save_array,$payment_table);
				
				$update_array['status']	= $status;
				$where 					= array( "id" => $donation_id );
				$this->common->update($update_array,$table,$where);
				
				$output = $lastId;
			}
		}
		
		return $output;
	}
	
}
