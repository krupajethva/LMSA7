<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class InstructorFollowers extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('InstructorFollowers_model');
	}

	public function getAllFollowers($InstructorId=null)
	{
		if(!empty($InstructorId))
		{
			$data=$this->InstructorFollowers_model->getAllFollowers($InstructorId);
			echo json_encode($data);
		}
	}
	public function getAllInstructors()
	{
		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		if($post_data){
			$data=$this->InstructorFollowers_model->getAllInstructors($post_data);
			if($data){
				echo json_encode($data);
			}
		}
	}
	public function getById($FollowerId=null)
	{	
		if(!empty($FollowerId))
		{
			$data=[];
			$data=$this->InstructorFollowers_model->get_Followerdata($FollowerId);
			echo json_encode($data);
		}
	}

	public function followInstructor()
	{	
		$post_followInstructor = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_followInstructor)
		 {
			$result = $this->InstructorFollowers_model->followInstructor($post_followInstructor);
			if($result) {	
				echo json_encode("Follow successfully");
			}
		} 
	}

	public function unfollowInstructor()
	{	
		$post_unfollowInstructor = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_unfollowInstructor)
		 {
			$result = $this->InstructorFollowers_model->unfollowInstructor($post_unfollowInstructor);
			if($result) {	
				echo json_encode("Unfollow successfully");
			}
		} 
	}
	public function getInstructorDetails()
	{	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_data)
		 {
			$result['FollowerDetail'] = $this->InstructorFollowers_model->getFollowerDetails($post_data);
			$result['InstructorDetail'] = $this->InstructorFollowers_model->getInstructorDetails($post_data);
			$result['ActiveCourses'] = $this->InstructorFollowers_model->getActiveCourses($post_data);
			if($result) {	
				echo json_encode($result);
			}
		} 
	}
}