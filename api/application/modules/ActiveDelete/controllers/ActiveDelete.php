<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ActiveDelete extends MY_Controller {


    public function __construct() {
	
		parent::__construct();
		
		$this->load->model('ActiveDelete_model');
		
    }
    public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->ActiveDelete_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
    }
    public function deleteItem() {
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			if($post_data['id'] > 0){
				$result = $this->ActiveDelete_model->deleteItem($post_data);
				if($result) {					
					echo json_encode("Delete successfully");
				}
			}			
		} 			
	}
}