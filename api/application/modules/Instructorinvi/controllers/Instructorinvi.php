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

		if (!empty($type)) {

			$result = [];
			$result = $this->Instructorinvi_model->EditInstRequest($type, $CourseSessionId, $UserId);
			if ($result) {
				if ($type == 1) {
					// Send Mail 
					//Followers
					$this->db->select('FollowerUserId');
					$this->db->where('InstructorUserId',$UserId);
					$this->db->from('tblinstructorfollowers');
					$follower = $this->db->get();
					if ($follower) {
						return true;
					} else {
						return false;
					}

					//learners
					$this->db->select('CourseUserregisterId');
					$this->db->where('UserId',$UserId);
					$this->db->from('tblinstructorfollowers');
					$learner = $this->db->get();
					if ($learner) {
						return true;
					} else {
						return false;
					}

					//Primary Instructor
					

				}
			}
			echo json_encode($result);
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
