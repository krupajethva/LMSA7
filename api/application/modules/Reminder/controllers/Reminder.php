<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Reminder extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reminder_model');
	}
	public function InstructorBeforeDays()
	{
		//$data="";
		
		$data=$this->Reminder_model->getlist_InstructorBeforeDays();
		if($data)
		{
		
			// foreach($data as $days)
		 	// { 
			//date_default_timezone_set("GMT");
		// 	   $houra=$Hours['Value'];
		// 	  //$time= strtotime('-'.$houra. 'hour');
		// 	  date_default_timezone_set("Asia/Kolkata");
		// 	  $timestamp = date('H:i:s', time() - (3600*$houra));
			
		//    echo  $lastemail = date('H:i:00',time() + 900);
		// 	 $date=date('Y-m-d');
		$Day=$data->Value;
		//$Day=$days['Value'];
		$datetime1=date('Y-m-d',strtotime('+'.$Day.'days'));
	
			  $lastdata=$this->Reminder_model->getlist_Instructor($datetime1);
			
				if($lastdata)
				{						
					foreach ($lastdata as $users)
					{
						$userId=$users->UserId;
						$CourseFullName=$users->CourseFullName;
						$StartDate=$users->StartDate;
						$StartTime=$users->StartTime;
					 // print_r($EmailAddress=$users['EmailAddress']);
					 $EmailToken = 'Instructor should get an email before X days';
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
						$body = str_replace("{ CourseFullName }",$CourseFullName,$body);
						$body = str_replace("{ StartDate }",$StartDate,$body);
						$body = str_replace("{ StartTime }",$StartTime,$body);
					//	$body = str_replace("{login_url}",$StartTime,$body);
						$body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
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
								'To' => trim($users->EmailAddress),
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

						   $body = str_replace("{ CourseFullName }",$CourseFullName,$body);
						   $body = str_replace("{ StartDate }",$StartDate,$body);
						   $body = str_replace("{ StartTime }",$StartTime,$body);
					
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
								'To' => trim($users->EmailAddress),
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
					}
					echo json_encode($lastdata);
				//}
			}	else
			{
				echo json_encode('error');
			}		
			
		}
	}


	
	



	public function getStartDate()
	{
		//$data="";
		
		$data=$this->Reminder_model->getlist_CourseStartDate();
		if($data)
		{
		
			// foreach($data as $days)
		 	// { 
			//date_default_timezone_set("GMT");
		// 	   $houra=$Hours['Value'];
		// 	  //$time= strtotime('-'.$houra. 'hour');
		// 	  date_default_timezone_set("Asia/Kolkata");
		// 	  $timestamp = date('H:i:s', time() - (3600*$houra));
			
		//    echo  $lastemail = date('H:i:00',time() + 900);
		// 	 $date=date('Y-m-d');
		$Day=$data->Value;
		//$Day=$days['Value'];
		$datetime1=date('Y-m-d',strtotime('+'.$Day.'days'));
	
			  $lastdata=$this->Reminder_model->getlist_emailvalue($datetime1);
			 // print_r($lastdata);
				if($lastdata)
				{						
					foreach ($lastdata as $users)
					{
						$userId=$users->UserId;
						$CourseFullName=$users->CourseFullName;
						$StartDate=$users->StartDate;
						$StartTime=$users->StartTime;
					 // print_r($EmailAddress=$users['EmailAddress']);
					 $EmailToken = 'Course Start Reminder For Learner';
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
						$body = str_replace("{ CourseFullName }",$CourseFullName,$body);
						$body = str_replace("{ StartDate }",$StartDate,$body);
						$body = str_replace("{ StartTime }",$StartTime,$body);
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
								'To' => trim($users->EmailAddress),
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

						   $body = str_replace("{ CourseFullName }",$CourseFullName,$body);
						   $body = str_replace("{ StartDate }",$StartDate,$body);
						   $body = str_replace("{ StartTime }",$StartTime,$body);
					
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
								'To' => trim($users->EmailAddress),
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
					}
					echo json_encode($lastdata);
				//}
			}	else
			{
				echo json_encode('error');
			}		
			
		//}
	}
}
}