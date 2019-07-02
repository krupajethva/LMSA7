<?php

use \Firebase\JWT\JWT;

class CourseScheduler_model extends CI_Model
{
	function add_CourseScheduler($post_schedular)
	{
		$post_Course = $post_schedular['course'];
		$post_Courseschedular = $post_schedular['schedularList'];
		try {
			if ($post_Courseschedular) {
				$CourseId = $post_Course['CourseId'];
				$count = 0;
				$this->db->select('CourseFullName');
				$this->db->where('CourseId', $CourseId);
				$result_course = $this->db->get('tblcourse');
				$course = json_decode(json_encode($result_course->result()), True);
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

				foreach ($post_Courseschedular as $Courseschedular) {
					if ($Courseschedular['CourseSessionId'] > 0) {
						$weekday = '';

						if ($Courseschedular['Showstatus'] == 1) {
							$Showstatus = true;
						} else {
							$Showstatus = false;
						}
						if ($Courseschedular['IsActive'] == true) {
							$IsActive = 1;
						} else {
							$IsActive = 0;
						}

						if ($Courseschedular['monday'] == 1) {
							$weekday .= '1';
						} else {
							$weekday .= '0';
						}
						if ($Courseschedular['tuesday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['wednesday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['thursday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['friday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['saturday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['sunday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}

						if ($Courseschedular['PublishStatus'] == 1) {
							$PublishStatus = 1;
						} else {
							if ($Courseschedular['Publish'] == 1) {
								$PublishStatus = 1;
							} else {
								$PublishStatus = 0;
							}
						}
						$Courseschedular_data = array(
							'CourseId' => $CourseId,
							'IsActive' => $IsActive,
							'SessionName' => $Courseschedular['SessionName'],
							'Showstatus' => $Showstatus,
							'CourseCloseDate' => $Courseschedular['CourseCloseDate'],
							'TotalSeats' => $Courseschedular['TotalSeats'],
							'StartTime' => date("H:i", strtotime($Courseschedular['StartTime'])),
							'EndTime' => date("H:i", strtotime($Courseschedular['EndTime'])),
							'StartDate' => $Courseschedular['StartDate'],
							'EndDate' => $Courseschedular['EndDate'],
							'CountryId' => $Courseschedular['CountryId'],
							'StateId' => $Courseschedular['StateId'],
							'Location' => $Courseschedular['Location'],
							'weekday' => $weekday,
							'PublishStatus' => $PublishStatus,
							'UpdatedBy' => $post_Course['CreatedBy'],
							'UpdatedOn' => date('y-m-d H:i:s'),
							'CourseSessionId' => $Courseschedular['CourseSessionId']
						);
						$res = $this->db->query('call updateCoursesession(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $Courseschedular_data);
						$post_Courseschedular[$count]['NewSendEmail'] = 0;
						array_push($Courseschedular['Instructor'], $Courseschedular['Instructorone']);
						$this->db->select('UserId');
						$this->db->where('CourseSessionId', $Courseschedular['CourseSessionId']);
						$old = $this->db->get('tblcourseinstructor');
						$Old_Result = $old->result();
						$old_data = array();
						foreach ($Old_Result as $row) {
							array_push($old_data, $row->UserId);
						}
						$old_data1 = $old_data;
						$array_delete = array();
						$array_new = array();

						foreach ($Courseschedular['Instructor'] as $row1) {
							if (in_array($row1, $old_data)) {
								array_splice($old_data, array_search($row1, $old_data), 1);
							} else {
								$Courseinstructo_data = array(
									'CourseSessionId' => $Courseschedular['CourseSessionId'],
									'UserId' =>  $row1,
									'IsPrimary' => 0,
									'Approval' => 0,
									'CreatedBy' => $post_Course['CreatedBy']

								);
								$ress = $this->db->query('call addcourseinstructor(?,?,?,?,?)', $Courseinstructo_data);
								array_push($array_new, $row);

								$SessionName = $Courseschedular['SessionName'];
								$StartDate = $Courseschedular['StartDate'];
								$StartTime = $Courseschedular['StartTime'];
								$CourseName = $course[0]['CourseFullName'];
								$EmailToken = 'Instructor Invitation';

								$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

								foreach ($query->result() as $row) {
									if ($row->To == 4 || $row->To == 3) {
										$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $row1);
										$rowTo = $queryTo->result();
										$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
										$body = $row->EmailBody;

										if ($row->BccEmail != '') {
											$bcc = $row->BccEmail . ',' . $row->totalbcc;
										} else {
											$bcc = $row->totalbcc;
										}
										$body = str_replace("{ CourseFullName }", $CourseName, $body);
										$body = str_replace("{ StartDate }", $StartDate, $body);
										$body = str_replace("{ StartTime }", $StartTime, $body);
										$body = str_replace("{ SessionName }", $SessionName, $body);
										$data1['CourseSessionId'] = $Courseschedular['CourseSessionId'];
										$data2['CourseSessionId'] = $Courseschedular['CourseSessionId'];
										$data1['UserId'] = $row;
										$data2['UserId'] = $row;
										$data1['type'] = 1;
										$data2['type'] = 2;
										//	$body = str_replace("{login_url}",$StartTime,$body);
										$body = str_replace("{ link1 }", '' . BASE_URL . '/instructor-invitation/' . JWT::encode($data1, "MyGeneratedKey", "HS256") . '', $body);
										$body = str_replace("{ link2 }", '' . BASE_URL . '/instructor-invitation/' . JWT::encode($data2, "MyGeneratedKey", "HS256") . '', $body);
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
											// echo json_encode('fail');
										}
									}
								}
							}
						}

						if (count($old_data) > 0) {
							$this->db->where_in('UserId', $old_data);
							$this->db->where('CourseSessionId', $Courseschedular['CourseSessionId']);
							$res_delete = $this->db->delete('tblcourseinstructor');
							$fatch = implode(",", $old_data);
							$user = $this->db->query('SELECT  GROUP_CONCAT(CONCAT(FirstName," ",LastName) SEPARATOR ",") as deletename
							FROM tbluser WHERE UserId IN (' . $fatch . ')');
							$user_Result = $user->result();
							$deleteName = $user_Result[0]->deletename;

							foreach ($old_data1 as $deleterow) {
								if (in_array($deleterow, $old_data)) {
									$SessionName = $Courseschedular['SessionName'];
									$StartDate = $Courseschedular['StartDate'];
									$CourseName = $course[0]['CourseFullName'];
									$EmailToken = 'Instructor Delete';
									$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

									foreach ($query->result() as $row) {
										if ($row->To == 4 || $row->To == 3) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $deleterow);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											if ($row->BccEmail != '') {
												$bcc = $row->BccEmail . ',' . $row->totalbcc;
											} else {
												$bcc = $row->totalbcc;
											}
											$body = str_replace("{ CourseFullName }", $CourseName, $body);
											$body = str_replace("{ StartDate }", $StartDate, $body);
											$body = str_replace("{ InstructorName }", $deleteName, $body);
											$body = str_replace("{ SessionName }", $SessionName, $body);
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
												// echo json_encode('fail');
											}
										}
									}
								} else {
									$SessionName = $Courseschedular['SessionName'];
									$StartDate = $Courseschedular['StartDate'];
									$CourseName = $course[0]['CourseFullName'];
									$EmailToken = 'Instructor Delete';
									$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

									foreach ($query->result() as $row) {
										if ($row->To == 4 || $row->To == 3) {
											$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $deleterow);
											$rowTo = $queryTo->result();
											$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
											$body = $row->EmailBody;

											if ($row->BccEmail != '') {
												$bcc = $row->BccEmail . ',' . $row->totalbcc;
											} else {
												$bcc = $row->totalbcc;
											}
											$body = str_replace("{ CourseFullName }", $CourseName, $body);
											$body = str_replace("{ StartDate }", $StartDate, $body);
											$body = str_replace("{ InstructorName }", $deleteName, $body);
											$body = str_replace("{ SessionName }", $SessionName, $body);
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
												// echo json_encode('fail');
											}
										}
									}
									//array_push($array_match,$row);
									if ($Courseschedular['Check'] == 1) {
										$resultTo = $this->db->query('SELECT UserId from tblcourseuserregister where CourseSessionId=' . $Courseschedular['CourseSessionId']);
										$ToEmaillearner = $resultTo->result();
										if ($ToEmaillearner) {
											foreach ($ToEmaillearner as $tolearner) {
												foreach ($query->result() as $row) {
													if ($row->To == 4 || $row->To == 3) {
														$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $tolearner->UserId);
														$rowTo = $queryTo->result();
														$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
														$body = $row->EmailBody;

														if ($row->BccEmail != '') {
															$bcc = $row->BccEmail . ',' . $row->totalbcc;
														} else {
															$bcc = $row->totalbcc;
														}
														$body = str_replace("{ CourseFullName }", $CourseName, $body);
														$body = str_replace("{ StartDate }", $StartDate, $body);
														$body = str_replace("{ InstructorName }", $deleteName, $body);
														$body = str_replace("{ SessionName }", $SessionName, $body);
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
															// echo json_encode('fail');
														}
													}
												}
											}
										} else { }
									} else { }
								}
							}
						} else {
							if ($Courseschedular['Check'] == 1) {
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
										find_in_set(us.UserId, Creg.UserId) AND coin.Approval=1 AND Creg.CourseSessionId=' . $Courseschedular["CourseSessionId"] . ' GROUP BY us.EmailAddress');
								$ToEmaillearner = $resultTo->result();
								if ($ToEmaillearner) {

									$EmailToken = 'Course Republished Enrolees';
									$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

									foreach ($ToEmaillearner as $tolearner) {
										$CourseFullName = $tolearner->CourseFullName;
										$StartDate = $tolearner->StartDate;
										$StartTime = $tolearner->StartTimeChange;
										$InstructorName = $tolearner->instName;
										foreach ($query->result() as $row) {
											if ($row->To == 4 || $row->To == 3) {
												$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $tolearner->UserId);
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
												//$body = str_replace("{ SessionName }",$SessionName,$body);
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
													// echo json_encode('fail');
												}
											}
										}
									}
								} else { }
							} else { }
						}
						//array_push($Courseschedular['Instructor'],$Courseschedular['Instructorone']);
						// foreach($Courseschedular['Instructor'] as $row)
						// {
						// 	$Courseinstructo_data = array(
						// 		'CourseSessionId' => $Courseschedular['CourseSessionId'],
						// 		'UserId' =>  $row,
						// 		'IsPrimary'=>0,
						// 		'Approval'=>0,
						// 		'CreatedBy' => $post_Course['CreatedBy']		
						// 	);
						// 	$ress=$this->db->query('call addcourseinstructor(?,?,?,?,?)',$Courseinstructo_data);
						// }
					} else {
						$weekday = "";
						if ($Courseschedular['Showstatus'] == 1) {
							$Showstatus = true;
						} else {
							$Showstatus = false;
						}
						if ($Courseschedular['IsActive'] == true) {
							$IsActive = 1;
						} else {
							$IsActive = 0;
						}
						if ($Courseschedular['monday'] == 1) {
							$weekday .= '1';
						} else {
							$weekday .= '0';
						}
						if ($Courseschedular['tuesday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['wednesday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['thursday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['friday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['saturday'] == 1) {
							$weekday .=	',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['sunday'] == 1) {
							$weekday .= ',1';
						} else {
							$weekday .= ',0';
						}
						if ($Courseschedular['PublishStatus'] == 1) {
							$PublishStatus = 1;
						} else {
							if ($Courseschedular['Publish'] == 1) {
								$PublishStatus = 1;
							} else {
								$PublishStatus = 0;
							}
						}

						$Courseschedular_data = array(
							'CourseId' => $CourseId,
							'IsActive' => $IsActive,
							'SessionName' => $Courseschedular['SessionName'],
							'Showstatus' => $Showstatus,
							'CourseCloseDate' => $Courseschedular['CourseCloseDate'],
							'TotalSeats' => $Courseschedular['TotalSeats'],
							'StartTime' => date("H:i", strtotime($Courseschedular['StartTime'])),
							'EndTime' => date("H:i", strtotime($Courseschedular['EndTime'])),
							'StartDate' => $Courseschedular['StartDate'],
							'EndDate' => $Courseschedular['EndDate'],
							'CountryId' => $Courseschedular['CountryId'],
							'StateId' => $Courseschedular['StateId'],
							'Location' => $Courseschedular['Location'],
							'weekday' => $weekday,
							'PublishStatus' => $PublishStatus,
							'CreatedBy' => $post_Course['CreatedBy'],
							'CreatedOn' => date('y-m-d H:i:s')
						);
						$res = $this->db->query('call addCoursesession(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@id)', $Courseschedular_data);
						$out_param_query1 = $this->db->query('select @id as out_param;');
						$CourseSessionId = $out_param_query1->result()[0]->out_param;
						$post_Courseschedular[$count]['CourseSessionId'] = $CourseSessionId;
						$post_Courseschedular[$count]['NewSendEmail'] = 1;
						$count++;
						$singleinst_data = array(
							'CourseSessionId' => $CourseSessionId,
							'UserId' =>  $Courseschedular['Instructorone'],
							'IsPrimary' => 1,
							'Approval' => 1,
							'CreatedBy' => $post_Course['CreatedBy']
						);
						$ress = $this->db->query('call addcourseinstructor(?,?,?,?,?)', $singleinst_data);
						// array_push($Courseschedular['Instructor'],$Courseschedular['Instructorone']);
						foreach ($Courseschedular['Instructor'] as $row) {
							$Courseinstructo_data = array(
								'CourseSessionId' => $CourseSessionId,
								'UserId' =>  $row,
								'IsPrimary' => 0,
								'Approval' => 0,
								'CreatedBy' => $post_Course['CreatedBy']
							);
							$ress = $this->db->query('call addcourseinstructor(?,?,?,?,?)', $Courseinstructo_data);
						}

						array_push($Courseschedular['Instructor'], $Courseschedular['Instructorone']);
						foreach ($Courseschedular['Instructor'] as $UserId) {
							$SessionName = $Courseschedular['SessionName'];
							$StartDate = $Courseschedular['StartDate'];
							$StartTime = $Courseschedular['StartTime'];
							$CourseName = $course[0]['CourseFullName'];
							$EmailToken = 'Instructor Invitation';

							$query = $this->db->query("SELECT et.To,et.Subject,et.EmailBody,et.BccEmail,(SELECT GROUP_CONCAT(UserId SEPARATOR ',') FROM tbluser WHERE RoleId = et.To && ISActive = 1 && IsStatus = 0) AS totalTo,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Cc && ISActive = 1 && IsStatus = 0) AS totalcc,(SELECT GROUP_CONCAT(EmailAddress SEPARATOR ',') FROM tbluser WHERE RoleId = et.Bcc && ISActive = 1 && IsStatus = 0) AS totalbcc FROM tblemailtemplate AS et LEFT JOIN tblmsttoken as token ON token.TokenId=et.TokenId WHERE token.TokenName = '" . $EmailToken . "' && et.IsActive = 1");

							foreach ($query->result() as $row) {
								if ($row->To == 4 || $row->To == 3) {
									$queryTo = $this->db->query('SELECT EmailAddress FROM tbluser where UserId = ' . $UserId);
									$rowTo = $queryTo->result();
									$query1 = $this->db->query('SELECT p.PlaceholderId,p.PlaceholderName,t.TableName,c.ColumnName FROM tblmstemailplaceholder AS p LEFT JOIN tblmsttablecolumn AS c ON c.ColumnId = p.ColumnId LEFT JOIN tblmsttable AS t ON t.TableId = c.TableId WHERE p.IsActive = 1');
									$body = $row->EmailBody;

									if ($row->BccEmail != '') {
										$bcc = $row->BccEmail . ',' . $row->totalbcc;
									} else {
										$bcc = $row->totalbcc;
									}
									$body = str_replace("{ CourseFullName }", $CourseName, $body);
									$body = str_replace("{ StartDate }", $StartDate, $body);
									$body = str_replace("{ StartTime }", $StartTime, $body);
									$body = str_replace("{ SessionName }", $SessionName, $body);
									$data1['CourseSessionId'] = $Courseschedular['CourseSessionId'];
									$data2['CourseSessionId'] = $Courseschedular['CourseSessionId'];
									$data1['UserId'] = $UserId;
									$data2['UserId'] = $UserId;
									$data1['type'] = 1;
									$data2['type'] = 2;
									//	$body = str_replace("{login_url}",$StartTime,$body);
									$body = str_replace("{ link1 }", '' . BASE_URL . '/instructor-invitation/' . JWT::encode($data1, "MyGeneratedKey", "HS256") . '', $body);
									$body = str_replace("{ link2 }", '' . BASE_URL . '/instructor-invitation/' . JWT::encode($data2, "MyGeneratedKey", "HS256") . '', $body);
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
										// echo json_encode('fail');
									}
								}
							}
						}


						$arr = array();
						//print_r($ress);
						$data1 = $this->db->query('
			 SELECT FollowerUserId FROM tblinstructorfollowers AS cs WHERE cs.InstructorUserId=' . $Courseschedular['Instructorone']);
						foreach ($data1->result() as $row1) {
							if ($row1->FollowerUserId != '') {
								$FollowerUserId = explode(",", $row1->FollowerUserId);
								foreach ($FollowerUserId as $id) {
									array_push($arr, $id);
								}
							}
						}
						$Coursedata = $this->db->query('select co.CourseFullName,csi.SessionName,csi.TotalSeats,csi.StartDate,TIME_FORMAT(csi.StartTime, "%h:%i %p") AS StartTimeChange,TIME_FORMAT(csi.EndTime, "%h:%i %p") AS EndTimeChange,csi.StartTime,csi.EndTime,csi.EndDate,
GROUP_CONCAT(cs.UserId) as UserId,
 (SELECT GROUP_CONCAT(u.FirstName)
			  FROM tbluser u 
			  WHERE FIND_IN_SET(u.UserId, GROUP_CONCAT(cs.UserId))) as FirstName
		FROM tblcoursesession AS csi 
		LEFT JOIN  tblcourse AS co ON co.CourseId = csi.CourseId
		LEFT JOIN  tblcourseinstructor AS cs ON cs.CourseSessionId = csi.CourseSessionId
		WHERE csi.CourseSessionId=' . $CourseSessionId . ' AND cs.IsPrimary=1 GROUP BY csi.CourseSessionId');
						$Cdata = $Coursedata->result();
						$EmailToken = 'Course Published Followers';

						foreach ($arr as $users) {

							$CourseFullName = $Cdata[0]->CourseFullName;
							$StartDate = $Cdata[0]->StartDate;
							$StartTime = $Cdata[0]->StartTimeChange;
							$InstructorName = $Cdata[0]->FirstName;

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
										//echo json_encode($users);

									} else {
										echo json_encode('fail');
									}
								} else { }
							}
						}
					}
				}

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {
					$log_data = array(
						'UserId' => trim($post_Course['CreatedBy']),
						'Module' => 'Courseschedular',
						'Activity' => 'Add'

					);
					$log = $this->db->insert('tblactivitylog', $log_data);
					return $post_Courseschedular;
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}



	public function get_Coursesession($Course_id = Null, $userid = Null)
	{
		try {
			if ($Course_id) {
				$result = $this->db->query('SELECT cp.IsActive,cp.SessionStatus,cp.CourseId,cp.CourseSessionId,cp.PublishStatus,cins.UserId as Instructorone,cp.weekday,cp.SessionName,cp.Showstatus,cp.CourseCloseDate,cp.TotalSeats,cp.RemainingSeats,
			TIME_FORMAT(cp.StartTime, "%h %i %p") as StartTime,TIME_FORMAT(cp.EndTime, "%h %i %p") as EndTime,
			cp.StartDate,cp.EndDate,cp.CountryId,cp.StateId,cp.Location,cp.IsActive,(SELECT COUNT(mc.CourseSessionId) 
			FROM tblcourseuserregister as mc
			WHERE mc.CourseSessionId=cp.CourseSessionId ) AS enroll
			from tblcoursesession as cp
		    LEFT JOIN tblcourseinstructor as cins ON cins.CourseSessionId=cp.CourseSessionId
		    where cp.CourseId=' . $Course_id . ' AND cins.IsPrimary=1');
				//$result=$this->db->query('call getByCourseSession(?)',$Course_id);

				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$Course_data = array();
				$result = json_decode(json_encode($result->result()), TRUE);
				foreach ($result as $row) {
					mysqli_next_result($this->db->conn_id);
					$res = $this->db->query('call getBySessioninstructor(?)', $row['CourseSessionId']);
					$result1 = json_decode(json_encode($res->result()), True);

					// if($res->result()){
					// 	$row->instructor = $res->result();
					// }
					$row['Instructor'] = array();
					foreach ($result1 as $row1) {
						array_push($row['Instructor'], $row1['UserId']);
					}

					$row['monday'] = substr($row['weekday'], 0, 1);
					$row['tuesday'] = substr($row['weekday'], 2, 1);
					$row['wednesday'] = substr($row['weekday'], 4, 1);
					$row['thursday'] = substr($row['weekday'], 6, 1);
					$row['friday'] = substr($row['weekday'], 8, 1);
					$row['saturday'] = substr($row['weekday'], 10, 1);
					$row['sunday'] = substr($row['weekday'], 12, 1);


					array_push($Course_data, $row);
				}
				// $result = json_decode(json_encode($result->result()), True);
				// mysqli_next_result($this->db->conn_id);
				// foreach($result as $row){	

				// 	$row['Instructor'] = array();
				// 	 $this->db->select('UserId');
				// 	 $this->db->where('CourseSessionId',$row['CourseSessionId']);
				// 	 $result1 = $this->db->get('tblcourseinstructor');
				// 	 $result1 = json_decode(json_encode($result1->result()), True);
				// 	 foreach($result1 as $row1){
				// 		 //print_r($result1->result());
				// 		array_push($row['Instructor'],$row1['UserId']);
				// 	 }
				//  }
				//  $data = array();
				//  array_push($data,$row);
				return $Course_data;
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	public function get_Coursename($Course_id = Null)
	{
		try {
			if ($Course_id > 0) {
				$this->db->select('CourseId,CourseFullName,IsActive');
				$this->db->where('CourseId', $Course_id);
				$this->db->where('IsActive=', 1);
				$result = $this->db->get('tblcourse');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}

				$Course_data = array();
				if ($result->num_rows() > 0) {
					foreach ($result->result() as $row) {
						$Course_data = $row;
					}
					return $Course_data;
				} else {
					return 'error';
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	function getlist_state()
	{
		$this->db->select('*');
		$result = $this->db->get('tblmststate');

		$res = array();
		if ($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	public function getlist_country()
	{

		$this->db->select('*');
		$result = $this->db->get('tblmstcountry');
		$res = array();
		if ($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	function getlist_instructor()
	{
		try {
			$this->db->select('con.RoleId,con.CompanyId,con.UserId as value,(CASE WHEN cop.CompanyId>0 THEN CONCAT(con.FirstName, " ", con.LastName, " - ", cop.Name) ELSE CONCAT(con.FirstName, " ", con.LastName, " ", ro.RoleName) END) as label,con.EmailAddress,cop.Name');
			$this->db->join('tblcompany cop', 'cop.CompanyId = con.CompanyId', 'left');
			$this->db->join('tblmstuserrole ro', 'ro.RoleId = con.RoleId', 'left');
			$this->db->where('con.RoleId!=', 4);
			$result = $this->db->get('tbluser as con');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) {
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			return $res;
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	public function getStateList($country_id = NULL)
	{

		if ($country_id) {

			$this->db->select('StateId,StateName');
			$this->db->where('CountryId', $country_id);
			$this->db->order_by('StateName', 'asc');
			$this->db->where('IsActive=', 1);
			$result = $this->db->get('tblmststate');

			$res = array();
			if ($result->result()) {
				$res = $result->result();
			}
			return $res;
		} else {
			return false;
		}
	}
	public function delete_Scheduler($post_Scheduler)
	{
		try {
			if ($post_Scheduler) {


				$this->db->where('CourseSessionId', $post_Scheduler['CourseSessionId']);
				$res = $this->db->delete('tblcoursesession');
				$this->db->where('CourseSessionId', $post_Scheduler['CourseSessionId']);
				$ress = $this->db->delete('tblcourseinstructor');
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {
					$log_data = array(
						'UserId' => trim($post_Scheduler['UserId']),
						'Module' => 'coursesession',
						'Activity' => 'Delete'

					);
					$log = $this->db->insert('tblactivitylog', $log_data);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	public function Clone_Course($postClone)
	{
		$Courseschedular = $postClone['schedularList'];
		$post_Course = $postClone['CreatedBy'];

		try {
			if ($Courseschedular) {
				$weekday = '';
				if ($Courseschedular['Showstatus'] == 1) {
					$Showstatus = true;
				} else {
					$Showstatus = false;
				}
				if ($Courseschedular['IsActive'] == true) {
					$IsActive = 1;
				} else {
					$IsActive = 0;
				}
				if ($Courseschedular['monday'] == 1) {
					$weekday .= '1';
				} else {
					$weekday .= '0';
				}
				if ($Courseschedular['tuesday'] == 1) {
					$weekday .= ',1';
				} else {
					$weekday .= ',0';
				}
				if ($Courseschedular['wednesday'] == 1) {
					$weekday .= ',1';
				} else {
					$weekday .= ',0';
				}
				if ($Courseschedular['thursday'] == 1) {
					$weekday .=	',1';
				} else {
					$weekday .= ',0';
				}
				if ($Courseschedular['friday'] == 1) {
					$weekday .=	',1';
				} else {
					$weekday .= ',0';
				}
				if ($Courseschedular['saturday'] == 1) {
					$weekday .=	',1';
				} else {
					$weekday .= ',0';
				}
				if ($Courseschedular['sunday'] == 1) {
					$weekday .= ',1';
				} else {
					$weekday .= ',0';
				}
				$Courseschedular_data = array(
					'CourseId' => $Courseschedular['CourseId'],
					'IsActive' => $IsActive,
					'SessionName' => $Courseschedular['SessionName'],
					'Showstatus' => $Showstatus,
					'CourseCloseDate' => $Courseschedular['CourseCloseDate'],
					'TotalSeats' => $Courseschedular['TotalSeats'],
					'StartTime' => date("H:i", strtotime($Courseschedular['StartTime'])),
					'EndTime' => date("H:i", strtotime($Courseschedular['EndTime'])),
					'StartDate' => $Courseschedular['StartDate'],
					'EndDate' => $Courseschedular['EndDate'],
					'CountryId' => $Courseschedular['CountryId'],
					'StateId' => $Courseschedular['StateId'],
					'Location' => $Courseschedular['Location'],
					'weekday' => $weekday,
					'CreatedBy' => $postClone['CreatedBy'],
					'CreatedOn' => date('y-m-d H:i:s')

				);
				$res = $this->db->query('call addCoursesession(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@id)', $Courseschedular_data);
				$out_param_query1 = $this->db->query('select @id as out_param;');
				$CourseSessionId = $out_param_query1->result()[0]->out_param;

				$singleinst_data = array(
					'CourseSessionId' => $CourseSessionId,
					'UserId' =>  $Courseschedular['Instructorone'],
					'IsPrimary' => 1,
					'CreatedBy' => $postClone['CreatedBy']


				);
				$ress = $this->db->query('call addcourseinstructor(?,?,?,?)', $singleinst_data);

				foreach ($Courseschedular['Instructor'] as $row) {
					$Courseinstructo_data = array(
						'CourseSessionId' => $CourseSessionId,
						'UserId' =>  $row,
						'IsPrimary' => 0,
						'CreatedBy' => $postClone['CreatedBy']


					);
					$ress = $this->db->query('call addcourseinstructor(?,?,?,?)', $Courseinstructo_data);
					//$out_param_query = $this->db->query('select @id as out_param;');
				}




				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) {
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if ($res) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
}
