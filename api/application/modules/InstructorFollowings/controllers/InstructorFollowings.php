<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class InstructorFollowings extends CI_Controller 
{	
    public function __construct()
	{
		parent::__construct();
		$this->load->model('InstructorFollowings_model');
    }
    
    public function getAllFollowings($InstructorId=null)
	{
		if(!empty($InstructorId))
		{
			$data=$this->InstructorFollowings_model->getAllFollowings($InstructorId);
			echo json_encode($data);
		}
	}
}