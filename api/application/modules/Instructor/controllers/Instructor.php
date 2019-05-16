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

	 // ** IsActive user instructor //
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Instructor_model->isActiveChange($post_data);
			if($result) {
				$userId=$post_data['UserId'];
				$EmailToken = 'Activation of Instructor by Admin';

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
							'To' => trim($rowTo[0]->EmailAddress),
							'Subject' => trim($row->Subject),
							'MessageBody' => trim($body),
						);
						$res = $this->db->insert('tblemaillog',$email_log);
						echo json_encode("Success");
					}else
					{
						//echo json_encode("Fail");
					}
				}  
				
			}			
		}
		else
		{
			
			echo json_encode('fail');
		}		
	}
}
	
}
