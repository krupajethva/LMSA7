<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addresses extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Addresses_model');
	}
	


	public function addAddresses()
	{
		$post_addresses = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_addresses) 
			{
				if($post_addresses['AddressesId']>0)
				{
					$result = $this->Addresses_model->edit_addresses($post_addresses);
					if($result)
					{
						echo json_encode($post_addresses);	
					}	
				}
				else
				{
					$result = $this->Addresses_model->add_addresses($post_addresses);
					if($result)
					{
						echo json_encode($post_addresses);	
					}	
				}
					
			}
	}
	
	public function getById($Addresses_Id=null)
	{		
		if(!empty($Addresses_Id))
		{
			$data=[];
			$data=$this->Addresses_model->get_addressesdata($Addresses_Id);
			echo json_encode($data);
		}
	}
	
	
	
	public function getAll()
	{
		$data=$this->Addresses_model->getlist_addresses();	
		echo json_encode($data);
	}


	// ** IsActive
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Addresses_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}


	
	

	public function delete() {
		$post_addresses = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_addresses)
		 {
			if($post_addresses['AddressesId'] > 0){
				$result = $this->Addresses_model->delete_addresses($post_addresses);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}	
		} 		
	}

	
	
}