<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Attendance extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Attendance_model');
	}
	
	public function SearchAttendance($CourseSessionId=null) {
	//	$data = json_decode(trim(file_get_contents('php://input')), true);
		if(!empty($CourseSessionId)) {					
			
			$data['course']=$this->Attendance_model->get_Coursedata($CourseSessionId);
			$data['attendance']=$this->Attendance_model->getSearchAttendanceList($CourseSessionId);
			$data['dates']=$this->Attendance_model->getAttendanceDateList($CourseSessionId);	
			
			echo json_encode($data);				
		}			
	}
	public function UpdateAttendance() {
		
		$post_getupdate = json_decode(trim(file_get_contents('php://input')), true);
		if($post_getupdate) 
		{	
			
			$data= $this->Attendance_model->getAttendanceUpdate($post_getupdate);

			echo json_encode($data);				
		}			
	}
	public function getDefaultData($User_id=null) {
		
		$data['course']=$this->Attendance_model->getlist_Country($User_id);
		$data['session']=$this->Attendance_model->getlist_State($User_id);
		echo json_encode($data);
				
	}	
	public function getById($Session_id=null)
	{	
		// $date = new DateTime('2019-04-20');
		// $date->modify('next monday');
		// $begin = $date;
		// $end = new DateTime('2019-05-15');
		// $daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
		
		// foreach($daterange as $date){
		// 	echo $date->format("Y-m-d") . "<br>";
		// }
		
		if(!empty($Session_id))
		{
			$data=[];
			$data['course']=$this->Attendance_model->get_Coursedata($Session_id);
			$data['attendance']=$this->Attendance_model->getSearchAttendanceList($Session_id);
			$data['dates']=$this->Attendance_model->getAttendanceDateList($Session_id);
			$data['courseid']=$this->Attendance_model->getbyCourseId($Session_id);
			echo json_encode($data);
		}
	}
	public function getStateList($CourseId = NULL) {	
		if(!empty($CourseId)) {			
			$result = [];
			$result = $this->Attendance_model->getStateList($CourseId);			
			echo json_encode($result);				
		}			
	}
	
}