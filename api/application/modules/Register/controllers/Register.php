<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Register extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Register_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}

	public function skillsData()
	{

		$data=$this->Register_model->getAllCourseKey();
		echo json_encode($data);
	}

	// ** open learner register //
	public function learner_Register()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
					
		if ($post_user) 
		{	
			$smtpDetails = getSmtpDetails(); //get smtp details 
			$result = $this->Register_model->learner_Register($post_user);
			if($result)
			{
			
				$userId=$result;
				$data['UserId']=$userId;
				
				$res=new stdClass();
				$res->loginUrl = ''.BASE_URL.'/user-activation/'.JWT::encode($data,"MyGeneratedKey","HS256").'';
				$EmailToken = 'Open Invitation';
				$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
				$body = $EmailDetails['EmailBody'];
				$FormattedBody = getFormattedBody($res ,$body);
				
				// send email particular email
				$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
				
				echo json_encode($userId);
								
							
			}	
			else
			{
				echo json_encode('email duplicate');
			}
		}
	}




	 // ** check alrady register user or not //
		public function alrady_learner_Register()
		{
			$post_user = json_decode(trim(file_get_contents('php://input')), true);
						
			if ($post_user) 
			{	
				$result = $this->Register_model->alrady_learner_Register($post_user);
				if($result)
				{
						echo json_encode('Success');
												
				}	
				else
				{
						echo json_encode('email duplicate');
				}
			}
		}
	

		// ** Education List //
	public function getlist_EducationLevel() {
		
		$data=$this->Register_model->getlist_EducationLevel();	

		echo json_encode($data);
				
	}



	// ** check link  user active //
	public function userActive()
	{				
	$post_user = json_decode(trim(file_get_contents('php://input')), true);		
	if ($post_user)
		{
			if($post_user['UserId']>0)
			{
				$smtpDetails = getSmtpDetails(); //get smtp details 
				$result = $this->Register_model->reset_passlink2($post_user);
				
				if($result)
				{
					$userId=$post_user['UserId'];
					$res=new stdClass();
					$res->loginUrl = BASE_URL.'/login/';
					$this->db->select('us.FirstName,us.LastName,us.EmailAddress,us.RoleId,us.CreatedBy,role.RoleName');
					$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
					$this->db->where('us.UserId',$userId);
					$smtp2 = $this->db->get('tbluser us');	
					foreach($smtp2->result() as $row) {
						$res->FirstName = $row->FirstName;
						$res->LastName = $row->LastName;
						$res->EmailAddress = $row->EmailAddress;
						$res->RoleName = $row->RoleName;
					}

					$EmailToken = 'Registration Complete';
					$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
					$body = $EmailDetails['EmailBody'];
				
					$FormattedBody = getFormattedBody($res ,$body);
					
					// send email to particular email
                    $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					echo json_encode('Success');
				}	
				else
				{
					
					echo json_encode('fail');
				}
			}						
		}
	
	}

}
