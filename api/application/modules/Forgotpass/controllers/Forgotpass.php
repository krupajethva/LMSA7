<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Forgotpass extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Forgotpass_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}
	
	public function test(){
		echo 'sdfsdf'.BASE_URL.'/resetpass/';
	}

	
	// forgot password //
	public function userpass()
		{				 		
		$post_pass = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_pass)
			{
				$post_pass['ResetPasswordCode']=mt_rand(100000, 999999);
				$smtpDetails = getSmtpDetails(); //get smtp details 
                
				$result = $this->Forgotpass_model->forgot_pass($post_pass);
				if($result)
				{	
					$userId=$result;
					$data['UserId']=$userId;
					$data['ResetPasswordCode']=$post_pass['ResetPasswordCode'];
					$data['EmailAddress']=$post_pass['EmailAddress'];
					$res=new stdClass();
					$res->loginUrl = ''.BASE_URL.'/reset-password/'.JWT::encode($data,"MyGeneratedKey","HS256").'';
					$EmailToken = 'Forgot Password';
					$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
					$body = $EmailDetails['EmailBody'];
                    $FormattedBody = getFormattedBody($res ,$body);
					
					// send email to particular email
                    $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
				 	echo json_encode('Success');
				}	
				else
				{
					
					echo json_encode("Code duplicate");
				}
										
		}
		
	}
	


	
	
	
	
}
