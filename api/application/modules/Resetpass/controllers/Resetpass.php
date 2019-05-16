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
					
				$result = $this->Reset_model->reset_pass($post_pass);
				if($result)
				{
					$userId=$post_pass['UserId'];
					$EmailToken = 'Reset Password';
				
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
