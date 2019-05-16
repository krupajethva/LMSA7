<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends My_Controller {


    public function __construct() {
	
		parent::__construct();
		$this->load->model('Settings_model');
		
	}

	
	public function getAll($userid = NULL) {
		if(!empty($userid)) {
			$data['reminder']=$this->Settings_model->get_reminder();
			$data['configonoff']=$this->Settings_model->get_configonoff();
			$data['instructorConfigonoff']=$this->Settings_model->get_instructoConfigonoff();
			//print_r($data['configonoff']);
			$data['emailfrom']=$this->Settings_model->get_emailfrom($userid);
			$data['emailpassword']=$this->Settings_model->get_emailpassowrd($userid);
		
			
			$data['CourseKey']=$this->Settings_model->get_CourseKeyword();
			$data['Contact']=$this->Settings_model->get_Contact();
			$data['Invimsg']=$this->Settings_model->get_Invimsg();
			
		}
		
		echo json_encode($data);
				
	}    

	public function getAllCourseKey() {
		$data['CourseKey']=$this->Settings_model->getAllCourseKey();
		echo json_encode($data);
	}


	// ** for Login on off Instructor
	public function getAllConfigInstructor() {
		$data=$this->Settings_model->getlist_ConfigInstructor();
		echo json_encode($data);
	}

	// ** for Login on off learner
	public function getAllConfig() {
		$data=$this->Settings_model->getlist_Config();
		echo json_encode($data);
	}

	public function updateConfiguration()
	 {
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->update_config($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

	public function UpdateReminder()
	 {
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->UpdateReminder($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

	public function updateEmail() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->updateEmail($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

	public function secondSubmit() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->secondSubmit($config_data);
		if($result) {
			echo json_encode('success');	
		}	
		
	}


	public function insAddOnOff() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->insAddOnOff($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}


	public function addOnOff() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->addOnOff($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

	public function addContact() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->addContact($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

    // ** add course keyword
	public function addCourseKeyword() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->addCourseKeyword($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}

	public function addinvimsg() {
		
		$config_data = json_decode(trim(file_get_contents('php://input')), true);		

		$result = $this->Settings_model->addinvimsg($config_data);
		if($result) {
			echo json_encode($config_data);	
		}	
		
	}
	

	
	
	
}
