<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Userprofile extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Userprofile_model');
		
	}
	
	public function getStateList($country_id = NULL) {
		
		if(!empty($country_id)) {
			
			$result = [];
			$result = $this->Userprofile_model->getStateList($country_id);			
			echo json_encode($result);				
		}			
	}
	
	public function addUser()
	{
		$post_user = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_user) 
			{
				if($post_user['UserId']>0)
				{
					$result = $this->Userprofile_model->edit_user($post_user);
					if($result)
					{

						echo json_encode($post_user);
						
					}
					
				}
				
					
			}
	}
	

	
	
	//get userId edit
	public function getById($user_id=null)
	{	
		
		if(!empty($user_id))
		{
			$data=[];
			$data=$this->Userprofile_model->get_userdata($user_id);
			echo json_encode($data);
		}
	}
	
	

	public function getAllDefaultData()
	{
		//$data="";
		$data['company']=$this->Userprofile_model->getlist_company();
		$data['department']=$this->Userprofile_model->getlist_department();
		$data['role']=$this->Userprofile_model->getlist_userrole();
		$data['country']=$this->Userprofile_model->getlist_country();
		$data['state']=$this->Userprofile_model->getlist_state();
		echo json_encode($data);
	}
}
