<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Company_model');
	}
	
	// state dependencie //
	public function getStateList($country_id = NULL)
	 {
		if(!empty($country_id)) {			
			$result = [];
			$result = $this->Company_model->getStateList($country_id);			
			echo json_encode($result);				
		}			
	}

	 //  add company and update //
	public function addCompany()
	{
		$post_company = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_company) 
			{
				if($post_company['CompanyId']>0)
				{
					$result = $this->Company_model->edit_company($post_company);
					if($result)
					{
						echo json_encode($post_company);	
					}	
				}
				else
				{
					$result = $this->Company_model->add_company($post_company);
					if($result)
					{
						echo json_encode($post_company);	
					}	
				}
					
			}
	}
	
	 // get id company //
	public function getById($Company_Id=null)
	{		
		if(!empty($Company_Id))
		{
			$data=[];
			$data=$this->Company_model->get_companydata($Company_Id);
			echo json_encode($data);
		}
	}
	
	
	 // list all company //
	public function getAll()
	{
		$data=$this->Company_model->getlist_company();	
		echo json_encode($data);
	}



	// ** IsActive //
	public function isActiveChange() {	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Company_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}

	
	 // delete company // 
	public function delete() {
		$post_company = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_company)
		 {
			if($post_company){
				$result = $this->Company_model->delete_company($post_company);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}	
		} 		
	}

	// get default list //
	public function getAllDefaultdata() {
		$data['industry']=$this->Company_model->getlist_Industry();
		$data['country']=$this->Company_model->getlist_Country();
		$data['state']=$this->Company_model->getlist_State();
		echo json_encode($data);
				
	}


	
}