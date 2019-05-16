<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Education extends CI_Controller {


	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Education_model');
		
	}
	
	public function getAll() {	
		$data=$this->Education_model->getlist_Education();
		
		echo json_encode($data);
				
	}

	// ** IsActive
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Education_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	
	
	public function add() {
		
		$post_Education = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Education) {
			if($post_Education['EducationLevelId'] > 0){
				$result = $this->Education_model->edit_Education($post_Education);
				if($result) {
					echo json_encode($post_Education);	
				}	
			} else {
				$result = $this->Education_model->add_Education($post_Education);
				if($result) {
					echo json_encode($post_Education);	
				}	
			}							
		}
		
	}
	
	public function getById($EducationLevel_Id = NULL) {
		
		if (!empty($EducationLevel_Id)) {
			$data = [];		
			$data = $this->Education_model->get_Educationdata($EducationLevel_Id);
			echo json_encode($data);			
		}
	}	
	

		
	public function delete() {
		$post_Education = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Education) {
			if($post_Education['id'] > 0){
				$result = $this->Education_model->delete_Education($post_Education);
				if($result) {
					
					echo json_encode("Delete successfully");
				}
				}
		
			
		} 
			
	}
	
	
}
