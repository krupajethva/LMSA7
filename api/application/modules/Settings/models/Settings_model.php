<?php

class Settings_model extends CI_Model
 {

	// ** get reminder data 
	public function get_reminder() {
		$res = array();

		// get course start hours
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','CourseStartHours');
		$result = $this->db->get('tblmstconfiguration');

		if($result->num_rows()==0){
			$data = array(
				'Key' => 'CourseStartHours',
				'Value' => '1',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','CourseStartHours');
			$result = $this->db->get('tblmstconfiguration');
		} 
		foreach($result->result() as $row) {
			$res['CourseStartHours'] = $row->Value;
		}

		// get course end hours
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','CourseEndHours');
		$result = $this->db->get('tblmstconfiguration');

		if($result->num_rows()==0){
			$data = array(
				'Key' => 'CourseEndHours',
				'Value' => '1',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','CourseEndHours');
			$result = $this->db->get('tblmstconfiguration');
		} 
		foreach($result->result() as $row) {
			$res['CourseEndHours'] = $row->Value;
		}

		// get course start days
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','CourseStartDateReminder');
		$result = $this->db->get('tblmstconfiguration');

		if($result->num_rows()==0){
			$data = array(
				'Key' => 'CourseStartDateReminder',
				'Value' => '1',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','CourseStartDateReminder');
			$result = $this->db->get('tblmstconfiguration');
		} 
		foreach($result->result() as $row) {
			$res['CourseStartDateReminder'] = $row->Value;
		}

		// get instructor before days
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InstructorBeforeDays');
		$result = $this->db->get('tblmstconfiguration');

		if($result->num_rows()==0){
			$data = array(
				'Key' => 'InstructorBeforeDays',
				'Value' => '1',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','InstructorBeforeDays');
			$result = $this->db->get('tblmstconfiguration');
		} 
		foreach($result->result() as $row) {
			$res['InstructorBeforeDays'] = $row->Value;
		}

		return $res;
		
	}


	// ** for Login on off Instructor
	public function getlist_ConfigInstructor()
	{
			 $this->db->select('ConfigurationId,Value,IsActive,DisplayText,Description,IsActive');
			 $this->db->where('Key','SettingsInstructor');
			 $result = $this->db->get('tblmstconfiguration');
			 foreach($result->result() as $rowss) {
				 $Setting_model_data = $rowss;
			 }
			 return $Setting_model_data->Value;	
	}



  // ** for Login on off learner
	public function getlist_Config()
	 {
				$this->db->select('ConfigurationId,Value,IsActive,DisplayText,Description,IsActive');
				$this->db->where('Key','Settings');
				$result = $this->db->get('tblmstconfiguration');
				foreach($result->result() as $rowss) {
					$Setting_model_data = $rowss;
				}
				return $Setting_model_data->Value;	
   }

	// ** course keyword
	public function addCourseKeyword($config_data) {
	
		if($config_data) {

			$data = array(
				//"CourseKeyword" => $config_data['CourseKeyword'],
				//"DisplayText" => $config_data['DisplayText'],
				"Description" => $config_data['CourseKeyword'],
				"CreatedBy" =>trim($config_data['CreatedBy']),
				"UpdatedBy" =>trim($config_data['CreatedBy']),
				"UpdatedOn" => date('y-m-d H:i:s'),
			);
			
			
			$this->db->where('Key','CourseKeyword');
			$res = $this->db->update('tblmstconfiguration',$data);
			//$res= $this->db->query('call contactUpdate(?,?,?)',$data);
			if($res) {
				$log_data = array(
					'UserId' => trim($config_data['UpdatedBy']),
					'Module' => 'Course Keyword',
					'Activity' =>'Edit'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
					return true;
				
				}else {
					return false;
					}
			} 
			else {
				return false;
				}

	}

		// ** setting on/off
		public function get_configonoff() {
	
			$this->db->select('ConfigurationId,Key,Value,DisplayText,Description,IsActive');
			$this->db->where('Key','Settings');
			$result = $this->db->get('tblmstconfiguration');			
			
			$res = array();
			foreach($result->result() as $row) {
				$res = $row;
			}
			return $res;
			
		}
			
		// ** instructor setting on/off

		public function get_instructoConfigonoff() {
	
			$this->db->select('ConfigurationId,Key,Value,DisplayText,Description,IsActive');
			$this->db->where('Key','SettingsInstructor');
			$result = $this->db->get('tblmstconfiguration');		
		
			$res = array();
			foreach($result->result() as $row) {
				$res = $row;
			}
			return $res;
			
		}

		
		public function getAllCourseKey() {
			try{
			// $this->db->select('*');
			$this->db->select('Description');
			$this->db->where('Key','CourseKeyword');
			$result = $this->db->get('tblmstconfiguration');
			//$result = $this->db->query('call getCountryList()');
			$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
					$res = array();
					foreach($result->result() as $row) {
						$res = $row->Description;
						$res = explode(",", $res);
					}
					return $res;
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
		}
	

		// ** course keyword
	public function get_CourseKeyword() {
	
		$this->db->select('Description');
		$this->db->where('Key','CourseKeyword');
		$result = $this->db->get('tblmstconfiguration');		
	
		if($result->num_rows()==0){
			$data = array(
				'Key' => 'CourseKeyword',
				'Value' => '',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value,Description');
			$this->db->where('Key','CourseKeyword');
			$result = $this->db->get('tblmstconfiguration');

		} 
		$res = array();
		foreach($result->result() as $row) {
			$res = $row;
		}
		return $res;
		
	}



	// ** contact list
	public function get_Contact() {
	
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','ContactFrom');
		$result = $this->db->get('tblmstconfiguration');		
	
		if($result->num_rows()==0){
			$data = array(
				'Key' => 'ContactFrom',
				'Value' => '',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res = $this->db->insert('tblmstconfiguration',$data);
			
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','ContactFrom');
			$result = $this->db->get('tblmstconfiguration');

		} 
		$res = array();
		foreach($result->result() as $row) {
			$res = $row;
		}
		return $res;
		
	}
		// ** 
	public function get_emailfrom($userid = NULL){
		if($userid) {
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','EmailFrom');
			$result = $this->db->get('tblmstconfiguration');			

			if($result->num_rows()==0){
				$data = array(
					'Key' => 'EmailFrom',
					'Value' => '',
					'IsActive' => 1,
					'CreatedBy' => $userid,
					'UpdatedBy' => $userid,
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblmstconfiguration',$data);
				$log_data = array(
					'UserId' => trim($userid),
					'Module' => 'SMTP Email',
					'Activity' =>'Add'	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				$this->db->select('ConfigurationId,Key,Value');
				$this->db->where('Key','EmailFrom');
				$result = $this->db->get('tblmstconfiguration');

			} 
			$res = array();
			foreach($result->result() as $row) {
				$res = $row;
			}
			return $res;

		} else {
			return false;
		}
	}

		// ** contact
	public function get_emailpassowrd($userid = NULL){
		if($userid) {
			$this->db->select('ConfigurationId,Key,Value');
			$this->db->where('Key','EmailPassword');
			$result = $this->db->get('tblmstconfiguration');			

			if($result->num_rows()==0){
				$data = array(
					'Key' => 'EmailPassword',
					'Value' => '',
					'IsActive' => 1,
					'CreatedBy' => $userid,
					'UpdatedBy' => $userid,
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblmstconfiguration',$data);
				$log_data = array(
					'UserId' => trim($userid),
					'Module' => 'SMTP Password',
					'Activity' =>'Add'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				$this->db->select('ConfigurationId,Key,Value');
				$this->db->where('Key','EmailPassword');
				$result = $this->db->get('tblmstconfiguration');

			} 
			$res = array();
			foreach($result->result() as $row) {
				$res = $row;
			}
			return $res;

		} else {
			return false;
		}
	}
	
	
	public function update_config($config_data) {
	
		if($config_data) {

			$data = array(
				'Value' => $config_data['Value'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			
			$this->db->where('Key',$config_data['Key']);
			$res = $this->db->update('tblmstconfiguration',$data);
			
			if($res) {
				$log_data = array(
					'UserId' => trim($config_data['UpdatedBy']),
					'Module' => $config_data['Key'],
					'Activity' =>'Update'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}	
	
	}

		// ** contact
	public function updateEmail($config_data) {
	
		if($config_data) {

			$data = array(
				'Value' => $config_data['EmailFrom'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			$data1 = array(
				'Value' => $config_data['EmailPassword'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			
			 $this->db->where('Key','EmailFrom');
			 $res = $this->db->update('tblmstconfiguration',$data);
			//$res= $this->db->query('call smtpUpdate(?,?,?)',$data);
			if($res) {
				 $this->db->where('Key','EmailPassword');
				 $res1 = $this->db->update('tblmstconfiguration',$data1);
				//$res1= $this->db->query('call smtp2Update(?,?,?)',$data1);
				if($res1) {
					$log_data = array(
						'UserId' => trim($config_data['UpdatedBy']),
						'Module' => 'SMTP Details',
						'Activity' =>'Update'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}	
	
	}

			 // **  instructor on/0ff
			 public function insAddOnOff($config_data) {
	
				if($config_data) {
					if($config_data['IsOn']==true)
					{
						$IsOn = 1;
					} else {
						$IsOn = 0;
					}
					$data = array(
						"Value"=>$IsOn,
						"UpdatedBy" =>trim($config_data['UpdatedBy']),
						"UpdatedOn" => date('y-m-d H:i:s'),
					);
					
					  $this->db->where('Key','SettingsInstructor');
					 $res = $this->db->update('tblmstconfiguration',$data);
					//$res= $this->db->query('call contactUpdate(?,?,?)',$data);
					if($res) {
						$log_data = array(
							'UserId' => trim($config_data['UpdatedBy']),
							'Module' => 'OnOff Instructor',
							'Activity' =>'Edit'
			
						);
						$log = $this->db->insert('tblactivitylog',$log_data);
							return true;
						
						}else {
							return false;
							}
					} 
					else {
						return false;
						}
		
			}	


		    // **  learner on/0ff
			public function addOnOff($config_data) {
	
				if($config_data) {
					$learner = $config_data['learner'];
					$inst = $config_data['inst'];

					if($learner['IsActive']==true)
					{
						$IsOn = 1;
					} else {
						$IsOn = 0;
					}
					if($inst['IsActive']==true)
					{
						$IsOn1 = 1;
					} else {
						$IsOn1 = 0;
					}

					$data = array(
						"Value"=>$IsOn,
						"UpdatedBy" =>trim($learner['UpdatedBy']),
						"UpdatedOn" => date('y-m-d H:i:s'),
					);
					$data1 = array(
						"Value"=>$IsOn1,
						"UpdatedBy" =>trim($inst['UpdatedBy']),
						"UpdatedOn" => date('y-m-d H:i:s'),
					);					
					
					 $this->db->where('Key','Settings');
					 $res = $this->db->update('tblmstconfiguration',$data);
					
					 $this->db->where('Key','SettingsInstructor');
					 $res1 = $this->db->update('tblmstconfiguration',$data1);

					if($res && $res1) {
						$log_data = array(
							'UserId' => trim($config_data['UpdatedBy']),
							'Module' => 'On/Off Settings',
							'Activity' =>'Edit'
						);
						$log = $this->db->insert('tblactivitylog',$log_data);
							return true;
						
						}else {
							return false;
							}
					} 
					else {
						return false;
						}
		
			}
		

		// ** contact detail
	public function addContact($config_data) {
	
		if($config_data) {

			$data = array(
				"ContactFrom" => $config_data['ContactFrom'],
				"UpdatedBy" =>trim($config_data['UpdatedBy']),
				"UpdatedOn" => date('y-m-d H:i:s'),
			);
			
			
			// $this->db->where('Key','ContactFrom');
			// $res = $this->db->update('tblmstconfiguration',$data);
			$res= $this->db->query('call contactUpdate(?,?,?)',$data);
			if($res) {
				$log_data = array(
					'UserId' => trim($config_data['UpdatedBy']),
					'Module' => 'Contact',
					'Activity' =>'Edit'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
					return true;
				
				}else {
					return false;
					}
			} 
			else {
				return false;
				}

	}

		// ** contact detail
		public function secondSubmit($config_data) {
	
			if($config_data) {
				$contact = $config_data['contact'];
				$keyword = $config_data['keyword'];
				$invitationmsg = $config_data['invitationmsg'];

				$data = array(
					"Value" => $contact['ContactFrom'],
					"UpdatedBy" =>trim($contact['UpdatedBy']),
					"UpdatedOn" => date('y-m-d H:i:s'),
				);

				$data0 = array(
					"Description" => $keyword['CourseKeyword'],
					"UpdatedBy" =>trim($keyword['CreatedBy']),
					"UpdatedOn" => date('y-m-d H:i:s'),
				);
				
				$data1 = array(
					'Value' => $invitationmsg['Success'],
					'UpdatedBy' => $invitationmsg['UpdatedBy'],
					'UpdatedOn' => date('y-m-d H:i:s'),
				);
				$data2 = array(
					'Value' => $invitationmsg['Revoke'],
					'UpdatedBy' => $invitationmsg['UpdatedBy'],
					'UpdatedOn' => date('y-m-d H:i:s'),
				);
				$data3 = array(
					'Value' => $invitationmsg['Pending'],
					'UpdatedBy' => $invitationmsg['UpdatedBy'],
					'UpdatedOn' => date('y-m-d H:i:s'),
				);
				
				$this->db->where('Key','ContactFrom');
				$res = $this->db->update('tblmstconfiguration',$data);
				
				$this->db->where('Key','CourseKeyword');
				$res0 = $this->db->update('tblmstconfiguration',$data0);

				$this->db->where('Key','InvitationMsgSuccess');
			    $res1 = $this->db->update('tblmstconfiguration',$data1);
			
				$this->db->where('Key','InvitationMsgRevoke');
				$res2 = $this->db->update('tblmstconfiguration',$data2);

				$this->db->where('Key','InvitationMsgPending');
				$res3 = $this->db->update('tblmstconfiguration',$data3);

				if($res && $res0 && $res1 && $res2 && $res3) {
					$log_data = array(
						'UserId' => trim($contact['UpdatedBy']),
						'Module' => 'Contact, Course Keyword and Invitation Messages',
						'Activity' =>'Edit'		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					return true;
					
				}else {
					return false;
				}
			} 
			else {
				return false;
			}
	
		}
		

		// **
	public function addinvimsg($config_data) {
	
		if($config_data) {

			$data = array(
				'Value' => $config_data['Success'],
				//UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			$data1 = array(
				'Value' => $config_data['Revoke'],
				//UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			
			
			$this->db->where('Key','InvitationMsgSuccess');
			$res = $this->db->update('tblmstconfiguration',$data);
			
			if($res) {
				$this->db->where('Key','InvitationMsgRevoke');
				$res1 = $this->db->update('tblmstconfiguration',$data1);
				   if($res1)
				   {
						$data2 = array(
							'Value' => $config_data['Pending'],
							//UpdatedBy' => $config_data['UpdatedBy'],
							'UpdatedOn' => date('y-m-d H:i:s'),
						);
						$this->db->where('Key','InvitationMsgPending');
						$res2 = $this->db->update('tblmstconfiguration',$data2);
						return true;
				   }else
				   {
					return false; 
				   }
				}else {
					return false;
					}
			} 
			else {
				return false;
				}

	}
		// ** contact
	public function get_Invimsg() {
	
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgSuccess');
		$result1 = $this->db->get('tblmstconfiguration');		
	
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgRevoke');
		$result2 = $this->db->get('tblmstconfiguration');

		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgPending');
		$result3 = $this->db->get('tblmstconfiguration');

		if($result1->num_rows()==0){
			$data1 = array(
				'Key' => 'InvitationMsgSuccess',
				'Value' => '',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res1 = $this->db->insert('tblmstconfiguration',$data1);
			$data2 = array(
				'Key' => 'InvitationMsgRevoke',
				'Value' => '',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res2 = $this->db->insert('tblmstconfiguration',$data2);
			$data3 = array(
				'Key' => 'InvitationMsgPending',
				'Value' => '',
				'IsActive' => 1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
			$res3 = $this->db->insert('tblmstconfiguration',$data3);
			$res = array();
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgSuccess');
		$result1 = $this->db->get('tblmstconfiguration');		
	
		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgRevoke');
		$result2 = $this->db->get('tblmstconfiguration');

		$this->db->select('ConfigurationId,Key,Value');
		$this->db->where('Key','InvitationMsgPending');
		$result3 = $this->db->get('tblmstconfiguration');

		} 
		
		foreach($result1->result() as $row) {
			$res['Success'] = $row->Value;
		}
		foreach($result2->result() as $row) {
			$res['Revoke'] = $row->Value;
		}
		foreach($result3->result() as $row) {
			$res['Pending'] = $row->Value;
		}
		return $res;
		
	}
	
		// Update reminder 
	public function UpdateReminder($config_data) {

		if($config_data) {

			$data1 = array(
				'Value' => $config_data['CourseStartHours'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			$data2 = array(
				'Value' => $config_data['CourseEndHours'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			$data3 = array(
				'Value' => $config_data['CourseStartDateReminder'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			$data4 = array(
				'Value' => $config_data['InstructorBeforeDays'],
				'UpdatedBy' => $config_data['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
			);
			
			$this->db->where('Key','CourseStartHours');
			$res1 = $this->db->update('tblmstconfiguration',$data1);

			$this->db->where('Key','CourseEndHours');
			$res2 = $this->db->update('tblmstconfiguration',$data2);

			$this->db->where('Key','CourseStartDateReminder');
			$res3 = $this->db->update('tblmstconfiguration',$data3);

			$this->db->where('Key','InstructorBeforeDays');
			$res4 = $this->db->update('tblmstconfiguration',$data4);
			
			if($res1 && $res2 && $res3 && $res4) {
				$log_data = array(
					'UserId' => trim($config_data['UpdatedBy']),
					'Module' => 'Reminder settings',
					'Activity' =>'Edit'		
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		}

	}

	
}
