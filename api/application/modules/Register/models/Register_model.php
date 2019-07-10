<?php

class Register_model extends CI_Model
{
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
	
	


	// ** open learner register //
	public function learner_Register($post_user)
	{	
		try{
			if($post_user)
			{	
				$this->db->select('EmailAddress');
				$this->db->from('tbluser');
				$this->db->where('EmailAddress',trim($post_user['EmailAddress']));
				$this->db->limit(1);
				$query = $this->db->get();
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($query->num_rows() > 0){
					return false;
				}

				/*$user_data1=array(
				"EducationLevelId"=>$post_user['EducationLevelId'],
					"Field"=>$post_user['Field'],
					"Skills"=>$post_user['Keyword'],
					"IsActive"=>1,
					"CreatedBy" =>1,
					"CreatedOn" =>date('y-m-d H:i:s')
				);	
				$res1=$this->db->insert('tbluserdetail',$user_data1);
				$UserDetailId=$this->db->insert_id();

				$user_data2=array(
						"Address1"=>$post_user['Address1'],
						"City"=>$post_user['City'],
						"IsActive"=>1,
						"CreatedBy" =>0,
						"CreatedOn" =>date('y-m-d H:i:s')
					);	
					$res2=$this->db->insert('tblmstaddresses',$user_data2);
					$AddressesId=$this->db->insert_id();

				
				$user_data=array(
					"InvitedByUserId"=>0,
					"RoleId"=>$role,
					"FirstName"=>$post_user['FirstName'],
					"LastName"=>$post_user['LastName'],
					"PhoneNumber"=>$post_user['PhoneNumber'],
					"EmailAddress"=>$post_user['EmailAddress'],
					"Password"=>md5($post_user['Password']),
					"AddressesId"=>$AddressesId,
					"UserDetailId"=>$UserDetailId,
					"IsStatus"=>1,
					"IsActive"=>0,
					"CreatedBy" =>1,
					"CreatedOn" =>date('y-m-d H:i:s')
				);	*/
				if($post_user['registerRole'] == 1) // learner 
				{
					$role = 4;
					$address1=$post_user['Address1'];
					$city=$post_user['City'];
					$biography = ' ';
					$skills = $post_user['Keyword'];
				}
				else{								// instructor
					$role = 3;
					$address1= ' ';
					$city= ' ';
					$biography = $post_user['Biography'];
					$skills = ' ';
				}
				$user_data=array(
					"InvitedByUserId"=>0,
					"RoleId"=>$role,
					"FirstName"=>$post_user['FirstName'],
					"LastName"=>$post_user['LastName'],
					"PhoneNumber"=>$post_user['PhoneNumber'],
					"EmailAddress"=>$post_user['EmailAddress'],
					"Password"=>md5($post_user['Password']),
					"Address1"=>$address1,
					"City"=>$city,
					"Biography" => $biography,
					"EducationLevelId"=>$post_user['EducationLevelId'],
					"Field"=>$post_user['Field'],
					"Skills"=>$skills,
					"IsStatus"=>1,
					"IsActive"=>0,
					"CreatedBy" =>1,
					"CreatedOn" =>date('y-m-d H:i:s')
				);	
				//$res=$this->db->insert('tbluser',$user_data);
				//$userId=$this->db->insert_id();
				$res= $this->db->query('call Register(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@id)',$user_data);
				$out_param_query = $this->db->query('select @id as out_param;');
				$id=$out_param_query->result()[0]->out_param;
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($res)
				{
					
					// return $userId;
					if($post_user['Certificate']!='')
						{
							foreach($post_user['Certificate'] as $certificate)
							{
								$certificate_data=array(
									'UserId' => $id,
									'Certificate' => $certificate,
									'IsActive' => 1,
									'CreatedBy' => $id,
									'CreatedOn' => date('y-m-d H:i:s'),
									'UpdatedBy' => $id,
									'UpdatedOn' => date('y-m-d H:i:s')
								);	
									$res1=$this->db->insert('tblinstructorcertificate',$certificate_data);
							}	
							if($res1){
								return $id;
							}
							else{
								return false;
							}				
						}
						else{
							return $id;
						}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}


	 // ** check alrady register user or not //
	public function alrady_learner_Register($post_user)
	{	
			if($post_user)
			{	
				$this->db->select('EmailAddress');
				$this->db->from('tbluser');
				$this->db->where('EmailAddress',trim($post_user['EmailAddress']));
				$this->db->limit(1);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					return false;
				}
				else
				{
					return true;
				}	
			}
			else
			{
				return false;
			}
	
	}


	// ** Education List //
	public function getlist_EducationLevel() {
		try{
			$this->db->select('el.EducationLevelId,el.Education');
			$this->db->where('el.IsActive',1);
			$this->db->order_by('el.Education','asc');
			$result = $this->db->get('tblmsteducationlevel as el');
			// $result = $this->db->query('call educationList()');
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

	// ** check link user active //
	public function reset_passlink2($post_user) 
	{
		if($post_user)
		{
				$user_data = array(	
				"IsStatus"=>0,
				"IsActive"=>1,
				//"UpdatedBy" =>trim($post_user['UpdatedBy']),
				"UpdatedBy" =>1,
				"UpdatedOn"=> date('y-m-d H:i:s')
			  );
			$this->db->where('UserId',trim($post_user['UserId']));
			$res = $this->db->update('tbluser',$user_data);
			if($res) {
				
				return true;
			} else {
				return false;
			}	
		} 
		else
		{
				return false;
		}	
	}
	
}