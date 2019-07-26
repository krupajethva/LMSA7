<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Userinvite extends CI_Controller {

	public function __construct()
	{ 
		parent::__construct();
		$this->load->model('Userinvite_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}

	//** invite user //
	public function inviteInstructor()
	{  
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
				$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$res = "";
				for ($i = 0; $i < 6; $i++) {
					$res .= $chars[mt_rand(0, strlen($chars)-1)];
				}
				
				$post_user['RegistrationCode']= $res;

				$smtpDetails = getSmtpDetails(); //get smtp details 
				$result = $this->Userinvite_model->invite_Instructor($post_user); 
			
				if($result)
				{
					$userId=$result;
					$data['UserId']=$userId;
					$data['RegistrationCode']=$post_user['RegistrationCode'];
					$data['EmailAddress']=$post_user['EmailAddress'];	
					$res=new stdClass();
					$res->loginUrl = ''.BASE_URL.'/register-instructor-invited/edit/'.JWT::encode($data,"MyGeneratedKey","HS256").'';
					$EmailToken = 'User Invitation';
					$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
					$body = $EmailDetails['EmailBody'];
                    $FormattedBody = getFormattedBody($res ,$body);
					
					// send email to particular email
                    $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
					echo json_encode('Success');
												
					}	
					else
					{
						echo json_encode('Fail');
					}
				 
					
			}
	}


//** register open instructor user //
public function openinviteInstructor()
{  
	$post_user = json_decode(trim(file_get_contents('php://input')), true);
	if ($post_user) 
		{
					$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$res = "";
					for ($i = 0; $i < 6; $i++) {
						$res .= $chars[mt_rand(0, strlen($chars)-1)];
					}
					
					$post_user['RegistrationCode']= $res;

					$result = $this->Userinvite_model->openinvite_Instructor($post_user); 
		
				if($result)
				{
					$userId=$result;
					$data['UserId']=$userId;
					$data['RegistrationCode']=$post_user['RegistrationCode'];
					$data['EmailAddress']=$post_user['EmailAddress'];				
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

					$this->db->select('RoleId,FirstName,LastName,EmailAddress,CreatedBy');
					$this->db->where('UserId',$userId);
					$smtp2 = $this->db->get('tbluser');	
					foreach($smtp2->result() as $row) {
						$RoleId = $row->RoleId;
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
					
						if($RoleId==2)
						{
							$body = str_replace("{ email_address }",$EmailAddress,$body);					
							$body = str_replace("{ link }",''.BASE_URL.'/register-admin-invited/edit/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
						}
						else if($RoleId==3)
						{
							$body = str_replace("{ email_address }",$EmailAddress,$body);					
							$body = str_replace("{ link }",''.BASE_URL.'/register-instructor-invited/edit/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
						}
						else if($RoleId==4)
						{
							$body = str_replace("{ email_address }",$EmailAddress,$body);					
							$body = str_replace("{ link }",''.BASE_URL.'/register-learner-invited/edit/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
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
								'To' => trim($post_user['EmailAddress']),
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
						$body = str_replace("{ link }",''.BASE_URL.'/register-instructor-invited/edit/'.JWT::encode($data,"MyGeneratedKey","HS256").'',$body);
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
									'To' => trim($post_user['EmailAddress']),
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

	
    // state dependencie  //
	public function getStateList($country_id = NULL)
	{
	   if(!empty($country_id)) {			
		   $result = [];
		   $result = $this->Userinvite_model->getStateList($country_id);			
		   echo json_encode($result);				
	   }			
   }

   // get list default data //
	public function getAllDefaultData()
	{
		$data['company']=$this->Userinvite_model->getlist_company();
		$data['role']=$this->Userinvite_model->getlist_userrole();
		$data['industry']=$this->Userinvite_model->getlist_industry();
		$data['country']=$this->Userinvite_model->getlist_Country();
		$data['state']=$this->Userinvite_model->getlist_State();
		echo json_encode($data);
	}





}
