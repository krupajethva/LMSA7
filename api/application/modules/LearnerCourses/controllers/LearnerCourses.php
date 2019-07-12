<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class LearnerCourses extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('LearnerCourses_model');
	}

	// public function test(){
	// 	$CourseId = 3;
	// 	echo $query = 'INSERT INTO tbllearnertest(QuestionId,ResultId,CreatedBy,UpdatedBy) SELECT tmq.QuestionId, 1, 1, 1 from tblmstquestion as tmq where tmq.CourseId='.$CourseId.' ORDER BY RAND() LIMIT 5';
	// 	$result12 = $this->db->query($query);
	// }
	public function getSearchCourseList() {
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($data)) {					
			$result = [];
			$res['course']=$this->LearnerCourses_model->getSearchCourseList($data);		
			echo json_encode($res);				
		}			
	}
	public function Assessmentadd() {
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($data)) {					
			
			$result = [];
			$res=$this->LearnerCourses_model->Assessmentadd($data);		
			echo json_encode($res);				
		}			
	}
	public function getAllParent() 
	{
		$data['sub']=$this->LearnerCourses_model->getlist_SubCategory();
		echo json_encode($data);		
	}
	public function getAllCourse($UserId = NULL)
	{
		if(!empty($UserId)) 
		{					
			$result = [];
			$data['course']=$this->LearnerCourses_model->getlist_Course($UserId);	
			//print_r($data);	
			echo json_encode($data);				
		}			
	}
	public function getAllSession()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($data)) {							
			$result = [];
			$data=$this->LearnerCourses_model->getlist_session($data);	
		
			echo json_encode($data);				
		}			
	}
}