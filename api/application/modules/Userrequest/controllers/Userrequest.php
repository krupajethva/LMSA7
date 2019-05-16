<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Userrequest extends CI_Controller {

	public function __construct()
	{ 
		parent::__construct();
		$this->load->model('Userrequest_model');
	}
	
	public function addUser()
	{  
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
				if($post_user['UserId']>0)
				{
					$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
						$res = "";
						for ($i = 0; $i < 6; $i++) {
							$res .= $chars[mt_rand(0, strlen($chars)-1)];
						}
						
						$post_user['Code']= $res;
					$result = $this->Userrequest_model->edit_user($post_user);
					if($result)
					{
									$userId=$post_user['UserId'];
									//$EmailAddress=$post_user['EmailAddress'];
									//$EmailAddress=$result->EmailAddress;
									
									$EmailToken = 'User Invitation';
			
			
			
									
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
			
							
									$config['protocol']=PROTOCOL;
									$config['smtp_host']=SMTP_HOST;
									$config['smtp_port']=SMTP_PORT;
									$config['smtp_user']=$smtpEmail;
									$config['smtp_pass']=$smtpPassword;

									// $config['protocol']  = 'smtp';
									// $config['smtp_host'] = 'ssl://smtp.googlemail.com';
									// $config['smtp_port'] = '465';
									// $config['smtp_user']='myopeneyes3937@gmail.com';
									// $config['smtp_pass']='W3lc0m3@2018';
									
									$config['charset']='utf-8';
									$config['newline']="\r\n";
									$config['mailtype'] = 'html';							
									$this->email->initialize($config);
							
									$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1) AS totalbcc FROM tblemailtemplate AS et WHERE et.Token = '".$EmailToken."' && et.IsActive = 1");
									foreach($query->result() as $row){ 
										if($row->To==4){
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;
										// foreach($query1->result() as $row1){			
										// 	$query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmstcountry AS con ON tn.CountryId = con.CountryId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblcompany AS com ON tn.CompanyId = com.CompanyId LEFT JOIN tblmstindustry AS ind ON com.IndustryId = ind.IndustryId WHERE tn.UserId = '.$userId);
										// 	$result2 = $query2->result();
										// 	$body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body,$post_user['Code']);					
										// } 
										if($row->BccEmail!=''){
											$bcc = $row->BccEmail.','.$row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace('You are invited for LMS TOOL : '."{ code }",$body,$post_user['Code']);	
									//	$body = str_replace("{code}",$post_user['Code'],$body);				
										$this->email->from($smtpEmail, 'LMS Admin');
										$this->email->to($rowTo[0]->EmailAddress);		
										$this->email->subject($row->Subject);
										$this->email->cc($row->totalcc);
										$this->email->bcc($bcc);
										$this->email->message($body);
										if($this->email->send())
										{
											
											//echo json_encode("Success");
										}else
										{
											//echo json_encode("Fail");
										}
									}  else {
										$userId_ar = explode(',', $row->totalTo);			 
										foreach($userId_ar as $userId){
										   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
										   $rowTo = $queryTo->result();
										   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										   $body = $row->EmailBody;
										//    foreach($query1->result() as $row1){			
										// 	   $query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmstcountry AS con ON tn.CountryId = con.CountryId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblcompany AS com ON tn.CompanyId = com.CompanyId LEFT JOIN tblmstindustry AS ind ON com.IndustryId = ind.IndustryId WHERE tn.UserId = '.$userId_backup);
										// 	   $result2 = $query2->result();
										// 	   $body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
										//    } 
										$body = str_replace('You are invited for LMS TOOL : '."{ code }",$body,$post_user['Code']);	
										   $this->email->from($smtpEmail, 'LMS Admin');
										   $this->email->to($rowTo[0]->EmailAddress);		
										   $this->email->subject($row->Subject);
										   $this->email->cc($row->totalcc);
										   $this->email->bcc($row->BccEmail.','.$row->totalbcc);
										   $this->email->message($body);
										   if($this->email->send())
										   {
											  // echo 'success';
										   }else
										   {
											   //echo 'fail';
										   }
									   }
									}
								}
								echo json_encode('success');
								
						
					}
				}
				else
				{
					
					$result = $this->Userrequest_model->add_user($post_user); 
			
					if($result)
					{
						
							
						//$EmailAddress=$result->EmailAddress;
						$userId=$result;
						$userId_backup=$userId;
						$FirstName=$post_user['FirstName'];
						$LastName=$post_user['LastName'];
						$EmailAddress=$post_user['EmailAddress'];
						

						$EmailToken = 'User Send Request';



						
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

				
						$config['protocol']=PROTOCOL;
						$config['smtp_host']=SMTP_HOST;
						$config['smtp_port']=SMTP_PORT;
						$config['smtp_user']=$smtpEmail;
						$config['smtp_pass']=$smtpPassword;

						// $config['protocol']  = 'smtp';
						// $config['smtp_host'] = 'ssl://smtp.googlemail.com';
						// $config['smtp_port'] = '465';
						// $config['smtp_user']='myopeneyes3937@gmail.com';
						// $config['smtp_pass']='W3lc0m3@2018';
						
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';							
						$this->email->initialize($config);
				
						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1) AS totalbcc FROM tblemailtemplate AS et WHERE et.Token = '".$EmailToken."' && et.IsActive = 1");
						foreach($query->result() as $row){ 
							if($row->To==4){
							$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							$rowTo = $queryTo->result();
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							// foreach($query1->result() as $row1){			
							// 	$query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmstcountry AS con ON tn.CountryId = con.CountryId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblcompany AS com ON tn.CompanyId = com.CompanyId LEFT JOIN tblmstindustry AS ind ON com.IndustryId = ind.IndustryId WHERE tn.UserId = '.$userId);
							// 	$result2 = $query2->result();
							// 	$body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
							// } 
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
						
							$body = str_replace("{ first_name }",$FirstName,$body);	
							$body = str_replace("{ last_name }",$LastName,$body);	
							$body = str_replace("{ email_address }",$EmailAddress,$body);
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							if($this->email->send())
							{
								
								//echo json_encode("Success");
							}else
							{
								//echo json_encode("Fail");
							}
						}  else {
							$userId_ar = explode(',', $row->totalTo);			 
							foreach($userId_ar as $userId){
							   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							   $rowTo = $queryTo->result();
							   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							   $body = $row->EmailBody;
							//    foreach($query1->result() as $row1){			
							// 	   $query2 = $this->db->query('SELECT '.$row1->ColumnName.' AS ColumnName FROM '.$row1->TableName.' AS tn LEFT JOIN tblmstuserrole AS role ON tn.RoleId = role.RoleId LEFT JOIN tblmstcountry AS con ON tn.CountryId = con.CountryId LEFT JOIN tblmststate AS st ON tn.StateId = st.StateId LEFT JOIN tblcompany AS com ON tn.CompanyId = com.CompanyId LEFT JOIN tblmstindustry AS ind ON com.IndustryId = ind.IndustryId WHERE tn.UserId = '.$userId_backup);
							// 	   $result2 = $query2->result();
							// 	   $body = str_replace("{ ".$row1->PlaceholderName." }",$result2[0]->ColumnName,$body);					
							//    } 
								$body = str_replace("{ first_name }",$FirstName,$body);	
								$body = str_replace("{ last_name }",$LastName,$body);	
								$body = str_replace("{ email_address }",$EmailAddress,$body);
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
									'To' => trim($rowTo[0]->EmailAddress),
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
						echo json_encode('Fail');
					}	
				 }
					
			}
	}


	public function getAllUserList()
	{
			$data=$this->Userrequest_model->getlist_user();
			echo json_encode($data);
	}


	//Delete UserList
	
	public function deleteUser() {
		$post_user = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_user)
		 {
			if($post_user['id'] > 0){
				$result = $this->Userrequest_model->delete_user($post_user);
				if($result) {	
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}


	//get userId edit
	public function getById($User_Id=null)
	{	
		if(!empty($User_Id))
		{
			$data=[];
			$data=$this->Userrequest_model->get_userdata($User_Id);
			echo json_encode($data);
		}
	}


	public function getAllDefaultData()
	{
		
		$data['company']=$this->Userrequest_model->getlist_company();
		$data['department']=$this->Userrequest_model->getlist_department();
		$data['role']=$this->Userrequest_model->getlist_userrole();
		$data['industry']=$this->Userrequest_model->getlist_industry();
		$data['parentcomp']=$this->Userrequest_model->getlist_allcompany();
		echo json_encode($data);
	}

	


}
