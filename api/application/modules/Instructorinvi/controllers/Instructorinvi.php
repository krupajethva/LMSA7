<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Instructorinvi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Instructorinvi_model');
	}

	public function AcceptorDecline($CourseSessionId = NULL, $UserId = NULL)
	{
	

		$data = $this->Instructorinvi_model->getlist_course($CourseSessionId,$UserId);

		echo json_encode($data);
	}

	public function InstRequest($type = NULL, $CourseSessionId = NULL, $UserId = NULL)
	{
		if (!empty($type)) {
			$result = [];
			$result = $this->Instructorinvi_model->EditInstRequest($type, $CourseSessionId, $UserId);
			if ($result) {
				$this->db->select('FirstName,LastName');
				$this->db->where('UserId', $UserId);
				$this->db->from('tbluser');
				$result_Inst = $this->db->get()->result();
				$Instructor_name = $result_Inst['0']->FirstName . " " . $result_Inst['0']->LastName;
			//	print_r($Instructor_name);

				$this->db->select('ts.SessionName,ts.StartDate,ts.StartTime,ts.CourseId,tc.CourseFullName');
				$this->db->where('CourseSessionId', $CourseSessionId);
				$this->db->join('tblcourse as tc', 'tc.CourseId = ts.CourseId');
				$this->db->from('tblcoursesession as ts');
				$res = $this->db->get()->result();
				$result=new stdClass();
				$result->loginUrl = BASE_URL . '/login/';
				$result->SessionName = $res['0']->SessionName;
				$result->StartDate = $res['0']->StartDate;
				$result->StartTime = $res['0']->StartTime;
				$result->CourseFullName = $res['0']->CourseFullName;
				$result->InstructorName = $Instructor_name;
			//	print_r($res);

				$EmailToken = 'Course Republished Instructor';

				$this->db->select('Value');
				$this->db->where('Key', 'EmailFrom');
				$smtp1 = $this->db->get('tblmstconfiguration');
				foreach ($smtp1->result() as $row) {
					$smtpEmail = $row->Value;
				}
				$this->db->select('Value');
				$this->db->where('Key', 'EmailPassword');
				$smtp2 = $this->db->get('tblmstconfiguration');
				foreach ($smtp2->result() as $row) {
					$smtpPassword = $row->Value;
				}

				$config['protocol'] = PROTOCOL;
				$config['smtp_host'] = SMTP_HOST;
				$config['smtp_port'] = SMTP_PORT;
				$config['smtp_user'] = $smtpEmail;
				$config['smtp_pass'] = $smtpPassword;

				$config['charset'] = 'utf-8';
				$config['newline'] = "\r\n";
				$config['mailtype'] = 'html';
				$this->email->initialize($config);

				$smtpDetails = getSmtpDetails(); //get smtp details 
				if ($type == 1) {
					// Send Mail 
					//Followers

					$this->db->select('tf.FollowerUserId,tc.CourseId,tc.SessionName,tc.StartDate,tc.StartTime,tbc.CourseFullName');
					$this->db->where('InstructorUserId', $UserId);
					$this->db->join('tblcoursesession as tc', 'tc.CourseSessionId =2');
					$this->db->join('tblcourse as tbc', 'tc.CourseId=tbc.CourseId');
					$this->db->from('tblinstructorfollowers as tf');

					foreach ($this->db->get()->result() as $follower) {
						$user = $follower->FollowerUserId;
						$data = explode(",", $user);
						foreach ($data as $dataObj) {
							$EmailDetails = getEmailDetails($EmailToken,$dataObj); //get email details by user id
							$body = $EmailDetails['EmailBody'];
							$FormattedBody = getFormattedBody($result ,$body);
							
							// send email to particular email
							$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
						}
					}
					//print_r($follower);

					//learners
					$this->db->select('tl.CourseUserregisterId,tl.UserId');
					$this->db->where('CourseSessionId', $CourseSessionId);
					$this->db->join('tbluser as tb', 'tl.UserId=tb.UserId');
					$this->db->from('tblcourseuserregister as tl');
					$learner = $this->db->get()->result();

					foreach ($learner as $learner) {
						$EmailDetails = getEmailDetails($EmailToken,$learner->UserId); //get email details by user id
						$body = $EmailDetails['EmailBody'];
						$FormattedBody = getFormattedBody($result ,$body);
						
						// send email to particular email
						$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
					}
					//	print_r($learner);

					//Primary Instructor
					$this->db->select('ti.CourseInstructorId,ti.UserId');
					$this->db->where('ti.CourseSessionId', $CourseSessionId);
					$this->db->where('ti.Approval', 1);
					$this->db->from('tblcourseinstructor as ti');
					$Primary_inst = $this->db->get()->result();

					foreach ($Primary_inst as $Primary_inst) {
						$EmailDetails = getEmailDetails($EmailToken,$Primary_inst->UserId); //get email details by user id
						$body = $EmailDetails['EmailBody'];
						$FormattedBody = getFormattedBody($result ,$body);
						
						// send email to particular email
						$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
					}
					//print_r($Primary_inst);
				}

				if ($type == 2) {
					$this->db->select('ti.CourseInstructorId,ti.UserId');
					$this->db->where('ti.CourseSessionId', $CourseSessionId);
					$this->db->where('ti.Approval', 1);
					$this->db->from('tblcourseinstructor as ti');
					$Primary_inst = $this->db->get()->result();

					foreach ($Primary_inst as $Primary_inst) {
						
						$EmailDetails = getEmailDetails($EmailToken,$Primary_inst->UserId); //get email details by user id
						$body = $EmailDetails['EmailBody'];
						$FormattedBody = getFormattedBody($result ,$body);
						
						// send email to particular email
						$send = SendEmail($smtpDetails['smtpEmail'], $EmailDetails['To'], $EmailDetails['Cc'], $EmailDetails['Bcc'], $EmailDetails['Subject'], $FormattedBody);
					
					}
				}
			}
		}
}
	public function getAllCourse()
	{

		$data = $this->Instructorinvi_model->getlist_course();

		echo json_encode($data);
	}

	public function getAllInstructor()
	{

		$data = $this->Instructorinvi_model->getlist_instructor();

		echo json_encode($data);
	}
	public function getAllInstructorInvi()
	{

		$data = $this->Instructorinvi_model->get_instructorinvi();

		echo json_encode($data);
	}
	// public function addInstructor()
	// {

	// 	$post_Instructor = json_decode(trim(file_get_contents('php://input')), true);
	// 	if ($post_Instructor) 
	// 		{
	// 				$result = $this->Instructorinvi_model->add_Instructor($post_Instructor);
	// 				if($result)
	// 				{
	// 					echo json_encode($post_Instructor);	
	// 				}	


	// 		}
	// }

	public function addInstructor()
	{

		$post_Instructor = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Instructor) {

			$result = $this->Instructorinvi_model->add_Instructor($post_Instructor);
			if ($result) {

				$config['protocol']  = 'smtp';
				$config['smtp_host'] = 'ssl://smtp.googlemail.com';
				$config['smtp_port'] = '465';
				$config['smtp_user'] = 'myopeneyes3937@gmail.com';
				$config['smtp_pass'] = 'W3lc0m3@2018';

				$config['charset'] = 'utf-8';
				$config['newline'] = "\r\n";
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				foreach ($post_Instructor['UserId'] as $row) {

					$this->db->select('Code,CourseId,UserId');
					$this->db->where('UserId', $row);
					$Codee = $this->db->get('courseinstructorinvitation');
					$Code = $Codee->result()[0]->Code;

					$this->db->select('EmailAddress,RoleId,UserId');
					$this->db->where('UserId', $row);
					$Uemail = $this->db->get('tbluser');
					$email = $Uemail->result()[0]->EmailAddress;

					$this->email->from('myopeneyes3937@gmail.com', 'LMS');
					$this->email->to($email);
					$subject = 'LMS - Invitation Code';
					$this->email->subject($subject);
					$body = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:22px; color:#000; border:1px solid #0333; width:600px; margin:0 auto;" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<p>Invitation code : ' . $Code . '</p>
								</tr>
							</tbody>
						</table>';
					$this->email->message($body);
					$this->email->send();
				}
				echo json_encode("success");
			} else {
				echo json_encode("email duplicate");
			}
		}
	}
	public function ReInvite()
	{
		$post_Instructor = json_decode(trim(file_get_contents('php://input')), true);
		if (!empty($post_Instructor)) {

			$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$res = "";
			for ($i = 0; $i < 6; $i++) {
				$res .= $chars[mt_rand(0, strlen($chars) - 1)];
			}
			$post_Instructor['Code'] = $res;
			$result = $this->Instructorinvi_model->ReInvite_Instructor($post_Instructor);
			$row = $post_Instructor['UserId'];
			if ($result) {
				$config['protocol']  = 'smtp';
				$config['smtp_host'] = 'ssl://smtp.googlemail.com';
				$config['smtp_port'] = '465';
				$config['smtp_user'] = 'myopeneyes3937@gmail.com';
				$config['smtp_pass'] = 'W3lc0m3@2018';
				$config['charset'] = 'utf-8';
				$config['newline'] = "\r\n";
				$config['mailtype'] = 'html';
				$this->email->initialize($config);

				$this->db->select('EmailAddress,RoleId,UserId');
				$this->db->where('UserId', $row);
				$Uemail = $this->db->get('tbluser');
				$email = $Uemail->result()[0]->EmailAddress;

				$this->email->from('myopeneyes3937@gmail.com', 'LMS');
				$this->email->to($email);
				$subject = 'LMS - Invitation Code';
				$this->email->subject($subject);

				$body = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:22px; color:#000; border:1px solid #0333; width:600px; margin:0 auto;" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<p>Invitation code : ' . $res . '</p>
						
								</tr>
								
							</tbody>
						</table>';

				$this->email->message($body);
				$this->email->send();

				echo json_encode("success");
			} else {
				echo json_encode("error");
			}
		}
	}
}
