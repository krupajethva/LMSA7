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

	public function AcceptorDecline($type = NULL, $CourseSessionId = NULL, $UserId = NULL)
	{
	

		$data = $this->Instructorinvi_model->getlist_course();

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
				print_r($Instructor_name);

				$this->db->select('ts.SessionName,ts.StartDate,ts.StartTime,ts.CourseId,tc.CourseFullName');
				$this->db->where('CourseSessionId', $CourseSessionId);
				$this->db->join('tblcourse as tc', 'tc.CourseId = ts.CourseId');
				$this->db->from('tblcoursesession as ts');
				$res = $this->db->get()->result();
				$SessionName = $res['0']->SessionName;
				$StartDate = $res['0']->StartDate;
				$StartTime = $res['0']->StartTime;
				$CourseFullName = $res['0']->CourseFullName;
				//print_r($res);

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

							$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

							foreach ($query->result() as $row) {
								$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $dataObj);
								$rowTo = $queryTo->result();
								$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
								$body = $row->EmailBody;

								if ($row->BccEmail != '') {
									$bcc = $row->BccEmail . ',' . $row->totalbcc;
								} else {
									$bcc = $row->totalbcc;
								}
								$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
								$body = str_replace("{ SessionName }", $SessionName, $body);
								$body = str_replace("{ StartDate }", $StartDate, $body);
								$body = str_replace("{ StartTime }", $StartTime, $body);
								$body = str_replace("{ InstructorName }", $Instructor_name, $body);
								//	$body = str_replace("{login_url}",$StartTime,$body);
								//$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);

								$this->email->from($smtpEmail, 'LMS Admin');
								$this->email->to($rowTo[0]->EmailAddress);
								$this->email->subject($row->Subject);
								$this->email->cc($row->totalcc);
								$this->email->bcc($bcc);
								$this->email->message($body);
								if ($this->email->send()) {
									$email_log = array(
										'From' => trim($smtpEmail),
										'Cc' => '',
										'Bcc' => '',
										'To' => trim($rowTo[0]->EmailAddress),
										'Subject' => trim($row->Subject),
										'MessageBody' => trim($body),
									);
									$res = $this->db->insert('tblemaillog', $email_log);
								} else {
									//echo json_encode("Fail");
								}
							}
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
						//send mail
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $learner->UserId);
						$rowTo = $queryTo->result();
						$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
						$body = $row->EmailBody;

						if ($row->BccEmail != '') {
							$bcc = $row->BccEmail . ',' . $row->totalbcc;
						} else {
							$bcc = $row->totalbcc;
						}
						$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
						$body = str_replace("{ SessionName }", $SessionName, $body);
						$body = str_replace("{ StartDate }", $StartDate, $body);
						$body = str_replace("{ StartTime }", $StartTime, $body);
						$body = str_replace("{ InstructorName }", $Instructor_name, $body);
						//	$body = str_replace("{login_url}",$StartTime,$body);
						//$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);

						$this->email->from($smtpEmail, 'LMS Admin');
						$this->email->to($rowTo[0]->EmailAddress);
						$this->email->subject($row->Subject);
						$this->email->cc($row->totalcc);
						$this->email->bcc($bcc);
						$this->email->message($body);
						if ($this->email->send()) {
							$email_log = array(
								'From' => trim($smtpEmail),
								'Cc' => '',
								'Bcc' => '',
								'To' => trim($rowTo[0]->EmailAddress),
								'Subject' => trim($row->Subject),
								'MessageBody' => trim($body),
							);
							$res = $this->db->insert('tblemaillog', $email_log);
						} else {
							//echo json_encode("Fail");
						}
					}
					//	print_r($learner);

					//Primary Instructor
					$this->db->select('ti.CourseInstructorId,ti.UserId');
					$this->db->where('ti.CourseSessionId', $CourseSessionId);
					$this->db->where('ti.Approval', 1);
					$this->db->from('tblcourseinstructor as ti');
					$Primary_inst = $this->db->get()->result();

					foreach ($Primary_inst as $Primary_inst) {
						//send mail
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $Primary_inst->UserId);
						$rowTo = $queryTo->result();
						$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
						$body = $row->EmailBody;

						if ($row->BccEmail != '') {
							$bcc = $row->BccEmail . ',' . $row->totalbcc;
						} else {
							$bcc = $row->totalbcc;
						}
						$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
						$body = str_replace("{ SessionName }", $SessionName, $body);
						$body = str_replace("{ StartDate }", $StartDate, $body);
						$body = str_replace("{ StartTime }", $StartTime, $body);
						$body = str_replace("{ InstructorName }", $Instructor_name, $body);
						//	$body = str_replace("{login_url}",$StartTime,$body);
						//$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);

						$this->email->from($smtpEmail, 'LMS Admin');
						$this->email->to($rowTo[0]->EmailAddress);
						$this->email->subject($row->Subject);
						$this->email->cc($row->totalcc);
						$this->email->bcc($bcc);
						$this->email->message($body);
						if ($this->email->send()) {
							$email_log = array(
								'From' => trim($smtpEmail),
								'Cc' => '',
								'Bcc' => '',
								'To' => trim($rowTo[0]->EmailAddress),
								'Subject' => trim($row->Subject),
								'MessageBody' => trim($body),
							);
							$res = $this->db->insert('tblemaillog', $email_log);
						} else {
							//echo json_encode("Fail");
						}
					}
					print_r($Primary_inst);
				}

				if ($type == 2) {
					$this->db->select('ti.CourseInstructorId,ti.UserId');
					$this->db->where('ti.CourseSessionId', $CourseSessionId);
					$this->db->where('ti.Approval', 1);
					$this->db->from('tblcourseinstructor as ti');
					$Primary_inst = $this->db->get()->result();

					foreach ($Primary_inst as $Primary_inst) {
						//send mail
						$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $Primary_inst->UserId);
						$rowTo = $queryTo->result();
						$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
						$body = $row->EmailBody;

						if ($row->BccEmail != '') {
							$bcc = $row->BccEmail . ',' . $row->totalbcc;
						} else {
							$bcc = $row->totalbcc;
						}
						$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
						$body = str_replace("{ SessionName }", $SessionName, $body);
						$body = str_replace("{ StartDate }", $StartDate, $body);
						$body = str_replace("{ StartTime }", $StartTime, $body);
						$body = str_replace("{ InstructorName }", $Instructor_name, $body);
						//	$body = str_replace("{login_url}",$StartTime,$body);
						//$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);

						$this->email->from($smtpEmail, 'LMS Admin');
						$this->email->to($rowTo[0]->EmailAddress);
						$this->email->subject($row->Subject);
						$this->email->cc($row->totalcc);
						$this->email->bcc($bcc);
						$this->email->message($body);
						if ($this->email->send()) {
							$email_log = array(
								'From' => trim($smtpEmail),
								'Cc' => '',
								'Bcc' => '',
								'To' => trim($rowTo[0]->EmailAddress),
								'Subject' => trim($row->Subject),
								'MessageBody' => trim($body),
							);
							$res = $this->db->insert('tblemaillog', $email_log);
						} else {
							//echo json_encode("Fail");
						}
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
