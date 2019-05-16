<?php

class Education_model extends CI_Model
 {

	public function add_Education($post_Education) {
	try{		
			if($post_Education) {
				
				if($post_Education['IsActive']==1)
				{
					$IsActive = true;
				} else {
					$IsActive = false;
				}
				$Education_data = array(
				// "EducationLevelId" => trim($post_Education['EducationLevelId']),
					"Education" => trim($post_Education['Education']),
					"IsActive"=>$IsActive,
					"CreatedBy" =>trim($post_Education['CreatedBy']),
					"CreatedOn" =>date('y-m-d H:i:s'),
					"UpdatedBy" =>trim($post_Education['UpdatedBy'])
				);
				// $res = $this->db->insert('tblmsteducationlevel',$Education_data);
				$res= $this->db->query('call educationAdd(?,?,?,?,?)',$Education_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($res) {
					$log_data = array(
						'UserId' => trim($post_Education['CreatedBy']),
						'Module' => 'Education',
						'Activity' =>'Add'
		
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	
	public function getlist_Education() {
	try{
			
			$this->db->select('edu.EducationLevelId,edu.Education,edu.IsActive,(SELECT COUNT(u.UserDetailId) FROM tbluserdetail as u WHERE u.EducationLevelId=edu.EducationLevelId) as isdisabled');
			$this->db->order_by('edu.Education','asc');
			$result = $this->db->get('tblmsteducationlevel edu');
		//	$result = $this->db->query('call educationList()');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
	}


		// ** isActive
		public function isActiveChange($post_data) {
		try{
				if($post_data) {
					if(trim($post_data['IsActive'])==1){
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					$data = array(
						'IsActive' => $IsActive,
						'UpdatedBy' => trim($post_data['UpdatedBy']),
						'UpdatedOn' => date('y-m-d H:i:s'),
					);			
					$this->db->where('EducationLevelId',trim($post_data['EducationLevelId']));
					$res = $this->db->update('tblmsteducationlevel',$data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
					if($res) {
						
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			 }
			 catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}
	
	
	public function get_Educationdata($EducationLevel_Id = NULL)
	{
	try{	
			if($EducationLevel_Id) {
				
				$this->db->select('EducationLevelId,Education,IsActive');
				$this->db->where('EducationLevelId',$EducationLevel_Id);
				$result = $this->db->get('tblmsteducationlevel');
				$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
				$Education_data = array();
				foreach($result->result() as $row) {
					$Education_data = $row;
				}
				return $Education_data;
				
			} else {
				return false;
			}
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
	}
	
	
	public function edit_Education($post_Education) {
	try{
		if($post_Education) {
			 if($post_Education['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					$Education_data = array(
				"EducationLevelId" => trim($post_Education['EducationLevelId']),
				"Education" => trim($post_Education['Education']),
				"IsActive"=>$IsActive,
				"UpdatedBy" =>  trim($post_Education['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
			
			);
			$this->db->where('EducationLevelId',$post_Education['EducationLevelId']);
			$res = $this->db->update('tblmsteducationlevel',$Education_data);
			//$res= $this->db->query('call educationUpdate(?,?,?,?,?)',$Education_data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' =>  trim($post_Education['UpdatedBy']),
					'Module' => 'Education',
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	
	}
	
	
	public function delete_Education($post_Education) {
	try{
		if($post_Education) {
			
			//$this->db->where('EducationLevelId',$post_Education['id']);
			//$res = $this->db->delete('tblmsteducationlevel');
			$res= $this->db->query('call educationDelete(?)',$post_Education['id']);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Education['Userid']),
					'Module' => 'Education',
					'Activity' =>'Delete'

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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
	
}
