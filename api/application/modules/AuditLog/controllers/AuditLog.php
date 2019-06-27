<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuditLog extends CI_Controller {


    public function __construct() {
	
		parent::__construct();	
		$this->load->model('AuditLog_model');
		
	}

	 // email log list //
	public function getEmailLog() {
		$data=$this->AuditLog_model->getEmailLog();		
		echo json_encode($data);
				
	}

	 // login log list //
	public function getLoginLog() {
		$data=$this->AuditLog_model->getLoginLog();		
		echo json_encode($data);
				
	}

  // activity list //
	public function getActivityLog() {
		$data=$this->AuditLog_model->listActivityLog();		
		echo json_encode($data);
				
	}
	public function getActivityByUser($id=null) 
	{
		if(!empty($id))
		{
			$data=[];
			$data=$this->AuditLog_model->getActivityByUser($id);
			echo json_encode($data);
		}
	}
	
}
