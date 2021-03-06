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
						$smtpDetails = getSmtpDetails(); //get smtp details 
						
						$res=new stdClass();
						$res->loginUrl = BASE_URL . '/login/';
						$res->CourseFullName = $toEmail[0]->CourseFullName;
						$res->StartDate = $toEmail[0]->StartDate;
						$res->StartTime = $toEmail[0]->StartTimeChange;
						$res->InstructorName = $toEmail[0]->instName;
						
						$EmailToken = 'Course Enrolee';
						$EmailDetails = getEmailDetails($EmailToken,$lat_UserId); //get email details by user id
						$body = $EmailDetails['EmailBody'];
						$FormattedBody = getFormattedBody($res ,$body);
						
						// send email to particular email
						$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
						echo json_encode($result);
				
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
		$smtpDetails = getSmtpDetails(); //get smtp details 
		if ($post_data)
		{
			$res=new stdClass();
			$res->loginUrl = ''.BASE_URL.'/course-detail/'.$post_data['CourseId'].'';
			$res->FirstName = $post_data['FirstName'];
			$res->LastName = $post_data['LastName'];
			$res->courseName = $post_data['courseName'];
			$res->skills = $post_data['skills'];
			$res->price = $post_data['price'];
			$EmailToken = 'Share Course';
			$EmailDetails = getEmailDetails($EmailToken,"''"); //get email details by user id
			$body = $EmailDetails['EmailBody'];
			$FormattedBody = getFormattedBody($res ,$body);
			
			// send email to particular email
			$send = SendEmail($smtpDetails['smtpEmail'], $post_data['EmailAddress'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
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