<?php

use \Firebase\JWT\JWT;

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';

class InstructorCourses extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('InstructorCourses_model');
	}
	public function getSearchCourseList()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if (!empty($data)) {

			$result = [];
			$res['course'] = $this->InstructorCourses_model->getSearchCourseList($data);
			echo json_encode($res);
		}
	}
	public function getAllParent()
	{
		$data['sub'] = $this->InstructorCourses_model->getlist_SubCategory();
		$data['coursestarthours'] = $this->InstructorCourses_model->getlist_CourseStartHours();
		$data['courseendhours'] = $this->InstructorCourses_model->getlist_CourseEndHours();
		echo json_encode($data);
	}
	public function getAllCourse($UserId = NULL)
	{
		if (!empty($UserId)) {
			$result = [];
			$data['course'] = $this->InstructorCourses_model->getlist_Course($UserId);

			echo json_encode($data);
		}
	}
	public function getAllCourseClone($CourseId = NULL)
	{
		if (!empty($CourseId)) {
			$result = [];
			$data = $this->InstructorCourses_model->getlist_CourseClone($CourseId);

			echo json_encode($data);
		}
	}
	public function updatePublish($CourseSessionId = NULL)
	{
		if (!empty($CourseSessionId)) {

			$data = $this->InstructorCourses_model->updatePublish($CourseSessionId);
			$instdata = $this->InstructorCourses_model->updateinstdata($CourseSessionId);
			if ($instdata) {
				$Coursedata = $this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
				GROUP_CONCAT(cs.UserId) as UserId,
				 (SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
						FROM tblcoursesession AS csi 
						LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
						LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
						WHERE csi.CourseSessionId=' . $CourseSessionId . ' GROUP BY csi.CourseSessionId');
				foreach ($Coursedata->result() as $Cdata) {
					foreach ($instdata as $users) {

						$CourseFullName = $Cdata->CourseFullName;
						$StartDate = $Cdata->StartDate;
						$StartTime = $Cdata->StartTimeChange;
						$InstructorName = $Cdata->FirstName;
						// print_r($EmailAddress=$users['EmailAddress']);
						$EmailToken = 'Course Published Instructor';
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

						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

						foreach ($query->result() as $row) {
							if ($row->To == 4 || $row->To == 3) {
								$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $users);
								$rowTo = $queryTo->result();
								$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
								$body = $row->EmailBody;

								if ($row->BccEmail != '') {
									$bcc = $row->BccEmail . ',' . $row->totalbcc;
								} else {
									$bcc = $row->totalbcc;
								}
								$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
								$body = str_replace("{ StartDate }", $StartDate, $body);
								$body = str_replace("{ StartTime }", $StartTime, $body);
								$body = str_replace("{ InstructorName }", $InstructorName, $body);
								//	$body = str_replace("{login_url}",$StartTime,$body);
								$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
									echo json_encode("Fail");
								}
							} else {
								$userId_ar = explode(',', $row->totalTo);
								foreach ($userId_ar as $userId) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;

									$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
									$body = str_replace("{ StartDate }", $StartDate, $body);
									$body = str_replace("{ StartTime }", $StartTime, $body);
									$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
									$this->email->from($smtpEmail, 'LMS Admin');
									$this->email->to($rowTo[0]->EmailAddress);
									$this->email->subject($row->Subject);
									$this->email->cc($row->totalcc);
									$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
										//echo 'fail';
									}
								}
							}
						}
					}
				}
				// echo json_encode($instdata);
				//}
			} else {
				//echo json_encode('error');
			}
			if ($data) {
				$Coursedata = $this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
					GROUP_CONCAT(cs.UserId) as UserId,
					 (SELECT GROUP_CONCAT(u.FirstName)
								  FROM tbluser u 
								  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
							FROM tblcoursesession AS csi 
							LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
							LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
							WHERE csi.CourseSessionId=' . $CourseSessionId . ' GROUP BY csi.CourseSessionId');
				foreach ($Coursedata->result() as $Cdata) {
					foreach ($data as $users) {

						$CourseFullName = $Cdata->CourseFullName;
						$StartDate = $Cdata->StartDate;
						$StartTime = $Cdata->StartTimeChange;
						$InstructorName = $Cdata->FirstName;
						// print_r($EmailAddress=$users['EmailAddress']);
						$EmailToken = 'Course Published Followers';
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

						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

						foreach ($query->result() as $row) {
							if ($row->To == 4 || $row->To == 3) {
								$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $users);
								$rowTo = $queryTo->result();
								$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
								$body = $row->EmailBody;

								if ($row->BccEmail != '') {
									$bcc = $row->BccEmail . ',' . $row->totalbcc;
								} else {
									$bcc = $row->totalbcc;
								}
								$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
								$body = str_replace("{ StartDate }", $StartDate, $body);
								$body = str_replace("{ StartTime }", $StartTime, $body);
								$body = str_replace("{ InstructorName }", $InstructorName, $body);
								//	$body = str_replace("{login_url}",$StartTime,$body);
								$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
									echo json_encode("Fail");
								}
							} else {
								$userId_ar = explode(',', $row->totalTo);
								foreach ($userId_ar as $userId) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;

									$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
									$body = str_replace("{ StartDate }", $StartDate, $body);
									$body = str_replace("{ StartTime }", $StartTime, $body);

									$this->email->from($smtpEmail, 'LMS Admin');
									$this->email->to($rowTo[0]->EmailAddress);
									$this->email->subject($row->Subject);
									$this->email->cc($row->totalcc);
									$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
										//echo 'fail';
									}
								}
							}
						}
					}
				}
				echo json_encode($data);
				//}
			} else {
				echo json_encode('error');
			}
			//	print_r($data);		
			//echo json_encode($data);	
		}
	}
	public function getAllSession()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if (!empty($data)) {

			$data = $this->InstructorCourses_model->getlist_session($data);

			echo json_encode($data);
		}
	}

	// public function test()
	// {
	// 	$result = $this->db->query('select csi.IsActive,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.SessionStatus,csi.EndDate,csi.TotalSeats,csi.CourseSessionId,csi.RemainingSeats,csi.Showstatus,csi.CourseCloseDate,csi.PublishStatus,
	// 	GROUP_CONCAT(cs.UserId) as UserId,(SELECT COUNT(mc.CourseUserregisterId) FROM tblcourseuserregister as mc WHERE mc.UserId=484 AND  mc.CourseSessionId=csi.CourseSessionId) as EnrollCheck,
	// 	 (SELECT GROUP_CONCAT(u.FirstName,u.LastName)
	// 				  FROM tbluser u 
	// 				  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
	// 			FROM tblcoursesession AS csi 
	// 			LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
	// 			WHERE csi.CourseId=30 GROUP BY csi.CourseSessionId');
	// 	$db_error = $this->db->error();
	// 	if (!empty($db_error) && !empty($db_error['code'])) {
	// 		throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
	// 		return false; // unreachable return statement !!!
	// 	}
	// 	if ($result->result()) {
	// 		$res = $result->result();
	// 		foreach ($res as $row) {
	// 			$UserID = explode(",", $row->UserId);
	// 			$this->db->select('tc.FirstName,tc.LastName,tc.EmailAddress,ti.Approval');
	// 			$this->db->join('tblcourseinstructor as ti', 'ti.UserId = tc.UserId','inner');
	// 			$this->db->where_in('tc.UserId', $UserID);
	// 			$this->db->where_in('ti.CourseSessionId', $row->CourseSessionId);
	// 			$this->db->from('tbluser as tc');
	// 			$new_array = $this->db->get()->result();
	// 			$row->userdetails = $new_array;
	// 		}
	// 	}
	// 	print_r($res);
	// }

	public function Instructor_Invite()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if (!empty($data)) {
			$res = $this->InstructorCourses_model->Instructor_Invite($data);
			//echo json_encode($res);
			if ($data['type'] == "Revoke") {
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

				$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");
				foreach ($query->result() as $row) {
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $data['UserId']);
					$rowTo = $queryTo->result();
					$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					$body = $row->EmailBody;
					if ($row->BccEmail != '') {
						$bcc = $row->BccEmail . ',' . $row->totalbcc;
					} else {
						$bcc = $row->totalbcc;
					}
					$body = str_replace("{ CourseFullName }", $res->CourseFullName, $body);
					$body = str_replace("{ SessionName }", $res->SessionName, $body);
					$body = str_replace("{ StartDate }", $res->StartDate, $body);
					$body = str_replace("{ StartTime }", $res->StartTime, $body);
					$body = str_replace("{ InstructorName }", $res->Instructor_name, $body);
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
				echo json_encode("success");
			} else {
				$EmailToken = 'Instructor Invitation';
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

				$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");
				foreach ($query->result() as $row) {
					$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $data['UserId']);
					$rowTo = $queryTo->result();
					$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
					$body = $row->EmailBody;
					if ($row->BccEmail != '') {
						$bcc = $row->BccEmail . ',' . $row->totalbcc;
					} else {
						$bcc = $row->totalbcc;
					}
					$body = str_replace("{ CourseFullName }", $res->CourseFullName, $body);
					$body = str_replace("{ SessionName }", $res->SessionName, $body);
					$body = str_replace("{ StartDate }", $res->StartDate, $body);
					$body = str_replace("{ StartTime }", $res->StartTime, $body);
					$body = str_replace("{ InstructorName }", $res->Instructor_name, $body);

					$data1['CourseSessionId'] = $res->CourseSessionId;
					$data2['CourseSessionId'] = $res->CourseSessionId;
					$data1['UserId'] = $data['UserId'];
					$data2['UserId'] = $data['UserId'];
					$data1['type'] = 1;
					$data2['type'] = 2;
					$body = str_replace("{ link1 }",'' .BASE_URL.'/instructor-invitation/'.JWT::encode($data1,"MyGeneratedKey", "HS256").'',$body);
					$body = str_replace("{ link2 }",''.BASE_URL.'/instructor-invitation/'.JWT::encode($data2,"MyGeneratedKey","HS256").'',$body);
				
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
						echo json_encode("Fail");
					}
				}
				echo json_encode("success");
			}
		}
	}

	public function StartSession($CourseSessionId = NULL,$UserId= NULL)
	{
		if (!empty($CourseSessionId)) {

			$data = $this->InstructorCourses_model->StartSession($CourseSessionId,$UserId);
			echo json_encode($data);
		}
	}
	public function EndSession($CourseSessionId = NULL)
	{
		if (!empty($CourseSessionId)) {

			$data = $this->InstructorCourses_model->EndSession($CourseSessionId);
			if ($data) {
				$resultTo = $this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
						csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime, 
						(SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cin.UserId))) as instName 
						FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
						LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
						LEFT JOIN  tblcourseinstructor AS cin ON cin.CourseSessionId = Creg.CourseSessionId
						LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
						 WHERE
						 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=' . $CourseSessionId . ' GROUP BY us.EmailAddress');
				$ToEmailAddress = $resultTo->result();
				if ($resultTo) {
					$array = array();
					foreach ($ToEmailAddress as $toEmail) {
						array_push($array, $toEmail->UserId);
						//	$ToEmailAddressString = implode(",", $array);
						$CourseFullName = $toEmail->CourseFullName;
						$InstructorName = $toEmail->instName;

						// print_r($EmailAddress=$users['EmailAddress']);
						$EmailToken = 'Course Completed';
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

						$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

						foreach ($query->result() as $row) {
							if ($row->To == 4 || $row->To == 3) {
								$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $toEmail->UserId);
								$rowTo = $queryTo->result();
								$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
								$body = $row->EmailBody;

								if ($row->BccEmail != '') {
									$bcc = $row->BccEmail . ',' . $row->totalbcc;
								} else {
									$bcc = $row->totalbcc;
								}
								$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
								$body = str_replace("{ InstructorName }", $InstructorName, $body);
								$body = str_replace("{login_url}", $StartTime, $body);
								$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
									echo json_encode("Fail");
								}
							} else {
								$userId_ar = explode(',', $row->totalTo);
								foreach ($userId_ar as $userId) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;
									$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
									$body = str_replace("{ InstructorName }", $InstructorName, $body);

									$this->email->from($smtpEmail, 'LMS Admin');
									$this->email->to($rowTo[0]->EmailAddress);
									$this->email->subject($row->Subject);
									$this->email->cc($row->totalcc);
									$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
										echo json_encode('fail');
									}
								}
							}
						}
					}
				}
			}
			echo json_encode($data);
		}
	}
	// public function updatePublish() {
	// 	$data = json_decode(trim(file_get_contents('php://input')), true);
	// 	if(!empty($CourseId['CourseId'])) {					

	// 		$result = [];
	// 		$res=$this->InstructorCourses_model->updatePublish($data);		
	// 		echo json_encode($res);				
	// 	}			

	// }addclone
	public function addclone()
	{
		$clone = json_decode(trim(file_get_contents('php://input')), true);
		if (!empty($clone)) {

			$res = $this->InstructorCourses_model->addclone($clone);
			echo json_encode($res);
		}
	}
	public function getEndHours()
	{
		//$data="";

		$data = $this->InstructorCourses_model->getlist_CourseEndHours();

		if ($data) {
			$abc = 1;
			foreach ($data as $Hours) {
				date_default_timezone_set("GMT");
				$houra = $Hours['Value'];
				//$time= strtotime('-'.$houra. 'hour');
				date_default_timezone_set("Asia/Kolkata");
				echo   $timestamp = date('H:i:s', time() - (3600 * $houra));

				$lastemail = date('H:i:00', time() + 900);
				$date = date('Y-m-d');

				//$time = date('H:i', $timestamp);
				//echo $time;//11:09
				//  $shortdate = new DateTime("@$time");  // convert UNIX timestamp to PHP DateTime
				// $dt=$shortdate->format('H:i:s');
				$data2 = $this->InstructorCourses_model->getlist_value($timestamp, $date);

				if ($data2) {
					foreach ($data2 as $users) {
						$resultTo = $this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
						csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime,
						(SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cin.UserId))) as instName 
						FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
						LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
						LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
						LEFT JOIN  tblcourseinstructor AS cin ON cin.CourseSessionId = Creg.CourseSessionId
						 WHERE
						 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=' . $users . ' GROUP BY us.EmailAddress');
						$ToEmailAddress = $resultTo->result();
						if ($resultTo) {
							$array = array();
							foreach ($ToEmailAddress as $toEmail) {
								array_push($array, $toEmail->UserId);
								//	$ToEmailAddressString = implode(",", $array);
								$CourseFullName = $toEmail->CourseFullName;
								$InstructorName = $toEmail->instName;
								// print_r($EmailAddress=$users['EmailAddress']);
								$EmailToken = 'Course Completed';
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

								$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

								foreach ($query->result() as $row) {
									if ($row->To == 4 || $row->To == 3) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $toEmail->UserId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										if ($row->BccEmail != '') {
											$bcc = $row->BccEmail . ',' . $row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ InstructorName }", $InstructorName, $body);
										$body = str_replace("{login_url}", $StartTime, $body);
										$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
											echo json_encode('Fail');
										}
									} else {
										$userId_ar = explode(',', $row->totalTo);
										foreach ($userId_ar as $userId) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
											$body = str_replace("{ StartDate }", $StartDate, $body);
											$body = str_replace("{ StartTime }", $StartTime, $body);

											$this->email->from($smtpEmail, 'LMS Admin');
											$this->email->to($rowTo[0]->EmailAddress);
											$this->email->subject($row->Subject);
											$this->email->cc($row->totalcc);
											$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
												echo json_encode('fail');
											}
										}
									}
								}
							}
						}
						// print_r($EmailAddress=$users['EmailAddress']);


					}
				}
				$lastdata = $this->InstructorCourses_model->getlist_emailvalue($lastemail, $date);

				if ($lastdata) {

					foreach ($lastdata as $users) {
						$resultTo = $this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
						csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime,
						(SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cin.UserId))) as instName 
						FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
						LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
						LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
						LEFT JOIN  tblcourseinstructor AS cin ON cin.CourseSessionId = Creg.CourseSessionId
						 WHERE
						 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=' . $users->CourseSessionId . ' GROUP BY us.EmailAddress');
						$ToEmailAddress = $resultTo->result();
						if ($resultTo) {
							$array = array();
							foreach ($ToEmailAddress as $toEmail) {
								array_push($array, $toEmail->UserId);
								//	$ToEmailAddressString = implode(",", $array);
								$CourseFullName = $toEmail->CourseFullName;
								$InstructorName = $toEmail->instName;
								// print_r($EmailAddress=$users['EmailAddress']);
								$EmailToken = 'Course End Before Reminder';
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

								$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

								foreach ($query->result() as $row) {
									if ($row->To == 4 || $row->To == 3) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $toEmail->UserId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										if ($row->BccEmail != '') {
											$bcc = $row->BccEmail . ',' . $row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ InstructorName }", $InstructorName, $body);
										$body = str_replace("{login_url}", $StartTime, $body);
										$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
											echo json_encode('Fail');
										}
									} else {
										$userId_ar = explode(',', $row->totalTo);
										foreach ($userId_ar as $userId) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
											$body = str_replace("{ InstructorName }", $InstructorName, $body);
											$body = str_replace("{login_url}", $StartTime, $body);
											$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);

											$this->email->from($smtpEmail, 'LMS Admin');
											$this->email->to($rowTo[0]->EmailAddress);
											$this->email->subject($row->Subject);
											$this->email->cc($row->totalcc);
											$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
												echo json_encode('fail');
											}
										}
									}
								}
							}
						}
						// print_r($EmailAddress=$users['EmailAddress']);


					}

					echo json_encode($lastdata);
				} else {
					echo json_encode('error');
				}
			}
		}
	}
	public function isActiveChange()
	{

		$post_data = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_data) {
			$result = $this->InstructorCourses_model->isActiveChange($post_data);
			if ($result) {
				if ($post_data['IsActive'] == 1) {

					$resultTo = $this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
			csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime, 
			GROUP_CONCAT(coin.UserId) as instUserId,
				 (SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(coin.UserId))) as instName 
			FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
			LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
			LEFT JOIN  tblcourseinstructor AS coin ON coin.CourseSessionId = csi.CourseSessionId
			LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
			 WHERE
			 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=' . $post_data["CourseSessionId"] . ' GROUP BY us.EmailAddress');
					$ToEmailAddress = $resultTo->result();
					if ($resultTo) {
						$array = array();
						foreach ($ToEmailAddress as $toEmail) {
							array_push($array, $toEmail->UserId);
							//	$ToEmailAddressString = implode(",", $array);
							$CourseFullName = $toEmail->CourseFullName;
							$StartDate = $toEmail->StartDate;
							$StartTime = $toEmail->StartTimeChange;
							$InstructorName = $toEmail->instName;
							// print_r($EmailAddress=$users['EmailAddress']);
							$EmailToken = 'Course Active Enrolees';
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

							$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

							foreach ($query->result() as $row) {
								if ($row->To == 4 || $row->To == 3) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $toEmail->UserId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;

									if ($row->BccEmail != '') {
										$bcc = $row->BccEmail . ',' . $row->totalbcc;
									} else {
										$bcc = $row->totalbcc;
									}
									$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
									$body = str_replace("{ StartDate }", $StartDate, $body);
									$body = str_replace("{ StartTime }", $StartTime, $body);
									$body = str_replace("{ InstructorName }", $InstructorName, $body);
									$body = str_replace("{login_url}", $StartTime, $body);
									$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
										echo json_encode('Fail');
									}
								} else {
									$userId_ar = explode(',', $row->totalTo);
									foreach ($userId_ar as $userId) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ StartDate }", $StartDate, $body);
										$body = str_replace("{ StartTime }", $StartTime, $body);

										$this->email->from($smtpEmail, 'LMS Admin');
										$this->email->to($rowTo[0]->EmailAddress);
										$this->email->subject($row->Subject);
										$this->email->cc($row->totalcc);
										$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
											echo json_encode('fail');
											//echo 'fail';
										}
									}
								}
							}
						}
					}
					$data = $this->db->query('SELECT UserId FROM tblcoursesession AS cs 
			LEFT JOIN tblcourseinstructor AS cin ON
			 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId=' . $post_data["CourseSessionId"]);
					$ress = array();
					foreach ($data->result() as $user) {
						$UserId = $user->UserId;

						$resultTo = $this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
			GROUP_CONCAT(cs.UserId) as UserId,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseSessionId=' . $post_data["CourseSessionId"] . ' GROUP BY csi.CourseSessionId');
						$ToEmailAddress = $resultTo->result();
						if ($resultTo) {
							$array = array();
							foreach ($ToEmailAddress as $toEmail) {
								array_push($array, $toEmail->UserId);
								//	$ToEmailAddressString = implode(",", $array);
								$CourseFullName = $toEmail->CourseFullName;
								$StartDate = $toEmail->StartDate;
								$StartTime = $toEmail->StartTimeChange;
								$InstructorName = $toEmail->FirstName;
								// print_r($EmailAddress=$users['EmailAddress']);
								$EmailToken = 'Course Active Instructor';
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

								$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

								foreach ($query->result() as $row) {
									if ($row->To == 4 || $row->To == 3) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $user->UserId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										if ($row->BccEmail != '') {
											$bcc = $row->BccEmail . ',' . $row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ StartDate }", $StartDate, $body);
										$body = str_replace("{ StartTime }", $StartTime, $body);
										$body = str_replace("{ InstructorName }", $InstructorName, $body);
										$body = str_replace("{login_url}", $StartTime, $body);
										$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
											echo json_encode('Fail');
										}
									} else {
										$userId_ar = explode(',', $user->UserId);
										foreach ($userId_ar as $userId) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
											$body = str_replace("{ StartDate }", $StartDate, $body);
											$body = str_replace("{ StartTime }", $StartTime, $body);

											$this->email->from($smtpEmail, 'LMS Admin');
											$this->email->to($rowTo[0]->EmailAddress);
											$this->email->subject($row->Subject);
											$this->email->cc($row->totalcc);
											$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
												echo json_encode('fail');
												//echo 'fail';
											}
										}
									}
								}
							}
						}
					}
					echo json_encode('fail');
				} else {
					$resultTo = $this->db->query('SELECT us.UserId,us.FirstName,us.LastName,us.EmailAddress,Creg.UserId,cs.CourseFullName,
			csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,csi.StartTime,csi.EndTime, 
			GROUP_CONCAT(coin.UserId) as instUserId,
				 (SELECT GROUP_CONCAT(u.FirstName)
							  FROM tbluser u 
							  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(coin.UserId))) as instName 
			FROM tblcourseuserregister as Creg INNER JOIN tbluser us ON find_in_set(us.UserId, Creg.UserId)>0
			LEFT Join tblcoursesession as csi ON csi.CourseSessionId=Creg.CourseSessionId
			LEFT JOIN  tblcourseinstructor AS coin ON coin.CourseSessionId = csi.CourseSessionId
			LEFT Join tblcourse as cs ON cs.CourseId=csi.CourseId
			 WHERE
			 find_in_set(us.UserId, Creg.UserId) and Creg.CourseSessionId=' . $post_data["CourseSessionId"] . ' GROUP BY us.EmailAddress');
					$ToEmailAddress = $resultTo->result();
					if ($resultTo) {
						$array = array();
						foreach ($ToEmailAddress as $toEmail) {
							array_push($array, $toEmail->UserId);
							//	$ToEmailAddressString = implode(",", $array);
							$CourseFullName = $toEmail->CourseFullName;
							$StartDate = $toEmail->StartDate;
							$StartTime = $toEmail->StartTimeChange;
							$InstructorName = $toEmail->instName;
							// print_r($EmailAddress=$users['EmailAddress']);
							$EmailToken = 'Course Deactive Enrolees';
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

							$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

							foreach ($query->result() as $row) {
								if ($row->To == 4 || $row->To == 3) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $toEmail->UserId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;

									if ($row->BccEmail != '') {
										$bcc = $row->BccEmail . ',' . $row->totalbcc;
									} else {
										$bcc = $row->totalbcc;
									}
									$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
									$body = str_replace("{ StartDate }", $StartDate, $body);
									$body = str_replace("{ StartTime }", $StartTime, $body);
									$body = str_replace("{ InstructorName }", $InstructorName, $body);
									$body = str_replace("{login_url}", $StartTime, $body);
									$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
										echo json_encode("Fail");
									}
								} else {
									$userId_ar = explode(',', $row->totalTo);
									foreach ($userId_ar as $userId) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ StartDate }", $StartDate, $body);
										$body = str_replace("{ StartTime }", $StartTime, $body);

										$this->email->from($smtpEmail, 'LMS Admin');
										$this->email->to($rowTo[0]->EmailAddress);
										$this->email->subject($row->Subject);
										$this->email->cc($row->totalcc);
										$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
											//echo 'fail';
										}
									}
								}
							}
						}
					}
					$data = $this->db->query('SELECT UserId FROM tblcoursesession AS cs 
			LEFT JOIN tblcourseinstructor AS cin ON
			 cin.CourseSessionId=cs.CourseSessionId WHERE cs.CourseSessionId=' . $post_data["CourseSessionId"]);
					$ress = array();
					foreach ($data->result() as $user) {
						$UserId = $user->UserId;

						$resultTo = $this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
			GROUP_CONCAT(cs.UserId) as UserId,
			 (SELECT GROUP_CONCAT(u.FirstName)
						  FROM tbluser u 
						  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
					FROM tblcoursesession AS csi 
					LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
					LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
					WHERE csi.CourseSessionId=' . $post_data["CourseSessionId"] . ' GROUP BY csi.CourseSessionId');
						$ToEmailAddress = $resultTo->result();
						if ($resultTo) {
							$array = array();
							foreach ($ToEmailAddress as $toEmail) {
								array_push($array, $toEmail->UserId);
								//	$ToEmailAddressString = implode(",", $array);
								$CourseFullName = $toEmail->CourseFullName;
								$StartDate = $toEmail->StartDate;
								$StartTime = $toEmail->StartTimeChange;
								$InstructorName = $toEmail->FirstName;
								// print_r($EmailAddress=$users['EmailAddress']);
								$EmailToken = 'Course Deactive Instructor';
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

								$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

								foreach ($query->result() as $row) {
									if ($row->To == 4 || $row->To == 3) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $user->UserId);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										if ($row->BccEmail != '') {
											$bcc = $row->BccEmail . ',' . $row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
										$body = str_replace("{ StartDate }", $StartDate, $body);
										$body = str_replace("{ StartTime }", $StartTime, $body);
										$body = str_replace("{ InstructorName }", $InstructorName, $body);
										$body = str_replace("{login_url}", $StartTime, $body);
										$body = str_replace("{login_url}", '' . BASE_URL . '/login/', $body);
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
											echo json_encode('Fail');
										}
									} else {
										$userId_ar = explode(',', $user->UserId);
										foreach ($userId_ar as $userId) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $userId);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											$body = str_replace("{ CourseFullName }", $CourseFullName, $body);
											$body = str_replace("{ StartDate }", $StartDate, $body);
											$body = str_replace("{ StartTime }", $StartTime, $body);

											$this->email->from($smtpEmail, 'LMS Admin');
											$this->email->to($rowTo[0]->EmailAddress);
											$this->email->subject($row->Subject);
											$this->email->cc($row->totalcc);
											$this->email->bcc($row->BccEmail . ',' . $row->totalbcc);
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
												echo json_encode('fail');
												//echo 'fail';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
