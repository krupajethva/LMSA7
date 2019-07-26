<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Resetpass extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reset_model');
	}
	
	  // add new password //
	public function resetuserpass()
		{
								
		$post_pass = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_pass)
			{
				$smtpDetails = getSmtpDetails();	
				$result = $this->Reset_model->reset_pass($post_pass);
				if($result)
				{
					$userId=$post_pass['UserId'];
					$EmailToken = 'Reset Password';
					$res=new stdClass();
					$res->loginUrl = BASE_URL . '/login/';
					$EmailDetails = getEmailDetails($EmailToken,$userId);
					$body = $EmailDetails['EmailBody'];
                    $FormattedBody = getFormattedBody($res ,$body);
                      
                    $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					echo json_encode('Success');
				}	
				else
				{
					echo json_encode('Code duplicate');
				}
										
		}
		
	}
	
		
		 // check link used or not //
		public function resetpasslink2()
		{				
		$post_passlink = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_passlink)
			{
				$result = $this->Reset_model->reset_passlink2($post_passlink);
				
				if($result)
				{
						echo json_encode('Success');
				}	
				else
				{
					
					echo json_encode('fail');
				}
										
			}
		
		}

	
	
	
	
	
	
}
