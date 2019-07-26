<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Instructor extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Instructor_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}
	
	
	
	 // ** Delete instructor //
	public function deleteUser() {
		$post_user = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_user)
		 {
			if($post_user){
				$result = $this->Instructor_model->delete_user($post_user);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}
	
	 // list all instructor users //
	public function getAllUserList()
	{
		$data=$this->Instructor_model->getlist_user();
		echo json_encode($data);	
	}

	// list all instructor certificates//
	public function getCertificateById($userId)
	{
		$data=$this->Instructor_model->getCertificateById($userId);
		echo json_encode($data);	
	}

	 // ** IsActive user instructor //
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$smtpDetails = getSmtpDetails(); //get smtp details 
			$result = $this->Instructor_model->isActiveChange($post_data);
			if($result) {
				$userId=$post_data['UserId'];
				if($post_data['IsActive'] == 1)
					$EmailToken = 'Activation of Instructor by Admin';
				else
					$EmailToken = 'Activation of Instructor by Admin'; //change that email token
				$res=new stdClass();
				$res->loginUrl = BASE_URL.'/login/';
				
				$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
				$body = $EmailDetails['EmailBody'];
                $FormattedBody = getFormattedBody($res ,$body);
				
				// send email to particular email
                $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
				echo json_encode("Success");		
		}
		else
		{
			echo json_encode('fail');
		}		
	}
}
	
}
