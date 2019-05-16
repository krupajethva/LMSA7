<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class User extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
		
	}
	

	    // ** register invited admin //
		public function invited_admin_Register()
		{
			$post_user = json_decode(trim(file_get_contents('php://input')), true);
			if ($post_user) 
				{
					if($post_user['UserId']>0)
					{
						$result = $this->User_model->edit_admin_invited($post_user);
						if($result)
						{
	
							if($post_user['RoleId']==2){
	
	
								$userId=$post_user['UserId'];
							$EmailToken = 'Admin register to SuperAdmin';
		
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
							$this->db->select('us.FirstName,us.LastName,us.EmailAddress,us.RoleId,us.CreatedBy,role.RoleName');
							$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
							$this->db->where('us.UserId',$userId);
							$smtp2 = $this->db->get('tbluser us');	
							foreach($smtp2->result() as $row) {
								$FirstName = $row->FirstName;
								$LastName = $row->LastName;
								$EmailAddress = $row->EmailAddress;
								$RoleName = $row->RoleName;
								$CreatedBy = $row->CreatedBy;
								
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
								if($row->To==2){
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
								$body = str_replace("{ role }",$RoleName,$body);
								$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
								$this->email->from($smtpEmail, 'LMS Admin');
								$this->email->to($rowTo[0]->EmailAddress);		
								$this->email->subject($row->Subject);
								$this->email->cc($row->totalcc);
								$this->email->bcc($bcc);
								$this->email->message($body);
								if($this->email->send())
								{
									$email_log = array(
										'From' => trim($smtpEmail),
										'Cc' => '',
										'Bcc' => '',
										'To' => trim($post_user['EmailAddress']),
										'Subject' => trim($row->Subject),
										'MessageBody' => trim($body),
									);
									$res = $this->db->insert('tblemaillog',$email_log);
									//echo json_encode("Success");
								}else
								{
									//echo json_encode("Fail");
								}
							
							} 
							else {
								$userId_ar = explode(',', $row->totalTo);			 
								foreach($userId_ar as $userId){
								   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
								   $rowTo = $queryTo->result();
								   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
								   $body = $row->EmailBody;
							
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
									  // echo 'success';
								   }else
								   {
									   //echo 'fail';
								   }
							   }
							}
	
						}
						
							
							$token = array(
								"UserId" => $post_user['UserId'],
								"InvitedByUserId" => $post_user['InvitedByUserId'],
								"RoleId" => $post_user['RoleId'],
								"EmailAddress" => $post_user['EmailAddress'],
								"FirstName" => $post_user['FirstName'],
								"LastName" => $post_user['LastName']
								);
	
								$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
								$output['token'] = $jwt;
								echo json_encode($output);	
	
	
							} else {
								$userId=$post_user['UserId'];
							$EmailToken = 'Registration Complete';
		
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
							$this->db->select('us.FirstName,us.LastName,us.EmailAddress,us.RoleId,us.CreatedBy,role.RoleName');
							$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
							$this->db->where('us.UserId',$userId);
							$smtp2 = $this->db->get('tbluser us');	
							foreach($smtp2->result() as $row) {
								$FirstName = $row->FirstName;
								$LastName = $row->LastName;
								$EmailAddress = $row->EmailAddress;
								$RoleName = $row->RoleName;
								$CreatedBy = $row->CreatedBy;
								
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
								if($row->To==4 || $row->To==3){
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
								$body = str_replace("{ role }",$RoleName,$body);
								$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
								$this->email->from($smtpEmail, 'LMS Admin');
								$this->email->to($rowTo[0]->EmailAddress);		
								$this->email->subject($row->Subject);
								$this->email->cc($row->totalcc);
								$this->email->bcc($bcc);
								$this->email->message($body);
								if($this->email->send())
								{	
									$email_log = array(
										'From' => trim($smtpEmail),
										'Cc' => '',
										'Bcc' => '',
										'To' => trim($post_user['EmailAddress']),
										'Subject' => trim($row->Subject),
										'MessageBody' => trim($body),
									);
									$res = $this->db->insert('tblemaillog',$email_log);
								}else
								{
									//echo json_encode("Fail");
								}
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
								   $body = str_replace("{ role }",$RoleName,$body);
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
										'To' => trim($row->EmailAddress),
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
						
							
							$token = array(
								"UserId" => $post_user['UserId'],
								"InvitedByUserId" => $post_user['InvitedByUserId'],
								"RoleId" => $post_user['RoleId'],
								"EmailAddress" => $post_user['EmailAddress'],
								"FirstName" => $post_user['FirstName'],
								"LastName" => $post_user['LastName']
								);
	
								$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
								$output['token'] = $jwt;
								echo json_encode($output);	
	
	
							}
							
						}	
						
					}
					
						
				}
		}
	

	// ** instructor register invited //
	public function openInstructorRegister()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
					$result = $this->User_model->add_open_instructor($post_user);
					if($result)
					{
						$userId = $result;
						$EmailToken='User Activation';
	
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
						
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';							
						$this->email->initialize($config);
				
						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
					
						foreach($query->result() as $row){ 
							if($row->To==3){
							$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							$rowTo = $queryTo->result();
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => $rowTo[0]->EmailAddress,
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
								//echo json_encode("Success");
							}
						
						} 
					
					}
					
					$EmailToken='Instructor Registration';
					$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
					
						foreach($query->result() as $row){ 
							if($row->To==1 || $row->To==2){
							$queryTo = $this->db->query('SELECT EmailAddress,RoleId FROM tbluser where RoleId in (1,2)'); 
							$rowTo = $queryTo->result();
							foreach($rowTo as $data){
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
							$body = str_replace("{ email_address }",$post_user['EmailAddress'],$body);	
							$body = str_replace("{ first_name }",$post_user['FirstName'],$body);
							$body = str_replace("{ last_name }",$post_user['LastName'],$body);
							$body = str_replace("{ role }",'Instructor',$body);
							if($data->RoleId==1){
								$body = str_replace("{text}",'Use the button below to sign in',$body);
								$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
								$body = str_replace("{button_text}",'Login',$body);
							}
							else{
								$body = str_replace("{text}",'Use the button below to activate above instructor:',$body);
								$body = str_replace("{ link }",''.BASE_URL.'/instructor-list/',$body);
								$body = str_replace("{button_text}",'Activate Instructor',$body);
							}
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							
							$this->email->to($data->EmailAddress);	
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => $data->EmailAddress,
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
								//echo json_encode("Success");
							}
							}
						} 
					}
					echo json_encode($result);
				}
				else
				{
					echo json_encode($result);
				}	
			}
	}
	
	public function invitedInstructorRegister()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
					$result = $this->User_model->edit_instructor($post_user);
					if($result)
					{
						$userId = $post_user['UserId'];
						$EmailToken='Successful Registration';
	
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
						
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';							
						$this->email->initialize($config);
				
						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
					
						foreach($query->result() as $row){ 
							if($row->To==3){
							$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							$rowTo = $queryTo->result();
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
							$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => $rowTo[0]->EmailAddress,
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
								//echo json_encode("Success");
							}
						
						} 
					
					}
					
					$EmailToken='Instructor Registration';
					$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
					
						foreach($query->result() as $row){ 
							if($row->To==1 || $row->To==2){
							$queryTo = $this->db->query('SELECT EmailAddress,RoleId FROM tbluser where RoleId in (1,2)'); 
							$rowTo = $queryTo->result();
							foreach($rowTo as $data){
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
							
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
							$body = str_replace("{ email_address }",$post_user['EmailAddress'],$body);	
							$body = str_replace("{ first_name }",$post_user['FirstName'],$body);
							$body = str_replace("{ last_name }",$post_user['LastName'],$body);
							$body = str_replace("{ role }",'Instructor',$body);
							
								$body = str_replace("{text}",'Use the button below to sign in',$body);
								$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
								$body = str_replace("{button_text}",'Login',$body);
							
							
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							
							$this->email->to($data->EmailAddress);	
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => $data->EmailAddress,
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
								//echo json_encode("Success");
							}
							}
						} 
					}
					echo json_encode($result);
				}
				else
				{
					echo json_encode($result);
				}	
			}
	}
	 // invited learner register //
	public function invited_learner_Register()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
				if($post_user['UserId']>0)
				{
					$result = $this->User_model->edit_learner_invited($post_user);
					if($result)
					{

						if($post_user['RoleId']==2){


							$userId=$post_user['UserId'];
						$EmailToken = 'Admin register to SuperAdmin';
	
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
						$this->db->select('FirstName,LastName,CreatedBy');
						$this->db->where('UserId',$userId);
						$smtp2 = $this->db->get('tbluser');	
						foreach($smtp2->result() as $row) {
							$FirstName = $row->FirstName;
							$LastName = $row->LastName;
							$CreatedBy = $row->CreatedBy;
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
							if($row->To==2){
							$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							$rowTo = $queryTo->result();
							$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							$body = $row->EmailBody;
						 
							if($row->BccEmail!=''){
								$bcc = $row->BccEmail.','.$row->totalbcc;
							} else {
								$bcc = $row->totalbcc;
							}
							$body = str_replace("{ first_name }",$FirstName,$body);
							$body = str_replace("{ last_name }",$LastName,$body);
							$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => trim($row->EmailAddress),
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
							}else
							{
								//echo json_encode("Fail");
							}
						
						} 
						else {
							$userId_ar = explode(',', $row->totalTo);			 
							foreach($userId_ar as $userId){
							   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							   $rowTo = $queryTo->result();
							   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							   $body = $row->EmailBody;
						
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
									'To' => trim($row->EmailAddress),
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
					
						//echo json_encode($post_user);	
						$token = array(
							"UserId" => $post_user['UserId'],
							"InvitedByUserId" => $post_user['InvitedByUserId'],
							"RoleId" => $post_user['RoleId'],
							"EmailAddress" => $post_user['EmailAddress'],
							"FirstName" => $post_user['FirstName'],
							"LastName" => $post_user['LastName']
							);

							$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
							$output['token'] = $jwt;
							echo json_encode($output);	


						} else {
							$userId=$post_user['UserId'];
						$EmailToken = 'Registration Complete';
	
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

						$this->db->select('us.FirstName,us.LastName,us.EmailAddress,us.RoleId,role.RoleName');
						$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
						$this->db->where('us.UserId',$userId);
						$smtp2 = $this->db->get('tbluser us');
						foreach($smtp2->result() as $row) {
							$FirstName = $row->FirstName;
							$LastName = $row->LastName;
							$EmailAddress = $row->EmailAddress;
							$RoleName = $row->RoleName;
							
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
							if($row->To==4 || $row->To==3){
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
							$body = str_replace("{ role }",$RoleName,$body);
							$body = str_replace("{ link }",''.BASE_URL.'/login/',$body);
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
							$this->email->message($body);
							if($this->email->send())
							{
								$email_log = array(
									'From' => trim($smtpEmail),
									'Cc' => '',
									'Bcc' => '',
									'To' => trim($post_user['EmailAddress']),
									'Subject' => trim($row->Subject),
									'MessageBody' => trim($body),
								);
								$res = $this->db->insert('tblemaillog',$email_log);
							}else
							{
								//echo json_encode("Fail");
							}
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
							   $body = str_replace("{ role }",$RoleName,$body);
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
									'To' => trim($row->EmailAddress),
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
					
						
						$token = array(
							"UserId" => $post_user['UserId'],
							"InvitedByUserId" => $post_user['InvitedByUserId'],
							"RoleId" => $post_user['RoleId'],
							"EmailAddress" => $post_user['EmailAddress'],
							"FirstName" => $post_user['FirstName'],
							"LastName" => $post_user['LastName']
							);

							$jwt = JWT::encode($token, "MyGeneratedKey","HS256");
							$output['token'] = $jwt;
							echo json_encode($output);	


						}
						
					}	
					
				}
			
					
			}
	}
	
	 // ** Delete user //
	public function deleteUser() {
		$post_user = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_user)
		 {
			if($post_user){
				$result = $this->User_model->delete_user($post_user);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}		
		} 		
	}
	public function checkEmail() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_data)
		 {
				$result = $this->User_model->checkEmail($post_data);
				if($result) {
					echo json_encode($result);
				}
		} 		
	}

	 // invited user get id for register //
	public function getById($user_id=null)
	{		
		if(!empty($user_id))
		{
			$data=[];
			$data=$this->User_model->get_userdata($user_id);
			echo json_encode($data);
		}
	}
	
	// list all admin users //
	public function getAdminUserList()
	{
		$data=$this->User_model->getlist_admin();
		echo json_encode($data);	
	}

	
	// ** All learner user //
	public function getAllUserList()
	{
		$data=$this->User_model->getlist_user();
		echo json_encode($data);	
	}


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

	

	 // ** certificate upload instructor //
	public function uploadFile()
	{
		if($_FILES){
			if(isset($_FILES['Certificate']) && !empty($_FILES['Certificate'])){
				move_uploaded_file($_FILES["Certificate"]["tmp_name"], "../src/assets/certificate/".$_FILES["Certificate"]["name"]);
			}
			echo json_encode('success');
		}
	}

	 // ** IsActive  //
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->User_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}

	// ** IsActive prime //
	public function isActiveChangePrime() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->User_model->isActiveChangePrime($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}

		
	// ** list default data //
	public function getAllDefaultData()
	{
		$data['education']=$this->User_model->getlist_EducationLevel();	
		$data['skills']=$this->User_model->getSkillList();	
		$data['role']=$this->User_model->getlist_userrole();
		echo json_encode($data);
	}

	 // revoke user //
	public function delete() {
		$post_revoke= json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_revoke)
		 {
			if($post_revoke['UserId'] > 0){
				$result = $this->User_model->delete_Invitation($post_revoke);
				if($result) {
					
					$userId=$post_revoke['UserId'];
					$data['UserId']=$userId;
				

					$EmailToken = 'User Revoked';

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

					$this->db->select('UserId,FirstName,LastName,EmailAddress,CreatedBy');
					$this->db->where('UserId',$userId);
					$smtp2 = $this->db->get('tbluser');	
					foreach($smtp2->result() as $row) {
						$FirstName = $row->FirstName;
						$LastName = $row->LastName;
						$EmailAddress = $row->EmailAddress;
						$CreatedBy = $row->CreatedBy;
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
						if($row->To==4){
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
						$body = str_replace("{ link }",''.BASE_URL.'/Login',$body);
						$this->email->from($smtpEmail, 'LMS Admin');
						$this->email->to($rowTo[0]->EmailAddress);		
						$this->email->subject($row->Subject);
						$this->email->cc($row->totalcc);
						$this->email->bcc($bcc);
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
							//echo json_encode("Fail");
						}
					}  else {
						$userId_ar = explode(',', $row->totalTo);			 
						foreach($userId_ar as $userId){
						   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
						   $rowTo = $queryTo->result();
						   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
						   $body = $row->EmailBody;
						   $body = str_replace("{ email_address }",$EmailAddress,$body);	
						   $body = str_replace("{ first_name }",$FirstName,$body);
						   $body = str_replace("{ last_name }",$LastName,$body);
						   $body = str_replace("{ link }",''.BASE_URL.'/Login',$body);
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
								'To' => trim($row->EmailAddress),
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
		
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}


	  // user re-invite //
	public function ReInvite() {
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($post_user)) {
		
			$result = $this->User_model->ReInvite_Invitation($post_user);			
			if($result) {
				

						$userId=$post_user['UserId'];
						$data['UserId']=$userId;
					

						$EmailToken = 'User Re-Invitation';
	
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

						$this->db->select('FirstName,LastName,EmailAddress,CreatedBy');
						$this->db->where('UserId',$userId);
						$smtp2 = $this->db->get('tbluser');	
						foreach($smtp2->result() as $row) {
							$FirstName = $row->FirstName;
							$LastName = $row->LastName;
							$EmailAddress = $row->EmailAddress;
							$CreatedBy = $row->CreatedBy;
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
							if($row->To==4){
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
							$body = str_replace("{ link }",''.BASE_URL.'/user-activation/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
							$this->email->from($smtpEmail, 'LMS Admin');
							$this->email->to($rowTo[0]->EmailAddress);		
							$this->email->subject($row->Subject);
							$this->email->cc($row->totalcc);
							$this->email->bcc($bcc);
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
								//echo json_encode("Fail");
							}
						}  else {
							$userId_ar = explode(',', $row->totalTo);			 
							foreach($userId_ar as $userId){
							   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
							   $rowTo = $queryTo->result();
							   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
							   $body = $row->EmailBody;
							   $body = str_replace("{ email_address }",$EmailAddress,$body);
							   $body = str_replace("{ link }",''.BASE_URL.'/user-activation/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
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
									'To' => trim($row->EmailAddress),
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
					echo json_encode('Success');
					

				
				
					
			}	
			else
			{
				echo json_encode('Fail');
			}
			
		} 
			
	}

	// check link already used or not // 
	public function resetpasslink2()
	{				
	$post_user = json_decode(trim(file_get_contents('php://input')), true);		
	if ($post_user)
		{
			
		
			$result = $this->User_model->reset_passlink2($post_user);
			
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
