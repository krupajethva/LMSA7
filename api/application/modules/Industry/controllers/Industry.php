<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Industry extends CI_Controller {


	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Industry_model');
		
	}
	
	public function getAll() {
		
		//$data="";
		
		$data=$this->Industry_model->getlist_Industry();
		
		echo json_encode($data);
				
	}
	
		// ** IsActive
		public function isActiveChange() {
		
			$post_data = json_decode(trim(file_get_contents('php://input')), true);	
			if ($post_data) {
				$result = $this->Industry_model->isActiveChange($post_data);
				if($result) {
					echo json_encode('success');	
				}						
			}		
		}
	
	public function add() {
		$post_Industry = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Industry) {
			if($post_Industry['IndustryId'] > 0){
				$result = $this->Industry_model->edit_Industry($post_Industry);
				if($result) {
					echo json_encode($post_Industry);	
				}	
			} else {
				$result = $this->Industry_model->add_Industry($post_Industry);
				if($result) {
					echo json_encode($post_Industry);	
				}	
			}							
		}
		
	}
	
	public function getById($Industry_Id = NULL) {
		
		if (!empty($Industry_Id)) {
			$data = [];		
			$data = $this->Industry_model->get_Industrydata($Industry_Id);
			echo json_encode($data);			
		}
	}	
	
	
		

	public function delete() {
		$post_Industry = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Industry) {
			if($post_Industry['id'] > 0){
				$result = $this->Industry_model->delete_Industry($post_Industry);
				if($result) {
					
					echo json_encode("Delete successfully");
				}
				}
		
			
		} 
			
	}
	
}
