<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class InstructorCourses extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('InstructorCourses_model');
	}
	public function getSearchCourseList() {
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($data)) {					
			
			$result = [];
			$res['course']=$this->InstructorCourses_model->getSearchCourseList($data);		
			echo json_encode($res);				
		}			
	}
	public function getAllParent() 
	{
		$data['sub']=$this->InstructorCourses_model->getlist_SubCategory();
		$data['coursestarthours']=$this->InstructorCourses_model->getlist_CourseStartHours();
		$data['courseendhours']=$this->InstructorCourses_model->getlist_CourseEndHours();
		echo json_encode($data);		
	}
	public function getAllCourse($UserId = NULL)
	{
		if(!empty($UserId)) 
		{					
			$result = [];
			$data['course']=$this->InstructorCourses_model->getlist_Course($UserId);		
	
		    echo json_encode($data);				
		}			
	}
	public function getAllCourseClone($CourseId = NULL)
	{
		if(!empty($CourseId)) 
		{					
			$result = [];
			$data=$this->InstructorCourses_model->getlist_CourseClone($CourseId);		

		    echo json_encode($data);				
		}			
	}
	public function updatePublish($CourseSessionId = NULL)
	{
		if(!empty($CourseSessionId)) 
		{					
		
			$data=$this->InstructorCourses_model->updatePublish($CourseSessionId);		
			$instdata=$this->InstructorCourses_model->updateinstdata($CourseSessionId);	
			if($instdata)
			{	$Coursedata =$this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
				GROUP_CONCAT(cs.UserId) as UserId,
				 (SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
						FROM tblcoursesession AS csi 
						LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
						LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
						WHERE csi.CourseSessionId='.$CourseSessionId.' GROUP BY csi.CourseSessionId');	
				foreach($Coursedata->result() as $Cdata)
				{
				foreach ($instdata as $users)
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
						   //echo 'fail';
					   }
				   }
				}
			}	
				}
			}
			 // echo json_encode($instdata);
			//}
		}	else
		{
			//echo json_encode('error');
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
							WHERE csi.CourseSessionId='.$CourseSessionId.' GROUP BY csi.CourseSessionId');	
					foreach($Coursedata->result() as $Cdata)
					{
					foreach ($data as $users)
					{
						
						$CourseFullName=$Cdata->CourseFullName;
						$StartDate=$Cdata->StartDate;
						$StartTime=$Cdata->StartTimeChange;
						$InstructorName=$Cdata->FirstName;
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
					echo json_encode($data);
				//}
			}	else
			{
				echo json_encode('error');
			}
			//	print_r($data);		
		//echo json_encode($data);	
	}			
	}
	public function getAllSession()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($data)) {							
			
			$data=$this->InstructorCourses_model->getlist_session($data);	
		
			echo json_encode($data);				
		}			
	}
	public function StartSession($CourseSessionId = NULL)
	{
		if(!empty($CourseSessionId)) 
		{					
		
			$data=$this->InstructorCourses_model->StartSession($CourseSessionId);		
			echo json_encode($data);				
		}			
	}
	public function EndSession($CourseSessionId = NULL)
	{
		if(!empty($CourseSessionId)) 
		{					
		
			$data=$this->InstructorCourses_model->EndSession($CourseSessionId);		
			echo json_encode($data);				
		}			
	}
	// public function updatePublish() {
	// 	$data = json_decode(trim(file_get_contents('php://input')), true);
	// 	if(!empty($CourseId['CourseId'])) {					
			
	// 		$result = [];
	// 		$res=$this->InstructorCourses_model->updatePublish($data);		
	// 		echo json_encode($res);				
	// 	}			
		
	// }addclone
	public function addclone() {
		$clone = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($clone)) {					
			
			$res=$this->InstructorCourses_model->addclone($clone);		
			echo json_encode($res);				
		}			
		
	}
	public function getEndHours()
	{
		//$data="";
		
		$data=$this->InstructorCourses_model->getlist_CourseEndHours();
		if($data)
		{
			$abc=1;
			foreach($data as $Hours)
			{ date_default_timezone_set("GMT");
			   $houra=$Hours['Value'];
			  //$time= strtotime('-'.$houra. 'hour');
			  date_default_timezone_set("Asia/Kolkata");
			  $timestamp = date('H:i:s', time() - (3600*$houra));
			
		   echo  $lastemail = date('H:i:00',time() + 900);
			 $date=date('Y-m-d');

			  //$time = date('H:i', $timestamp);
			  //echo $time;//11:09
				//  $shortdate = new DateTime("@$time");  // convert UNIX timestamp to PHP DateTime
			   // $dt=$shortdate->format('H:i:s');
				$data2=$this->InstructorCourses_model->getlist_value($timestamp,$date);
		  	$lastdata=$this->InstructorCourses_model->getlist_emailvalue($lastemail,$date);
				if($lastdata)
				{						
					foreach ($lastdata as $users)
					{
						
					 // print_r($EmailAddress=$users['EmailAddress']);
					
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
						
						$config['protocol']='smtp';
						$config['smtp_host']='ssl://smtp.googlemail.com';
						$config['smtp_port']='465';
						$config['smtp_user']='myopeneyes3937@gmail.com';
						$config['smtp_pass']='W3lc0m3$2019';	
						// $config['protocol']='mail';
						// $config['smtp_host']='vps40446.inmotionhosting.com';
						// $config['smtp_port']='587';
						// $config['smtp_user']=$smtpEmail;
						// $config['smtp_pass']=$smtpPassword;
						$config['charset']='utf-8';
						$config['newline']="\r\n";
						$config['mailtype'] = 'html';							
						$this->email->initialize($config);
						$Subject = 'LMS - Your course End';
						$body = '<table border="0" cellpadding="0" cellspacing="0" style="border:1px solid #333333; color:#000000; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto; width:600px">
						<tbody>
							<tr>
								<td style="background-color:#f3f3f3; background:#f3f3f3; border-bottom:1px solid #333333; padding:10px 10px 5px 10px"><img alt="Learn Feedback" src="'.BASE_URL.'/assets/images/logo.png" /></td>
							</tr>
							<tr>
								<td style="border-width:0; padding:20px 10px 10px 10px; text-align:center">
								<p style="color:#000; font-size: 25px; line-height: 25px; font-weight: bold;padding: 0; margin: 0 0 10px;"><strong>Payment Succesfully </strong><strong></strong></p>
					
								<p style="color:#000; font-size: 18px; line-height: 18px; font-weight: bold; padding: 0; margin: 0 0 10px;">We&rsquo;re so happy you&rsquo;ve joined us.</p>
					
								<p style="color:#000; font-size: 14px; line-height:20px; padding: 0; margin: 0 0;">Use the button below to login your account and get started:</p>
								</td>
							</tr>
								<tr>
								<td style="border-width:0; padding:0; text-align:center; vertical-align:middle">
								<table border="0" cellpadding="0" cellspacing="0" style="border:0; font-family:Arial,Helvetica,sans-serif; font-size:15px; line-height:22px; margin:0 auto">
									<tbody>
										<tr>
											<td style="background-color:#b11016; background:#b11016; border-radius:4px; border-width:0; clear:both; color:#ffffff; font-size:14px; line-height:13px; opacity:1; padding:10px; text-align:center; text-decoration:none; width:130px"><a href="{login_link}" style="color:#fff; text-decoration:none;">Get Started</a></td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
								<tr>
								<td style="border-width:0; padding:20px 10px 10px 10px; text-align:center; vertical-align:middle">			
								<p style="color:#777; font-size: 14px; line-height:20px; padding: 0; margin: 0 0 25px;">If you have any questions, you can reply to this email and it will go right to them. Alternatively, feel free to contact our customer success team anytime.</p>
					
								<p style="color:#777; font-size: 12px; line-height:20px; padding: 0; margin: 0 0 10px; text-align: left;">If you&rsquo;re having trouble with the button above, copy and paste the URL below into your web browser. <a href="{login_link}" style="cursor:pointer;">click here</a></p>
								</td>
							</tr>
							<tr>
								<td style="background-color:#222222; background:#222222; border-top:1px solid #cccccc; color:#ffffff; font-size:13px; padding:7px; text-align:center">Copyright &copy; 2018 Learning Management System</td>
							</tr>
						</tbody>
					</table>';
		
					$body = str_replace("{login_link}",''.BASE_URL.'/login',$body);
		
						$this->email->from($smtpEmail, 'LMS');
						$this->email->to($users->EmailAddress);		
						$this->email->subject($Subject);
						$this->email->message($body);
						if($this->email->send())
						{
							echo json_encode('success');
						}else
						{
							echo json_encode('not send');
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
}
}