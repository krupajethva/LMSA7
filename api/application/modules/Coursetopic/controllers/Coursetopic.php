<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Coursetopic extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Coursetopic_model');
	}



	public function addCoursetopic()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Course) 
			{
				if($post_Course['change']>0)
				{
					$result = $this->Coursetopic_model->edit_Coursetopic($post_Course);
					if($result)
					{
						echo json_encode($post_Course);	
					}	
				}
				else
				{
					$result = $this->Coursetopic_model->add_Coursetopic($post_Course);
					if($result)
					{
						echo json_encode($post_Course);	
					}	
				}
					
			}
	}
	public function getAllCourse() {
		
		$data=$this->Coursetopic_model->getlist_course();
		
		echo json_encode($data);
				
	}
	
	public function getById($Course_id=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
			$data=$this->Coursetopic_model->get_Coursedata($Course_id);
			echo json_encode($data);
		}
	}

	public function delete() {
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Course)
		 {
			if($post_Course['id'] > 0){
				$result = $this->Coursetopic_model->delete_Course($post_Course);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}

	// public function getAllParent() {
		
	// 	$data=$this->Category_model->getlist_parent();
		
	// 	echo json_encode($data);
				
	// }
	
	
	
	
}