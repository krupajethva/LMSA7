<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function __construct() {
	
		parent::__construct();
		
		$this->load->model('Dashboard_model');
		
	}
	
	public function getAll() {
		
		//$data="";
		
		$data=$this->Dashboard_model->getlist_Setting();
		
		echo json_encode($data);
				
	}
	public function getDashboard($Id = NULL) {
		
		if (!empty($Id)) {
			$AllData = $this->Dashboard_model->getDashboard($Id);
			echo json_encode($AllData);			
		}
	}
	public function getLearnerCourses($Id = NULL) {
		
		if (!empty($Id)) {
			$data['learnerCourses'] = $this->Dashboard_model->getLearnerCourses($Id);
			$data['announcementTypes']=$this->Dashboard_model->getAnnouncementTypes();	
			echo json_encode($data);			
		}
	}
	public function getCalendarDetails($Id = NULL) {
		
		if (!empty($Id)) {
		  $AllData = $this->Dashboard_model->getCalendarDetails($Id);
		  echo json_encode($AllData);			
		}
	  }
	  public function getLearnerActivities($Id = NULL) {
		
			if (!empty($Id)) {
				$AllData = $this->Dashboard_model->getLearnerActivities($Id);
				echo json_encode($AllData);			
			}
		}
		

		/*################ RECENT INVITATION  START ##############*/
		public function getRecentInvitation() {
		
			$invitation = $this->Dashboard_model->getRecentInvitation();
		
				if($invitation)
				{
					echo json_encode($invitation);		
				}
		}
		/*################ RECENT INVITATION  END ##############*/

		/*################ RECENT INVITATION  START ##############*/
		public function getRecentActivity($UserId) {
	
			$activity = $this->Dashboard_model->getRecentActivity($UserId);
			
			
				if($activity)
				{
					echo json_encode($activity);		
				}
		}
		/*################ RECENT INVITATION  END ##############*/

		/*################ TOP INSTRUCTORS  START ##############*/
		public function getTopInstructors() {
	
			$instructors = $this->Dashboard_model->getTopInstructors();
			
			if($instructors)
			{
				echo json_encode($instructors);		
			}
		}
		/*################ TOP INSTRUCTORS  END ##############*/

		/*################ GET INSTRUCTORS DASHBOARD START ##############*/
		public function getInstructorDashboard($UserId) {

			$instructorsdata = $this->Dashboard_model->getInstructorDashboard($UserId);
			
			if($instructorsdata)
			{
				echo json_encode($instructorsdata);		
			}
		}
		 /*################ GET INSTRUCTORS DASHBOARD END ##############*/

		/*################ GET INSTRUCTORS DASHBOARD START ##############*/
		public function getLearnerDashboard($UserId) {

		//	$UserId=484;
			
			$learnerdata = $this->Dashboard_model->getLearnerDashboard($UserId);
			
			if($learnerdata)
			{
			echo json_encode($learnerdata);		
			}
		}
		 /*################ GET INSTRUCTORS DASHBOARD END ##############*/

		 public function getTopLearner()
		 {
			$learnerdata = $this->Dashboard_model->getTopLearner();
			
		 }
		
	
	
}
