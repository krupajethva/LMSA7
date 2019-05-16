<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userrole extends MY_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Userrole_model');
	}
	
	
	public function addUserrole()
	{
		$post_userrole = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_userrole) 
			{
				if($post_userrole['RoleId']>0)
				{
					$result = $this->Userrole_model->edit_userrole($post_userrole);
					if($result)
					{
						echo json_encode($post_userrole);	
					}	
				}
				else
				{
					
					$result = $this->Userrole_model->add_userrole($post_userrole); 
					if($result)
					{
						echo json_encode($post_userrole);	
					}	

				}
					
			}
	}
	
	
	//Delete UserList

	
	public function delete() {
		$role_id = json_decode(trim(file_get_contents('php://input')), true);		

		if ($role_id) {
			if($role_id['id'] > 0){
				$result = $this->Userrole_model->delete_userrole($role_id);
				if($result) {
					
					echo json_encode("Delete successfully");
				}
				}
		
			
		} 
			
	}
	
	
	//get userId edit
	public function getById($role_id=null)
	{	
		
		if(!empty($role_id))
		{
			$data=[];
			$data=$this->Userrole_model->get_userroledata($role_id);
			echo json_encode($data);
		}
	}
	

	public function getAll()
	{
		//$data="";
		
		$data=$this->Userrole_model->getlist_userrole();
		
		echo json_encode($data);
	}
	
	
}
