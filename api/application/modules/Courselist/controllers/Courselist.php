<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Courselist extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Courselist_model');
	}

	public function getAllCourse()
	{
		$data['course']=$this->Courselist_model->getlist_Course();
		mysqli_next_result($this->db->conn_id);
		$data['sub']=$this->Courselist_model->getlist_SubCategory();

		$data['Inst']=$this->Courselist_model->getlist_Instructors();
		$data['skill']=$this->Courselist_model->getAllCourseKey();
		//print_r($data);
		echo json_encode($data);
	}
	public function getCategoryWise($Category_Id = NULL) {
		
		if(!empty($Category_Id)) {					
			
			$result = [];
			$result = $this->Courselist_model->getCategoryWiseList($Category_Id);	
			//print_r($result);		
			echo json_encode($result);				
		}			
	}

	// Display instructor wise course
	/*public function getInstWise($User_Id = NULL) {
		
		if(!empty($User_Id)) {					
			
			$result = [];
			$result = $this->Courselist_model->getInstWiseList($User_Id);	
			//print_r($result);		
			echo json_encode($result);				
		}			
	}*/
	public function getAllCourseDetail() {
		
		$post_getAllCourseDetail = json_decode(trim(file_get_contents('php://input')), true);
		if($post_getAllCourseDetail) 
		{	
			$data = [];
			$data['detail'] = $this->Courselist_model->getCourseDetailList($post_getAllCourseDetail);
			$data['session'] = $this->Courselist_model->getCourseSessionList($post_getAllCourseDetail);
			$data['Preview'] = $this->Courselist_model->PreviewgetCourseSessionList($post_getAllCourseDetail);
			$data['CourseContent']=$this->Courselist_model->get_CourseContent($post_getAllCourseDetail);
			echo json_encode($data);				
		}			
	}
	public function getDiscussionById() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if(!empty($post_data['CourseId'])) {					
			$data = [];
			$data['discussion'] = $this->Courselist_model->getDiscussionById($post_data['CourseId']);
			$data['skill']=$this->Courselist_model->get_skilldata($post_data['CourseId']);	
			$data['Reviews']=$this->Courselist_model->getReviews($post_data);					
			//print_r($data['CourseContent']);
			//print_r($data);
			echo json_encode($data);				
		}			
	}
	public function getAllDiscussions($Id = NULL) {
		
		if(!empty($Id)) {					
			$data = [];
			$data['CourseName'] = $this->Courselist_model->getCourseName($Id);
			$data['discussion'] = $this->Courselist_model->getAllDiscussions($Id);
			echo json_encode($data);				
		}			
	}
	public function getAllReviews() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($post_data['CourseId'])) {					
			$data = [];
			$data['CourseName'] = $this->Courselist_model->getCourseName($post_data['CourseId']);
			$data['Reviews']=$this->Courselist_model->getAllReviews($post_data);		
			echo json_encode($data);				
		}			
	}
	public function getUserDetail($Id = NULL) {
		
		if(!empty($Id)) {					
			$data = [];
			$data = $this->Courselist_model->getUserDetail($Id);	
			echo json_encode($data);				
		}			
	}
	public function addEnroll()
	{
		
		$post_addEnroll = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_addEnroll) 
			{ 
					$result = $this->Courselist_model->addEnroll($post_addEnroll);
					if($result){
					
						$last_enroll=$this->db->query('SELECT UserId from tblcourseuserregister where CourseUserregisterId='.$result);
						$last_enrolluser=$last_enroll->result();
						$lat_UserId = $last_enrolluser[0]->UserId;
						$resultTo=$this->db->query('SELECT cs.CourseFullName,
						csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime,
									GROUP_CONCAT(coin.UserId) as instUserId,
							 (SELECT GROUP_CONCAT(u.FirstName)
										  FROM tbluser u 
										  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(coin.UserId))) as instName 
									FROM  tblcoursesession as csi 
									LEFT JOIN  tblcourseinstructor AS coin ON coin.CourseSessionId = csi.CourseSessionId
									LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
									 WHERE
									  csi.CourseSessionId='.$post_addEnroll["CourseSessionId"]);
						$toEmail=$resultTo->result();
						if($resultTo)
						{
						$CourseFullName=$toEmail[0]->CourseFullName;
						$StartDate=$toEmail[0]->StartDate;
						$StartTime=$toEmail[0]->StartTimeChange;
						$InstructorName=$toEmail[0]->instName;
					 // print_r($EmailAddress=$users['EmailAddress']);
					 $EmailToken = 'Course Enrolee';
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
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = '.$lat_UserId); 
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
						$body = str_replace("{login_url}",$StartTime,$body);
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
							echo json_encode('error');
						   }
						   echo json_encode($result);
					   }
					}
				}	
					
				}	
					}
			}
			else
			{
				echo json_encode('error');
			}
	}
	
	public function delete() {
		$post_Cart = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Cart)
		 {
			if($post_Cart['id'] > 0){
				$result = $this->Courselist_model->delete_Cart($post_Cart);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}
	public function checkUser() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_data)
		 {
				$result = $this->Courselist_model->checkUser($post_data);
				if($result) {
					echo json_encode("Duplicate User");
				}
		} 
			
	}
	public function addPost()
		{
			$post_data = json_decode(trim(file_get_contents('php://input')), true);	
			if ($post_data) {
				if(isset($post_data['DiscussionId']) && $post_data['DiscussionId']>0)
				{
					$result = $this->Courselist_model->editPost($post_data);
				}
				else{
					$result = $this->Courselist_model->addPost($post_data);
				}
				if($result) {
					echo json_encode($result);	
				}	
			}	
		}
	public function addCommentReply()
	{
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
				if(isset($post_data['DiscussionId']) && $post_data['DiscussionId']>0)
				{
					$result = $this->Courselist_model->editCommentReply($post_data);
				}
				else{
				$result = $this->Courselist_model->addCommentReply($post_data);
				}
				if($result) {
					echo json_encode($result);	
				}	
		}	
	}
	public function addReview()
	{
		$review_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($review_data) {
			if(isset($review_data['ReviewId']) && $review_data['ReviewId']>0)
			{
				$result['ReviewData'] = $this->Courselist_model->editReview($review_data);
				$result['Reviews']=$this->Courselist_model->getReviews($review_data);
			}
			else{
				$result['ReviewData'] = $this->Courselist_model->addReview($review_data);
				$result['Reviews']=$this->Courselist_model->getReviews($review_data);
			}
			if($result) {
				echo json_encode($result);	
			}
		}	
	}
	public function deleteReview() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);		
		if(!empty($post_data['ReviewId'])) {					
			$data['ReviewData'] = $this->Courselist_model->deleteReview($post_data['ReviewId']);
			$data['Reviews']=$this->Courselist_model->getReviews($post_data);
			echo json_encode($data);				
		}			
	}
	public function deleteDiscussion($DiscussionId = NULL) {
		if(!empty($DiscussionId)) {					
			$data = $this->Courselist_model->deleteDiscussion($DiscussionId);
			echo json_encode($data);				
		}			
	}
	public function shareCourse()
		{				 		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_data)
			{
					 $EmailToken = 'Share Course';

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
						 if($row->To==4){
						 $body = $row->EmailBody;
						$body = str_replace("{ first_name }",$post_data['FirstName'],$body);
						$body = str_replace("{ last_name }",$post_data['LastName'],$body);
						$body = str_replace("{ course_name }",$post_data['courseName'],$body);
						$body = str_replace("{ course_skills }",$post_data['skills'],$body);
						$body = str_replace("{ course_price }",$post_data['price'],$body);
						$body = str_replace("{ link }",''.BASE_URL.'/course-detail/'.$post_data['CourseId'].'',$body);
						 $this->email->from($smtpEmail, 'LMS Admin');
						 $this->email->to($post_data['EmailAddress']);		
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
					 }  
				 }
				 echo json_encode('Success'); 	
		}
		
	}
	
	public function courseFilter()
	{
		$courseFilter_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($courseFilter_data) {
			$result['Course'] = $this->Courselist_model->courseFilter($courseFilter_data);
				
			
			if($result) {
				echo json_encode($result);	
			}
			else {
				echo json_encode("error");	
			}
		}
		else {
			echo json_encode("error");	
		}	
	}
}