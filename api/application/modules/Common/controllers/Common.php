<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {


    public function __construct() {
	
		parent::__construct();		
		$this->load->model('Common_model');
		
	}

	public function get_permissiondata() {
		
		$post_permission = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_permission) {
			$data = $this->Common_model->get_permissiondata($post_permission);
			echo json_encode($data);						
		}				
	}	

	public function getCompanyDetails() {
		
		$post_company = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_company) {
			$data = $this->Common_model->getCompanyDetails($post_company);
			if($data){
				echo json_encode($data);
			} else {
				echo json_encode('error');
			}									
		}				
	}

	public function getCompanyList() {
			
		$data = $this->Common_model->getCompanyList();
		if($data){
			echo json_encode($data);
		} 		
	}

	public function check_workspace_url() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		$data = $this->Common_model->check_workspace_url($post_data);
		if($data){
			echo json_encode($data);
		} else {
			echo json_encode('no');
		}		
	}
	
}
