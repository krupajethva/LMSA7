<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class ParentCategory extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ParentCategory_model');
	}
	

	public function getAllCategory()
	{
		$data=$this->ParentCategory_model->getlist_Category();
		
		echo json_encode($data);
	}

	public function addCategory()
	{
		
		$post_Category = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Category) 
			{
				if($post_Category['CategoryId']>0)
				{
					$result = $this->ParentCategory_model->edit_Category($post_Category);
					if($result)
					{
						echo json_encode($post_Category);	
					}	
				}
				else
				{
					$result = $this->ParentCategory_model->add_Category($post_Category);
					if($result)
					{
						echo json_encode($post_Category);	
					}	
				}
					
			}
	}
	
	public function getById($Category_id=null)
	{	
		
		if(!empty($Category_id))
		{
			$data=[];
			$data=$this->ParentCategory_model->get_Categorydata($Category_id);
			echo json_encode($data);
		}
	}

	public function delete() {
		$post_Category = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Category)
		 {
			if($post_Category['id'] > 0){
				$result = $this->ParentCategory_model->delete_Category($post_Category);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}

	
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->ParentCategory_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	
}