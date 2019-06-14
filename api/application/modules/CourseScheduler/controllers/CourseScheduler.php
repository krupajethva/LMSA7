<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");
use \Firebase\JWT\JWT;
class CourseScheduler extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CourseScheduler_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}

public function abc()
{   $new_data=  array("484", "504","508");
	$this->db->select('UserId');
	$this->db->where('CourseSessionId',3);
	$old= $this->db->get('tblcourseinstructor');
	$Old_Result=$old->result();
	$old_data = array();
	foreach($Old_Result as $row)
	{
		array_push($old_data, $row->UserId);
	}
	$old_data1 = $old_data;
   $array_delete=array();
   $array_new=array();
	// $this->db->where('CourseSessionId',$post_Session['CourseSessionId']);
	// 	$ress = $this->db->delete('tblcourseinstructor');
		foreach($new_data as $row)
		{
			if (in_array($row, $old_data))
			{ 
				//$key = array_search($row,$old_data);
				//$array_delete = array_diff($old_data, [$key]);
				array_splice($old_data, array_search($row, $old_data ), 1);
		
			}
		  else
			{
				$Courseinstructo_data = array(
					'CourseSessionId' =>3,
					'UserId' =>  $row,
					'IsPrimary'=>0,
					'CreatedBy' =>484

				);
				$ress=$this->db->query('call addcourseinstructor(?,?,?,?)',$Courseinstructo_data);
			array_push($array_new,$row);
			}
		}
		if(count($old_data)>0){
			$this->db->where_in('UserId',$old_data);
			$this->db->where('CourseSessionId',3);
			$res_delete = $this->db->delete('tblcourseinstructor');
		}else
		{
			echo "error";
		}

		print_r($new_data);
		print_r($old_data1);
		print_r($old_data);
		print_r($array_new);

}
	
	public function addScheduler()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		$pCourse=$post_Course['course'];
		$CourseId=$pCourse['CourseId'];
		$post_Courseschedular=$post_Course['schedularList'];
		if ($post_Course) 
			{ 
					$result = $this->CourseScheduler_model->add_CourseScheduler($post_Course);
					if($result)
					{
						$this->db->select('CourseFullName');
						$this->db->where('CourseId',$CourseId);
						$result_course = $this->db->get('tblcourse');
						$course=json_decode(json_encode($result_course->result()), True);
					
					foreach($result as $Courseschedular)
					{
						//	if($Courseschedular['CourseSessionId']==0)
							//{
					array_push($Courseschedular['Instructor'],$Courseschedular['Instructorone']);	
					foreach($Courseschedular['Instructor'] as $UserId)
					{
					$SessionName=$Courseschedular['SessionName'];
					$StartDate=$Courseschedular['StartDate'];
					$StartTime=$Courseschedular['StartTime'];
					$CourseName=$course[0]['CourseFullName'];
				    $EmailToken = 'Instructor Invitation';
					$this->db->select('Value');
					$this->db->where('Key','EmailFrom');
					$smtp1 = $this->db->get('tblmstconfiguration');	
					foreach($smtp1->result() as $row) 
					{
						$smtpEmail = $row->Value;
					}
					$this->db->select('Value');
					$this->db->where('Key','EmailPassword');
					$smtp2 = $this->db->get('tblmstconfiguration');	
					foreach($smtp2->result() as $row)
					{
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
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$UserId); 
					$rowTo = $queryTo->result();
					$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					$body = $row->EmailBody;
				
					if($row->BccEmail!=''){
						$bcc = $row->BccEmail.','.$row->totalbcc;
					} else {
						$bcc = $row->totalbcc;
					}
					$body = str_replace("{ CourseFullName }",$CourseName,$body);
					$body = str_replace("{ StartDate }",$StartDate,$body);
					$body = str_replace("{ StartTime }",$StartTime,$body);
					$body = str_replace("{ SessionName }",$SessionName,$body);
					$data1['CourseSessionId']=$Courseschedular['CourseSessionId'];
					$data2['CourseSessionId']=$Courseschedular['CourseSessionId'];
					$data1['UserId']=$UserId;
					$data2['UserId']=$UserId;
					$data1['type']=1;
					$data2['type']=2;
			    	//	$body = str_replace("{login_url}",$StartTime,$body);
					$body = str_replace("{ link1 }",''.BASE_URL.'/instructor-invitation/'.JWT::encode($data1,"MyGeneratedKey","HS256").'',$body);
					$body = str_replace("{ link2 }",''.BASE_URL.'/instructor-invitation/'.JWT::encode($data2,"MyGeneratedKey","HS256").'',$body);
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
							'To' => trim($rowTo[0]->EmailAddress),
							'Subject' => trim($row->Subject),
							'MessageBody' => trim($body),
						);
						$res = $this->db->insert('tblemaillog',$email_log);	
				
						
					}else
					{
						echo json_encode('fail');
					}
					}
				    }
                    }	
					}
				
					echo json_encode($result);
			}
	        }
}
	public function addSingleSession()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		
		$po_Course=$post_Course['course'];
		$CourseId=$po_Course['CourseId'];
		$Courseschedular=$post_Course['schedularList'];
		if($Courseschedular['CourseSessionId']>0)
			{ 
				$result = $this->CourseScheduler_model->edit_SingleSession($post_Course);
				if($result)
				{
					//print_r('success');
				echo json_encode($result);	
				}
			}
			else
			{
				$result = $this->CourseScheduler_model->add_SingleSession($post_Course);
				if($result)
				{
					$this->db->select('CourseFullName');
						$this->db->where('CourseId',$CourseId);
						$result_course = $this->db->get('tblcourse');
						$course=json_decode(json_encode($result_course->result()), True);
						array_push($Courseschedular['Instructor'],$Courseschedular['Instructorone']);
							
					foreach($Courseschedular['Instructor'] as $UserId){
					$SessionName=$Courseschedular['SessionName'];
					$StartDate=$Courseschedular['StartDate'];
					$StartTime=$Courseschedular['StartTime'];
				 	$CourseName=$course[0]['CourseFullName'];
				 // print_r($EmailAddress=$users['EmailAddress']);
				 $EmailToken = 'Instructor Invitation';
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
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$UserId); 
					$rowTo = $queryTo->result();
					$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					$body = $row->EmailBody;
				
					if($row->BccEmail!=''){
						$bcc = $row->BccEmail.','.$row->totalbcc;
					} else {
						$bcc = $row->totalbcc;
					}
					$body = str_replace("{ CourseFullName }",$CourseName,$body);
					$body = str_replace("{ StartDate }",$StartDate,$body);
					$body = str_replace("{ StartTime }",$StartTime,$body);
					$body = str_replace("{ SessionName }",$SessionName,$body);
				//	$body = str_replace("{login_url}",$StartTime,$body);
					$body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
					$data1['CourseSessionId']=$result;
					$data2['CourseSessionId']=$result;
					$data1['UserId']=$UserId;
					$data2['UserId']=$UserId;
					$data1['type']=1;
					$data2['type']=2;
				//	$body = str_replace("{login_url}",$StartTime,$body);
					$body = str_replace("{ link1 }",''.BASE_URL.'/instructor-invitation/'.JWT::encode($data1,"MyGeneratedKey","HS256").'',$body);
					$body = str_replace("{ link2 }",''.BASE_URL.'/instructor-invitation/'.JWT::encode($data2,"MyGeneratedKey","HS256").'',$body);
					
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
						//echo json_encode($users);
						
					}else
					{
						echo json_encode('fail');
					}
				}  else {
					$userId_ar = explode(',', $row->totalTo);			 
					foreach($userId_ar as $userId){
					   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$UserId); 
					   $rowTo = $queryTo->result();
					   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					   $body = $row->EmailBody;

					   $body = str_replace("{ CourseFullName }",$CourseFullName,$body);
					   $body = str_replace("{ StartDate }",$StartDate,$body);
					   $body = str_replace("{ StartTime }",$StartTime,$body);
					   $body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
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
						  echo json_encode('fail');
					   }
				   }
				}
			}
						}
						//print_r('success');
					//print_r('success');
				echo json_encode($result);	
				}
			}
					
			
	}
	public function updatePublish()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		
		$post_Session=$post_Course['schedularList'];
		if($post_Session['CourseSessionId']>0)
		{ 
				$result = $this->CourseScheduler_model->edit_updatePublish($post_Course);
				if($result)
				{
		// 			if($post_Session['Check']==1)
		// 			{

		// 				$resultTo=$this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
		// 				csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime, 
		// 				GROUP_CONCAT(coin.UserId) as instUserId,
		// 					 (SELECT GROUP_CONCAT(u.FirstName)
		// 								  FROM tbluser u 
		// 								  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(coin.UserId))) as instName 
		// 				FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
		// 				LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
		// 				LEFT JOIN  tblcourseinstructor AS coin ON coin.CourseSessionId = csi.CourseSessionId
		// 				LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
		// 				 WHERE
		// 				 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId='.$post_Session["CourseSessionId"].' GROUP BY us.EmailAddress');
		// 				$ToEmailAddress=$resultTo->result();
		// 				if($resultTo)
		// 				{
		// 				$array = array();
		// 				foreach($ToEmailAddress as $toEmail)
		// 				{
		// 				  array_push($array,$toEmail->UserId);	
		// 		         //	$ToEmailAddressString = implode(",", $array);
		// 				$CourseFullName=$toEmail->CourseFullName;
		// 				$StartDate=$toEmail->StartDate;
		// 				$StartTime=$toEmail->StartTimeChange;
		// 				$InstructorName=$toEmail->instName;
		// 			 // print_r($EmailAddress=$users['EmailAddress']);
		// 			 $EmailToken = 'Course Republished Enrolees';
		// 				$this->db->select('Value');
		// 				$this->db->where('Key','EmailFrom');
		// 				$smtp1 = $this->db->get('tblmstconfiguration');	
		// 				foreach($smtp1->result() as $row) {
		// 					$smtpEmail = $row->Value;
		// 				}
		// 				$this->db->select('Value');
		// 				$this->db->where('Key','EmailPassword');
		// 				$smtp2 = $this->db->get('tblmstconfiguration');	
		// 				foreach($smtp2->result() as $row) {
		// 					$smtpPassword = $row->Value;
		// 				}
						
		// 			$config['protocol']=PROTOCOL;
		// 			$config['smtp_host']=SMTP_HOST;
		// 			$config['smtp_port']=SMTP_PORT;
		// 			$config['smtp_user']=$smtpEmail;
		// 			$config['smtp_pass']=$smtpPassword;
		
		// 			$config['charset']='utf-8';
		// 			$config['newline']="\r\n";
		// 			$config['mailtype'] = 'html';							
		// 			$this->email->initialize($config);
			
		// 			$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
			
		// 			foreach($query->result() as $row){ 
		// 				if($row->To==4 || $row->To==3){
		// 				$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$toEmail->UserId); 
		// 				$rowTo = $queryTo->result();
		// 				$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
		// 				$body = $row->EmailBody;
					
		// 				if($row->BccEmail!=''){
		// 					$bcc = $row->BccEmail.','.$row->totalbcc;
		// 				} else {
		// 					$bcc = $row->totalbcc;
		// 				}
		// 				$body = str_replace("{ CourseFullName }",$CourseFullName,$body);
		// 				$body = str_replace("{ StartDate }",$StartDate,$body);
		// 				$body = str_replace("{ StartTime }",$StartTime,$body);
		// 				$body = str_replace("{ InstructorName }",$InstructorName,$body);
		// 				$body = str_replace("{login_url}",$StartTime,$body);
		// 				$body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
		// 				$this->email->from($smtpEmail, 'LMS Admin');
		// 				$this->email->to($rowTo[0]->EmailAddress);		
		// 				$this->email->subject($row->Subject);
		// 				$this->email->cc($row->totalcc);
		// 				$this->email->bcc($bcc);
		// 				$this->email->message($body);
		// 				if($this->email->send())
		// 				{
		// 					$email_log = array(
		// 						'From' => trim($smtpEmail),
		// 						'Cc' => '',
		// 						'Bcc' => '',
		// 						'To' => trim($rowTo[0]->EmailAddress),
		// 						'Subject' => trim($row->Subject),
		// 						'MessageBody' => trim($body),
		// 					);
		// 					$res = $this->db->insert('tblemaillog',$email_log);	
						
		// 				}else
		// 				{
		// 					echo json_encode("Fail");
		// 				}
		// 			}  else {
		// 				$userId_ar = explode(',', $row->totalTo);			 
		// 				foreach($userId_ar as $userId){
		// 				   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
		// 				   $rowTo = $queryTo->result();
		// 				   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
		// 				   $body = $row->EmailBody;

		// 				   $body = str_replace("{ CourseFullName }",$CourseFullName,$body);
		// 				   $body = str_replace("{ StartDate }",$StartDate,$body);
		// 				   $body = str_replace("{ StartTime }",$StartTime,$body);
					
		// 				   $this->email->from($smtpEmail, 'LMS Admin');
		// 				   $this->email->to($rowTo[0]->EmailAddress);		
		// 				   $this->email->subject($row->Subject);
		// 				   $this->email->cc($row->totalcc);
		// 				   $this->email->bcc($row->BccEmail.','.$row->totalbcc);
		// 				   $this->email->message($body);
		// 				   if($this->email->send())
		// 				   {
		// 					$email_log = array(
		// 						'From' => trim($smtpEmail),
		// 						'Cc' => '',
		// 						'Bcc' => '',
		// 						'To' => trim($rowTo[0]->EmailAddress),
		// 						'Subject' => trim($row->Subject),
		// 						'MessageBody' => trim($body),
		// 					);
		// 					$res = $this->db->insert('tblemaillog',$email_log);	
		// 				   }else
		// 				   {
		// 					   //echo 'fail';
		// 				   }
		// 			   }
		// 			}
		// 		}	
		// 			}
		// 		}
		// 		$resultinst=$this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
		// 		csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime, 
		// 		GROUP_CONCAT(coin.UserId) as instUserId,
		// 					 (SELECT GROUP_CONCAT(u.FirstName)
		// 								  FROM tbluser u 
		// 								  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(coin.UserId))) as instName 
		// 		FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
		// 		LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
		// 		LEFT JOIN  tblcourseinstructor AS coin ON coin.CourseSessionId = csi.CourseSessionId
		// 		LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
		// 		 WHERE
		// 		 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId='.$post_Session["CourseSessionId"].' GROUP BY us.EmailAddress');
		// 		$ToEmailAddress=$resultinst->result();
		// 		if($resultinst)
		// 		{
		// 		$array = array();
		// 		foreach($ToEmailAddress as $toEmail)
		// 		{
		// 		  array_push($array,$toEmail->UserId);	
		// 		 //	$ToEmailAddressString = implode(",", $array);
		// 		 $CourseFullName=$toEmail->CourseFullName;
		// 		 $StartDate=$toEmail->StartDate;
		// 		 $StartTime=$toEmail->StartTimeChange;
		// 		 $InstructorName=$toEmail->instName;
		// 	 $EmailToken = 'Course Republished Instructor';
		// 		$this->db->select('Value');
		// 		$this->db->where('Key','EmailFrom');
		// 		$smtp1 = $this->db->get('tblmstconfiguration');	
		// 		foreach($smtp1->result() as $row) {
		// 			$smtpEmail = $row->Value;
		// 		}
		// 		$this->db->select('Value');
		// 		$this->db->where('Key','EmailPassword');
		// 		$smtp2 = $this->db->get('tblmstconfiguration');	
		// 		foreach($smtp2->result() as $row) {
		// 			$smtpPassword = $row->Value;
		// 		}
				
		// 	$config['protocol']=PROTOCOL;
		// 	$config['smtp_host']=SMTP_HOST;
		// 	$config['smtp_port']=SMTP_PORT;
		// 	$config['smtp_user']=$smtpEmail;
		// 	$config['smtp_pass']=$smtpPassword;

		// 	$config['charset']='utf-8';
		// 	$config['newline']="\r\n";
		// 	$config['mailtype'] = 'html';							
		// 	$this->email->initialize($config);
	
		// 	$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '".$EmailToken."' && et.IsActive = 1");
	
		// 	foreach($query->result() as $row){ 
		// 		if($row->To==4 || $row->To==3){
		// 		$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$toEmail->UserId); 
		// 		$rowTo = $queryTo->result();
		// 		$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
		// 		$body = $row->EmailBody;
			
		// 		if($row->BccEmail!=''){
		// 			$bcc = $row->BccEmail.','.$row->totalbcc;
		// 		} else {
		// 			$bcc = $row->totalbcc;
		// 		}
		// 		$body = str_replace("{ CourseFullName }",$CourseFullName,$body);
		// 		$body = str_replace("{ StartDate }",$StartDate,$body);
		// 		$body = str_replace("{ StartTime }",$StartTime,$body);
		// 		$body = str_replace("{ InstructorName }",$InstructorName,$body);
		// 		$body = str_replace("{login_url}",$StartTime,$body);
		// 		$body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
		// 		$this->email->from($smtpEmail, 'LMS Admin');
		// 		$this->email->to($rowTo[0]->EmailAddress);		
		// 		$this->email->subject($row->Subject);
		// 		$this->email->cc($row->totalcc);
		// 		$this->email->bcc($bcc);
		// 		$this->email->message($body);
		// 		if($this->email->send())
		// 		{
		// 			$email_log = array(
		// 				'From' => trim($smtpEmail),
		// 				'Cc' => '',
		// 				'Bcc' => '',
		// 				'To' => trim($rowTo[0]->EmailAddress),
		// 				'Subject' => trim($row->Subject),
		// 				'MessageBody' => trim($body),
		// 			);
		// 			$res = $this->db->insert('tblemaillog',$email_log);	
				
		// 		}else
		// 		{
		// 			echo json_encode("Fail");
		// 		}
		// 	}  else {
		// 		$userId_ar = explode(',', $row->totalTo);			 
		// 		foreach($userId_ar as $userId){
		// 		   $queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$userId); 
		// 		   $rowTo = $queryTo->result();
		// 		   $query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
		// 		   $body = $row->EmailBody;

		// 		   $body = str_replace("{ CourseFullName }",$CourseFullName,$body);
		// 		   $body = str_replace("{ StartDate }",$StartDate,$body);
		// 		   $body = str_replace("{ StartTime }",$StartTime,$body);
			
		// 		   $this->email->from($smtpEmail, 'LMS Admin');
		// 		   $this->email->to($rowTo[0]->EmailAddress);		
		// 		   $this->email->subject($row->Subject);
		// 		   $this->email->cc($row->totalcc);
		// 		   $this->email->bcc($row->BccEmail.','.$row->totalbcc);
		// 		   $this->email->message($body);
		// 		   if($this->email->send())
		// 		   {
		// 			$email_log = array(
		// 				'From' => trim($smtpEmail),
		// 				'Cc' => '',
		// 				'Bcc' => '',
		// 				'To' => trim($rowTo[0]->EmailAddress),
		// 				'Subject' => trim($row->Subject),
		// 				'MessageBody' => trim($body),
		// 			);
		// 			$res = $this->db->insert('tblemaillog',$email_log);	
		// 		   }else
		// 		   {
		// 			   //echo 'fail';
		// 		   }
		// 	   }
		// 	}
		// }	
		// 	}
		// }
		// 				echo json_encode('success');
		// 			}else
				//	{
						//echo json_encode($result);
				//	}

				}else
				{
					echo json_encode('error1');
				}
			}
			else
		{
				$result = $this->CourseScheduler_model->add_SingleSession($post_Course);
				if($result)
				{
					$data =$this->db->query('SELECT UserId FROM tblcoursesession AS cs 
					LEFT JOIN tblcourseinstructor AS cin ON
					 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId='.$result);
						 $ress=array();
						  foreach($data->result() as $row)
						  {
							//print_r($ress);
							 $data1 = $this->db->query('
							 SELECT FollowerUserId FROM tblinstructorfollowers AS cs WHERE cs.InstructorUserId='.$row->UserId);
							foreach($data1->result() as $row1){
								if($row1->FollowerUserId!='')
								{
								$FollowerUserId = explode(",",$row1->FollowerUserId);
								foreach($FollowerUserId as $id){
									array_push($ress,$id);
								}
							  }
								
							}
							
						  }
						 // echo json_encode($ress);
					if($data)
					{	
						$Coursedata =$this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
				GROUP_CONCAT(cs.UserId) as UserId,
				 (SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
						FROM tblcoursesession AS csi 
						LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
						LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
						WHERE csi.CourseSessionId='.$result.' GROUP BY csi.CourseSessionId');	
						$Cdata=$Coursedata->result();
			
				foreach ($ress as $users)
				{
					
					$CourseFullName=$Cdata[0]->CourseFullName;
					$StartDate=$Cdata[0]->StartDate;
					$StartTime=$Cdata[0]->StartTimeChange;
					$InstructorName=$Cdata[0]->FirstName;
				 // print_r($EmailAddress=$users['EmailAddress']);
				 $EmailToken = 'Course Published Followers';
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
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$users); 
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
					$body = str_replace("{ InstructorName }",$InstructorName,$body);
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
							'To' => trim($rowTo[0]->EmailAddress),
							'Subject' => trim($row->Subject),
							'MessageBody' => trim($body),
						);
						$res = $this->db->insert('tblemaillog',$email_log);	
						//echo json_encode($users);
						
					}else
					{
						echo json_encode('fail');
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
					   $body = str_replace("{login_url}",''.BASE_URL.'/login/',$body);
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
						  echo json_encode('fail');
					   }
				   }
				}
			}	
				}
			
		//	echo json_encode($ress);
			//}
		}	else
		{
			echo json_encode('error');
		}
		$data =$this->db->query('SELECT UserId FROM tblcoursesession AS cs 
			LEFT JOIN tblcourseinstructor AS cin ON
			 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId='.$result);
			 	$res=array();
			 	 foreach($data->result() as $row)
				  {
					//print_r($ress);
				$id=$row->UserId;
				array_push($res,$id);
					foreach($data1->result() as $row1){
						if($row1->FollowerUserId!='')
						{
						$FollowerUserId = explode(",",$row1->FollowerUserId);
						foreach($FollowerUserId as $id){
							array_push($ress,$id);
						}
					  }
						
					}
					
				 }
			if($data)
				{	$Coursedata =$this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
					GROUP_CONCAT(cs.UserId) as UserId,
					 (SELECT GROUP_CONCAT(u.FirstName)
								  FROM tbluser u 
								  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
							FROM tblcoursesession AS csi 
							LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
							LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
							WHERE csi.CourseSessionId='.$result.' GROUP BY csi.CourseSessionId');	
					foreach($Coursedata->result() as $Cdata)
					{
					foreach ($res as $users)
					{
						
						$CourseFullName=$Cdata->CourseFullName;
						$StartDate=$Cdata->StartDate;
						$StartTime=$Cdata->StartTimeChange;
						$InstructorName=$Cdata->FirstName;
					 // print_r($EmailAddress=$users['EmailAddress']);
					 $EmailToken = 'Course Published Instructor';
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
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$users); 
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
						$body = str_replace("{ InstructorName }",$InstructorName,$body);
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
								'To' => trim($rowTo[0]->EmailAddress),
								'Subject' => trim($row->Subject),
								'MessageBody' => trim($body),
							);
							$res = $this->db->insert('tblemaillog',$email_log);	
						
						}else
						{
							echo json_encode("Fail");
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
					}
				}
					//echo json_encode($result);
				//}
			}	else
			{
				echo json_encode('error');
			}
			//	print_r($data);		
		//echo json_encode($data);	
			//	echo json_encode($result);	
				}
				
			}
		//	echo json_encode('suceess');
	}

	public function getAllDefaultData()
	{

		$data['country']=$this->CourseScheduler_model->getlist_country();
	$data['state']=$this->CourseScheduler_model->getlist_state();
		$data['instructor']=$this->CourseScheduler_model->getlist_instructor();
		$data['instructor1']=$data['instructor'];
		echo json_encode($data);
	}
	public function getStateList($country_id = NULL) {
		
		if(!empty($country_id)) {
			
			$result = [];
			$result = $this->CourseScheduler_model->getStateList($country_id);			
			echo json_encode($result);				
		}			
	}
	public function getById($Course_id=null,$userid=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
	
			//$data['skill']=$this->Course_model->get_skilldata($Course_id);	
			$data['coursesession']=$this->CourseScheduler_model->get_Coursesession($Course_id,$userid);
			mysqli_next_result($this->db->conn_id);
			$data['coursename']=$this->CourseScheduler_model->get_Coursename($Course_id);
		//  print_r($data);
		echo json_encode($data);
		}
	}
	public function deleteScheduler() {
		$post_Scheduler = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Scheduler)
		 {
				$result = $this->CourseScheduler_model->delete_Scheduler($post_Scheduler);
				if($result)
				 {
					echo json_encode("Delete successfully");
				}
		} 
			
	}
	public function addClone() {
		$post_Clone = json_decode(trim(file_get_contents('php://input')), true);		
		$Courseschedular=$post_Clone['schedularList'];
		if ($post_Clone)
		 {
			if($Courseschedular['CourseSessionId'] > 0){
				$result = $this->CourseScheduler_model->Clone_Course($post_Clone);
				if($result) {
					
					echo json_encode($result);
					}
		 	}
		
			
		} 
			
	}
}