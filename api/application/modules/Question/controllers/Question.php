<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

class Question extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Question_model');
	}

	public function getAllCourse($userid = NULL)
	{
		if(!empty($userid)) {	
		$data=$this->Question_model->getlist_Course($userid);
		
		echo json_encode($data);
		}
	}
	public function getAllQuestion($coueseid = NULL)
	{
		if(!empty($coueseid)) {	
		$data['question']=$this->Question_model->getlist_question($coueseid);
		$data['course']=$this->Question_model->get_Coursedata($coueseid);
		
		echo json_encode($data);
		}
	}
	public function addQuestion()
	{
		$post_question = json_decode(trim(file_get_contents('php://input')), true);

		if ($post_question) 
			{
				$post_QuestionEntity=$post_question['QuestionEntity'];
				$post_TopicList=$post_question['TopicList'];
				if($post_QuestionEntity['QuestionId']>0)
				{
					$result = $this->Question_model->edit_question($post_question);
					if($result)
					{
						echo json_encode($result);	
					}	
				}
				else
				{
					$result = $this->Question_model->add_question($post_question);
					if($result)
					{
						echo json_encode($result);	
					}	
				}
					
			}
	}
	public function getById($Qid=null)
	{	
		
		if(!empty($Qid))
		{
			//$data=[];
			$data=$this->Question_model->get_Questiondata($Qid);
	//print_r($data);
		echo json_encode($data);
		}
	}
	public function getCourseById($id=null)
	{	
		
		if(!empty($id))
		{
			//$data=[];
			$data=$this->Question_model->get_Coursedata($id);
	//print_r($data);
		echo json_encode($data);
		}
	}
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Question_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	public function delete($id = NULL,$userid = NULL) {
	
		if ($id) {

			if(!empty($id)){
				$result = $this->Question_model->delete_Question($id,$userid);
				if($result) {
					
					echo json_encode("Delete successfully");
				 }
				}
		} 		
	}
	
	
}