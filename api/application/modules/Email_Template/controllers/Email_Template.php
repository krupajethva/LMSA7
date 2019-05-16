<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_Template extends CI_Controller {

	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Email_Template_model');
		
	}
	
	public function getAll() {
		
		//$data="";
		
		$data=$this->Email_Template_model->getlist_email();
		
		echo json_encode($data);
				
	}


	// ** IsActive
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Email_Template_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	
	
	public function add() {
		
		$post_email = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_email) {
			if($post_email['EmailId'] > 0){
				$result = $this->Email_Template_model->edit_email($post_email);
				if($result) {
					echo json_encode($result);
				}	
			} else {
				$result = $this->Email_Template_model->add_email($post_email);
				if($result) {
					echo json_encode($result);				
				}	
			}							
		}
		
	}
	
	public function getById($email_id = NULL) {		
		if (!empty($email_id)) {
			$data = "";		
			$data = $this->Email_Template_model->get_emaildata($email_id);
			echo json_encode($data);			
		}
	}	


	public function delete() {
		$email_id = json_decode(trim(file_get_contents('php://input')), true);		

		if ($email_id) {
			if($email_id['id'] > 0){
				$result = $this->Email_Template_model->delete_email($email_id);
				if($result) {
					
					echo json_encode("Delete successfully");
				}
				}
		
			
		} 
			
	}
	
	
	public function getDefaultList() {		
		//$data="";		
		$data['role']=$this->Email_Template_model->getRoleList();
		$data['placeholder']=$this->Email_Template_model->getPlaceholderList();	
		$data['tocken']=$this->Email_Template_model->getlist_tocken();	
		echo json_encode($data);				
	}

}
