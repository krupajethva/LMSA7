<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class EditProfile extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
		$this->load->model('EditProfile_model');
	}

	


	// update user data //
	public function editprofileadmin()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);					
		if ($post_user) 
		{			
			$result = $this->EditProfile_model->edit_profile($post_user);
			
			if($result){
				$token = array(
					"UserId" => $post_user['UserId'],
					"RoleId" => $post_user['RoleId'],
					"InvitedByUserId" => $post_user['InvitedByUserId'],
					"EmailAddress" => $post_user['EmailAddress'],
					"FirstName" => $post_user['FirstName'],
					"LastName" => $post_user['LastName'],
					"ProfileImage" => $post_user['ProfileImage'],
				);

				$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
				$output['token'] = $jwt;
				echo json_encode($output);
			}
			else
			{
				echo json_encode('email duplicate');
			}					
		}
	}

	 // update education detail //
	public function updateEducationDetails()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);					
		if ($post_user) 
		{			
			$result = $this->EditProfile_model->updateEducationDetails($post_user);
			if($result){
				echo json_encode('success');
			}				
		}
	}

	// ** upload user image //
	public function uploadProfilePicture($UserId)
	{
		if($_FILES){
			if(isset($_FILES['ProfileImage']) && !empty($_FILES['ProfileImage'])){
				$fileName = $_FILES["ProfileImage"]["name"];
				$directoryName = "../src/assets/ProfilePhoto/" . $UserId . "/";
				$source_file = $_FILES["ProfileImage"]["tmp_name"];
				$target_file = $directoryName . $fileName;
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0755, true); //Create New folder if not exist
				}
				move_uploaded_file($source_file, $target_file);
			}
			echo json_encode('success');
		}
	}

	// ** upload signature //
	public function uploadSignature($UserId)
	{
		if($_FILES){
			if(isset($_FILES['Signature']) && !empty($_FILES['Signature'])){
				$fileName = $_FILES["Signature"]["name"];
				$directoryName = "../src/assets/Instructor/" . $UserId . "/Signature/";
				$source_file = $_FILES["Signature"]["tmp_name"];
				$target_file = $directoryName . $fileName;
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0755, true); //Create New folder if not exist
				}
				move_uploaded_file($source_file, $target_file);
			}
			echo json_encode('success');
		}else
		{
			echo json_encode('error');
		}
	}

		// // ** upload user certificate //
		// public function uploadFileCertificate()
		// {
		// 	if($_FILES){
		// 		if(isset($_FILES['Certificate']) && !empty($_FILES['Certificate'])){
		// 			move_uploaded_file($_FILES["Certificate"]["tmp_name"], "../src/assets/certificate/".$_FILES["Certificate"]["name"]);
		// 		}
		// 		echo json_encode('success');
		// 	}
		// }

	//	** upload user certificate //
		public function uploadFileCertificate($UserId)
		{
			$length = count($_FILES);
			if(!empty($length))
			{
				if($_FILES)
				{
					for($i=0; $i<$length; $i++)
					{
						if(isset($_FILES['Certificate'.$i]) && !empty($_FILES['Certificate'.$i]))
						{
							$fileName = $_FILES["Certificate".$i]["name"];
							$directoryName = "../src/assets/Instructor/" . $UserId . "/EducationCertificate/";
							$source_file = $_FILES["Certificate".$i]["tmp_name"];
							$target_file = $directoryName . $fileName;
							if(!is_dir($directoryName)){
								mkdir($directoryName, 0755, true); //Create New folder if not exist
							}
							move_uploaded_file($source_file, $target_file);
							//move_uploaded_file($_FILES["Certificate".$i]["tmp_name"], "../src/assets/certificate/".$_FILES["Certificate".$i]["name"]);	
						
						}
					}
							echo json_encode('success');		
				} else {
					//echo json_encode('error');
				}
				
			}		
		}

		//Delete User Certificate
		public function deleteCertificate() {
			$post_Certificate = json_decode(trim(file_get_contents('php://input')), true);		
	
			if ($post_Certificate)
			 {
				if($post_Certificate['id'] > 0){
					$result = $this->EditProfile_model->deleteCertificate($post_Certificate);
					if($result) {		
						unlink("../src/assets/certificate/".$post_Certificate['Name']);				
						echo json_encode("Delete successfully");
						}
				 }				
			} 			
		}

	  // User for Company country //
	public function getStateList($cid = NULL) {	
		if(!empty($cid)) {			
			$result = [];
			$result = $this->EditProfile_model->getStateList($cid);			
			echo json_encode($result);				
		}			
	}

	// use for user country //
	public function getStateListadd($country_id = NULL) {	
		if(!empty($country_id)) {			
			$result = [];
			$result = $this->EditProfile_model->getStateListadd($country_id);			
			echo json_encode($result);				
		}			
	}

	// all default data //
	public function getDefaultData() {
		
		$data['country']=$this->EditProfile_model->getlist_Country();
		$data['state']=$this->EditProfile_model->getlist_State();
		$data['industry']=$this->EditProfile_model->getlist_industrydata();
		$data['educationLevel']=$this->EditProfile_model->getlist_EducationLevel();
		$data['skills']=$this->EditProfile_model->getSkillList();
		echo json_encode($data);
				
	}

	 // get user id data //    
	public function getProfileById($user_id=null)
	{			
		if(!empty($user_id))
		{
			$data=[];
			$data['user']=$this->EditProfile_model->get_userdata($user_id);
			$data['company']=$this->EditProfile_model->get_companydata($user_id);
			//print_r($data['user']);			
			echo json_encode($data);
		}
	}


	// get education detail data  //
	public function getEducationDetail($user_id = NULL) {
		
		if (!empty($user_id)) {
			$data = [];		
			$data['EducationDetails'] = $this->EditProfile_model->get_Educationdetail($user_id);
			$data['EducationCertificates'] = $this->EditProfile_model->get_EducationCertificate($user_id);
			echo json_encode($data);			
		}
	}	


    // update company detail //
	public function updateCompany()
	{
		$post_company = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_company) 
		{			
			$result = $this->EditProfile_model->updateCompany($post_company);
			if($result){
				echo json_encode('success');
			}
			else
			{
				echo json_encode('error');
			}					
		}
	}

	// chnage pass user //
	public function changePassword()
	{								
		$post_pass = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_pass)
		{					
			$result = $this->EditProfile_model->change_password($post_pass);
			if($result){
				$userId=$post_pass['UserId'];
				$EmailToken = 'Change Password';
		
				$this->db->select('Value');
				$this->db->where('Key','EmailFrom');
				$smtp1 = $this->db->get('tblmstconfiguration');	
				foreach($smtp1->result() as $row) {
					$smtpEmail = $row->Value;
				}
				$this->db->select('Value');
				$this->db->where('Key','EmailPassword');
				$smtp2 = $this->db->get('tblmstconfiguration');	
				foreach($smtp2->result() as $row) {
					$smtpPassword = $row->Value;
				}
				$this->db->select('FirstName,LastName,EmailAddress');
				$this->db->where('UserId',$userId);
				$smtp2 = $this->db->get('tbluser');	
				foreach($smtp2->result() as $row) {
					$FirstName = $row->FirstName;
					$LastName = $row->LastName;
					$EmailAddress = $row->EmailAddress;
				}
		
				
				$config['protocol']=PROTOCOL;
				$config['smtp_host']=SMTP_HOST;
				$config['smtp_port']=SMTP_PORT;
				$config['smtp_user']=$smtpEmail;
				$config['smtp_pass']=$smtpPassword;
				
				$config['charset']='utf-8';
				$config['newline']="\r\n";
				$config['mailtype'] = 'html';							
				$this->email->initialize($config);
		
				$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
			
				foreach($query->result() as $row){ 
					if($row->To==5 || $row->To==4 || $row->To==3 ){
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
					$rowTo = $queryTo->result();
					$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					$body = $row->EmailBody;
				 
					if($row->BccEmail!=''){
						$bcc = $row->BccEmail.','.$row->totalbcc;
					} else {
						$bcc = $row->totalbcc;
					}
					$body = str_replace("{ email_address }",$EmailAddress,$body);
					$body = str_replace("{ first_name }",$FirstName,$body);
					$body = str_replace("{ last_name }",$LastName,$body);
					$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
					// $this->email->from($smtpEmail, 'LMS Admin');
					// $this->email->to($rowTo[0]->EmailAddress);		
					// $this->email->subject($row->Subject);
					// $this->email->cc($row->totalcc);
					// $this->email->bcc($bcc);
					// $this->email->message($body);
					// if($this->email->send())
					// {
					// 	$email_log = array(
					// 		'From' => trim($smtpEmail),
					// 		'Cc' => '',
					// 		'Bcc' => '',
					// 		'To' => trim($EmailAddress),
					// 		'Subject' => trim($row->Subject),
					// 		'MessageBody' => trim($body),
					// 	);	
					// 	$res = $this->db->insert('tblemaillog',$email_log);	
					// }else
					// {
					// 	//echo json_encode("Fail");
					// }
					$send = SendEmail($smtpEmail, $rowTo[0]->EmailAddress, $row->totalcc, $bcc, $row->Subject, $body);
				} 
				 else {
					$userId_ar = explode(',', $row->totalTo);			 
					foreach($userId_ar as $userId){
					   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
					   $rowTo = $queryTo->result();
					   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					   $body = $row->EmailBody;
					
					   $body = str_replace("{ email_address }",$EmailAddress,$body);
					$body = str_replace("{ first_name }",$FirstName,$body);
					$body = str_replace("{ last_name }",$LastName,$body);
					$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
					   $this->email->from($smtpEmail, 'LMS Admin');
					   $this->email->to($rowTo[0]->EmailAddress);		
					   $this->email->subject($row->Subject);
					   $this->email->cc($row->totalcc);
					   $this->email->bcc($row->BccEmail.','.$row->totalbcc);
					   $this->email->message($body);
					   if($this->email->send())
					   {
						$email_log = array(
							'From' => trim($smtpEmail),
							'Cc' => '',
							'Bcc' => '',
							'To' => trim($EmailAddress),
							'Subject' => trim($row->Subject),
							'MessageBody' => trim($body),
						);	
						$res = $this->db->insert('tblemaillog',$email_log);
					   }else
					   {
						   //echo 'fail';
					   }
				   }
				}
			}
			echo json_encode('success');
			}
			else
			{
				echo json_encode('wrong current password');
			}									
		}		
	}

}
