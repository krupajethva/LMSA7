<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

class Assessment extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Assessment_model');
	}
	public function getbyassessment($SessionId = NULL,$userId=NULL)
	{
		if(!empty($SessionId)) {	
		$data['coursename']=$this->Assessment_model->getby_Assessment($SessionId);
		$data['question']=$this->Assessment_model->get_Questiondata($SessionId,$userId);
	//	print_r($data['question']);
		echo json_encode($data);
		}
	}
	public function finalsubmit($ResultId = NULL,$userId=NULL,$ttime=NULL,$stime=NULL)
	{
		if(!empty($ResultId)) {	
		$data=$this->Assessment_model->finalsubmit($ResultId,$userId,$ttime,$stime);
	
		echo json_encode($data);
		}
	}
	public function timeoutsubmit($ResultId = NULL,$userId=NULL)
	{
		
		if(!empty($ResultId)) {	
		$data=$this->Assessment_model->timeoutsubmit($ResultId,$userId);
	
		echo json_encode($data);
		}
	}
	public function assessment_result($ResultId = NULL)
	{
		if(!empty($ResultId)) {	
			$data['course']=$this->Assessment_model->getby_Assessment_result($ResultId);
			$data['result']=$this->Assessment_model->assessment_result($ResultId);
			$data['Certificate']=$this->Assessment_model->Certificate_Signature($ResultId);
	    // print_r($data['Certificate']);
		  
		echo json_encode($data);
		}
	}
	public function assessment_ans() 
	{	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Assessment_model->Submit_ans($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	public function getbyassessment_check() 
	{	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Assessment_model->assessment_check($post_data);
			if($result) {
				echo json_encode($result);	
			}						
		}		
	}
	public function MarkasReview()
	{	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Assessment_model->MarkasReview($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	public function addCertificate() 
	{	
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Assessment_model->addCertificate($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}
	public function getByIdCourseCertificat($CertificatId = NULL)
	{
		
		if(!empty($CertificatId)) {	
		$data=$this->Assessment_model->get_CourseCertificat($CertificatId);

		echo json_encode($data);
		}
	}
}