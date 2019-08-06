<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Reminder extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reminder_model');
	}
	public function InstructorBeforeDays()
	{
		//$data="";
		$smtpDetails = getSmtpDetails(); //get smtp details 
		$data = $this->Reminder_model->getlist_InstructorBeforeDays();
		if ($data) {
			$Day = $data->Value;
			$datetime1 = date('Y-m-d', strtotime('+' . $Day . 'days'));
			$lastdata = $this->Reminder_model->getlist_Instructor($datetime1);
			print_r($lastdata);
			if ($lastdata) {
				$ress = array();
				foreach ($lastdata as $users) {
					$userId = $users->UserId;
					$CourseFullName = $users->CourseFullName;
					$StartDate = $users->StartDate;
					$StartTime = $users->StartTime;
					$FirstName = $users->FirstName;
					$FollowerUserId = explode(",", $users->UserId);
					foreach ($FollowerUserId as $id) {
						array_push($ress, $id);
					}
					foreach ($ress as $id) {

						// print_r($EmailAddress=$users['EmailAddress']);
						$res=new stdClass();
						$res->loginUrl = BASE_URL.'/login/';
						$res->CourseFullName = $users->CourseFullName;
						$res->StartDate = $users->StartDate;
						$res->StartTime = $users->StartTime;
						$res->InstructorName = $users->FirstName;
						$EmailToken = 'Instructor should get an email before X days';
						$EmailDetails = getEmailDetails($EmailToken,$id); //get email details by user id
						$body = $EmailDetails['EmailBody'];
						$FormattedBody = getFormattedBody($res ,$body);
						
						// send email to particular email
						$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
						
					}
				}
				echo json_encode($lastdata);
				//}
			} else {
				echo json_encode('error');
			}
		}
	}







	public function getStartDate()
	{
		//$data="";

		$data = $this->Reminder_model->getlist_CourseStartDate();
		if ($data) {

			// foreach($data as $days)
			// { 
			//date_default_timezone_set("GMT");
			// 	   $houra=$Hours['Value'];
			// 	  //$time= strtotime('-'.$houra. 'hour');
			// 	  date_default_timezone_set("Asia/Kolkata");
			// 	  $timestamp = date('H:i:s', time() - (3600*$houra));

			//    echo  $lastemail = date('H:i:00',time() + 900);
			// 	 $date=date('Y-m-d');
			$Day = $data->Value;
			//$Day=$days['Value'];
			echo	$datetime1 = date('Y-m-d', strtotime('+' . $Day . 'days'));

			$lastdata = $this->Reminder_model->getlist_emailvalue($datetime1);
			$smtpDetails = getSmtpDetails(); //get smtp details 
			//print_r($lastdata);
			if ($lastdata) {
				foreach ($lastdata as $users) {
					$userId = $users->UserId;
					// print_r($EmailAddress=$users['EmailAddress']);

					$res=new stdClass();
					$res->loginUrl = BASE_URL.'/login/';
					$res->CourseFullName = $users->CourseFullName;
					$res->StartDate = $users->StartDate;
					$res->StartTime = $users->StartTime;
					$res->InstructorName = $users->FirstName;
					$EmailToken = 'Course Start Reminder For Learner';
					$EmailDetails = getEmailDetails($EmailToken,$userId); //get email details by user id
					$body = $EmailDetails['EmailBody'];
                    $FormattedBody = getFormattedBody($res ,$body);
					
					// send email to particular email
                    $send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
				}
				echo json_encode($lastdata);
				//}
			} else {
				echo json_encode('error');
			}
			$lastdata1 = $this->Reminder_model->getlist_Followvalue($datetime1);
			//	print_r($lastdata1);
			if ($lastdata1) {

				$data = $this->db->query('SELECT UserId FROM tblcoursesession AS cs 
				LEFT JOIN tblcourseinstructor AS cin ON
				 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId=' . $lastdata1->CourseSessionId);
				$ress = array();
				foreach ($data->result() as $row) {
					//print_r($ress);
					$data1 = $this->db->query('
						 SELECT FollowerUserId FROM tblinstructorfollowers AS cs WHERE cs.InstructorUserId=' . $row->UserId);

					foreach ($data1->result() as $row1) {
						if ($row1->FollowerUserId != '') {
							$FollowerUserId = explode(",", $row1->FollowerUserId);
							foreach ($FollowerUserId as $id) {
								array_push($ress, $id);
							}
						}
					}
				}

				$ress = array_unique($ress);
				print_r($ress);
				foreach ($ress as $users) {

					$res=new stdClass();
					$res->loginUrl = BASE_URL.'/login/';
					$res->CourseFullName = $lastdata1->CourseFullName;
					$res->StartDate = $lastdata1->StartDate;
					$res->StartTime = $lastdata1->StartTime;
					$res->InstructorName = $lastdata1->FirstName;
					$EmailToken = 'Instructor Followers Session Start';
					$EmailDetails = getEmailDetails($EmailToken,$users); //get email details by user id
					$body = $EmailDetails['EmailBody'];
                    $FormattedBody = getFormattedBody($res ,$body);
					
					// send email to particular email
					$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
				}
				echo json_encode($lastdata1);
				//}
			} else {
				echo json_encode('error');
			}
			//}
		}
	}
}
