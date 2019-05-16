<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class CertificateTemplate extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CertificateTemplate_model');
	}
	

	public function getAllCertificate()
	{
		$data=$this->CertificateTemplate_model->getlist_Certificate();
		
		echo json_encode($data);
	}

	public function addCertificate()
	{
		
		$post_Certificate = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Certificate) 
			{
				if($post_Certificate['CertificateId']>0)
				{
					$result = $this->CertificateTemplate_model->edit_Certificate($post_Certificate);
					if($result)
					{
						echo json_encode($post_Certificate);	
					}	
				}
				else
				{
					$result = $this->CertificateTemplate_model->add_Certificate($post_Certificate);
					if($result)
					{
						echo json_encode($post_Certificate);	
					}	
				}
					
			}
	}
	
	public function getById($Certificate_id=null)
	{	
		
		if(!empty($Certificate_id))
		{
			$data=[];
			$data=$this->CertificateTemplate_model->get_Certificatedata($Certificate_id);
			echo json_encode($data);
		}
	}

	public function delete() {
		$post_Certificate = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Certificate)
		 {
			if($post_Certificate['id'] > 0){
				$result = $this->CertificateTemplate_model->delete_Certificate($post_Certificate);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}	
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->CertificateTemplate_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	public function getDefaultList() {		
		//$data="";		
		$data['role']=$this->CertificateTemplate_model->getRoleList();
		$data['placeholder']=$this->CertificateTemplate_model->getPlaceholderList();		
		echo json_encode($data);				
	}
	
}