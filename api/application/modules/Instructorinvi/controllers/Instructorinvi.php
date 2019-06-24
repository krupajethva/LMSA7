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

	public function InstRequest($type = NULL, $CourseSessionId = NULL, $UserId = NULL)
	{

		//if (!empty($type)) {

		//	$result = [];
		//$result = $this->Instructorinvi_model->EditInstRequest($type, $CourseSessionId, $UserId);
		//	if ($result) {
			$this->db->select('FirstName,LastName');
			$this->db->where('UserId',504);
			$this->db->from('tbluser');
			$res = $this->db->get();
			$Instructor_name = $res -> result();
			print_r($Instructor_name);

		if (1 == 1) {
			// Send Mail 
			//Followers

			$this->db->select('FollowerUserId');
			$this->db->where('InstructorUserId', 504);
			$this->db->from('tblinstructorfollowers');
			$res = $this->db->get();

			foreach ($res->result() as $follower) {
				$user = $follower->FollowerUserId;
				$data = explode(",", $user);
				foreach ($data as $dataObj) {
				//	print($dataObj); // Ahi send mail function with parameter (dataObj)
				}
			}
			//print_r($follower);
			// if ($follower) {
			// 	return true;
			// } else {
			// 	return false;
			// }

			//learners
			$this->db->select('tl.CourseUserregisterId,tl.UserId,tc.EmailAddress');
			$this->db->where('CourseSessionId', 2);
			$this->db->join('tbluser as tc', 'tl.UserId=tc.UserId');
			$this->db->from('tblcourseuserregister as tl');
			$res = $this->db->get();
			$learner = $res->result();
			// if ($learner) {
			// 	return true;
			// } else {
			// 	return false;
			// }
			//print_r($learner);

			//Primary Instructor
			$this->db->select('ti.CourseInstructorId,ti.UserId,tc.CourseId,tc.SessionName,tc.StartDate,tc.StartTime,tbc.CourseFullName');
			$this->db->where('ti.CourseSessionId', 2);
			$this->db->where('ti.Approval', 1);
			$this->db->join('tblcoursesession as tc', 'ti.CourseSessionId=tc.CourseSessionId');
			$this->db->join('tblcourse as tbc', 'tc.CourseId=tbc.CourseId');
			$this->db->from('tblcourseinstructor as ti');
			$res = $this->db->get();
			$Primary_inst = $res->result();
			// if ($Primary_inst) {
			// 	return true;
			// } else {
			// 	return false;
			// }
				print_r($Primary_inst);
		}
		//}
		echo json_encode($result);
		//}
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
