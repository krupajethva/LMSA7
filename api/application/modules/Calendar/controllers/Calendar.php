<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {


    public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Calendar_model');
		
    }
    public function getCalendarDetails($Id = NULL) {
		
      if (!empty($Id)) {
        $AllData = $this->Calendar_model->getCalendarDetails($Id);
        echo json_encode($AllData);			
      }
    }
}
?>