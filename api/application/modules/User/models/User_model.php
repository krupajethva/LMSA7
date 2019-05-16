<?php

class User_model extends CI_Model
{
		
	// check link already used or not // 
	public function reset_passlink2($post_user) 
	{
		if($post_user)
		{
			
				$this->db->select('UserId,RegistrationCode');				
				$this->db->where('UserId',trim($post_user['UserId']));
				$this->db->where('RegistrationCode',trim($post_user['RegistrationCode']));
				$this->db->limit(1);
				$this->db->from('tbluser');
			    $query= $this->db->get();
				if ($query->num_rows() == 1) 
				{
					return true;
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
	public function checkEmail($post_data){
		if($post_data){
			$this->db->select('UserId');
			$this->db->where('EmailAddress',trim($post_data['EmailAddress']));
			$query=$this->db->get('tbluser');
			if($query->num_rows() > 0)
			{
					return "duplicate";
			}
			else{
				return "no";
			}
		}
		
	}


	// ** Education List //
	public function getlist_EducationLevel() {
		try{
			$this->db->select('el.EducationLevelId,el.Education');
			$this->db->where('el.IsActive',1);
			$this->db->order_by('el.Education','asc');
			$result = $this->db->get('tblmsteducationlevel as el');
			// $result = $this->db->query('call educationGetList()');
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

	// get all skills //
	public function getSkillList() {
		try{
			$this->db->select('tud.Skills');
			$skill_list = $this->db->get('tbluserdetail tud');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}

			$skill_data= array();
			foreach($skill_list->result() as $row)
		 	{				
				$skill_explode = explode(',', $row->Skills);
				foreach ($skill_explode as $skill) {
					if($skill!="" || $skill!=null){
						array_push($skill_data,$skill);
					}					
				}
		 	}
			return array_values(array_unique($skill_data));
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
			
		}

	
	// ** Delete user //
	public function delete_user($post_user) 
	{
		if($post_user) 
		{	
			$post_user['UserId'];
			$post_user['AddressesId'];
			$this->db->where('UserId',$post_user['UserId']);
			$res = $this->db->delete('tbluser');
			$this->db->where('AddressesId',$post_user['AddressesId']);
			$res = $this->db->delete('tblmstaddresses');	
			// $res= $this->db->query('call userlearnerDelete(?)',$post_user['id']);
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

		   // ** register invited admin // 
			public function edit_admin_invited($post_user) {
		
				if($post_user) 
				{
					if($post_user['UserId']>0)
					{
					
						$user2_data=array(
							'Address1' => $post_user['Address1'],
							'City' => $post_user['City'],
							'CreatedBy' => $post_user['UserId'],
							'CreatedOn' => date('y-m-d H:i:s')
						);	
							$res2=$this->db->insert('tblmstaddresses',$user2_data);
							$addressesId = $this->db->insert_id();	
					}
					else 
					{
						$addressesId = $post_user['AddressesId']; 
					}

								
									
										$user_data=array(
											"FirstName"=>$post_user['FirstName'],
											"LastName"=>$post_user['LastName'],
											"Password"=>md5($post_user['Password']),
											"EmailAddress"=>$post_user['EmailAddress'],
											"PhoneNumber"=>$post_user['PhoneNumber'],
											"AddressesId"=>$addressesId, 
											"IsStatus"=>0,
											"RegistrationCode"=>'',
											"IsActive"=>1,
											"UpdatedBy" =>$post_user['UserId'],
											"UpdatedOn" => date('y-m-d H:i:s')
										);	
										$this->db->where('UserId',trim($post_user['UserId']));
										$res = $this->db->update('tbluser',$user_data);
											// $res= $this->db->query('call inviteInstructor(?,?,?,?,?,?,?,?,?,@id)',$user_data);
											// $out_param_query = $this->db->query('select @id as out_param;');
											// $id=$out_param_query->result()[0]->out_param;
											if($res){
												//return $userId;
												//return $id;
												return true;
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
	

		// ** instructor register invited //
		public function add_open_instructor($post_user) {
			try{
			if($post_user) 
			{
					$createdOn = date('y-m-d H:i:s');
					$updatedOn = date('y-m-d H:i:s');

					$user1_data=array(
						'EducationLevelId' => $post_user['EducationLevelId'],
						'Field' => $post_user['Field'],
						'IsActive' => 1,
						'CreatedBy' => 0,
						'CreatedOn' => $createdOn,
						"UpdatedBy" =>0,
						"UpdatedOn" => $updatedOn
					);	
						$res1=$this->db->insert('tbluserdetail',$user1_data);
						$userDetailId = $this->db->insert_id();	
				
				if($res1){	
				$user_data=array(
					"InvitedByUserId"=>$post_user['InvitedByUserId'],
					"RoleId"=>$post_user['RoleId'],
					"FirstName"=>$post_user['FirstName'],
					"LastName"=>$post_user['LastName'],
					"Password"=>md5($post_user['Password']),
					"EmailAddress"=>$post_user['EmailAddress'],
					"PhoneNumber"=>$post_user['PhoneNumber'],
					"UserDetailId" =>$userDetailId, 
					"Biography" => $post_user['Biography'],
					"IsStatus"=>0,
					"IsActive"=>$post_user['IsActive'],
					"CreatedBy" =>0,
					"CreatedOn" => $createdOn,
					"UpdatedBy" =>0,
					"UpdatedOn" => $updatedOn
				);	
				$res = $this->db->insert('tbluser',$user_data);
				$UserId = $this->db->insert_id();
					if($res){
						if($post_user['Certificate']!='')
						{
							foreach($post_user['Certificate'] as $certificate)
							{
								$certificate_data=array(
									'UserId' => $UserId,
									'Certificate' => $certificate,
									'IsActive' => 1,
									'CreatedBy' => $UserId,
									'CreatedOn' => $createdOn,
									'UpdatedBy' => $UserId,
									'UpdatedOn' => $updatedOn
								);	
									$res1=$this->db->insert('tblinstructorcertificate',$certificate_data);
							}	
							if($res1){
								return $UserId;
							}
							else{
								return false;
							}				
						}
							
					}
					else
					{
						return false;
					}	
				}
				else{
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
		public function edit_instructor($post_user) {
			try{
			if($post_user) 
			{
					$createdOn = date('y-m-d H:i:s');
					$updatedOn = date('y-m-d H:i:s');

					$user1_data=array(
						'EducationLevelId' => $post_user['EducationLevelId'],
						'Field' => $post_user['Field'],
						'IsActive' => 1,
						'CreatedBy' => $post_user['UserId'],
						'CreatedOn' => $createdOn,
						"UpdatedBy" =>$post_user['UserId'],
						"UpdatedOn" => $updatedOn
					);	
						$res1=$this->db->insert('tbluserdetail',$user1_data);
						$userDetailId = $this->db->insert_id();	
				
				if($res1){	
				$user_data=array(
					"FirstName"=>$post_user['FirstName'],
					"LastName"=>$post_user['LastName'],
					"Password"=>md5($post_user['Password']),
					"PhoneNumber"=>$post_user['PhoneNumber'],
					"UserDetailId" =>$userDetailId, 
					"Biography" => $post_user['Biography'],
					"IsStatus"=>0,
					"RegistrationCode"=>NULL,
					"IsActive"=>$post_user['IsActive'],
					"CreatedBy" =>$post_user['UserId'],
					"CreatedOn" => $createdOn,
					"UpdatedBy" =>$post_user['UserId'],
					"UpdatedOn" => $updatedOn
				);	
				$this->db->where('UserId',trim($post_user['UserId']));
				$res = $this->db->update('tbluser',$user_data);

					if($res){
						if($post_user['Certificate']!='')
						{
							foreach($post_user['Certificate'] as $certificate)
							{
								$certificate_data=array(
									'UserId' => $post_user['UserId'],
									'Certificate' => $certificate,
									'IsActive' => 1,
									'CreatedBy' => $post_user['UserId'],
									'CreatedOn' => $createdOn,
									'UpdatedBy' => $post_user['UserId'],
									'UpdatedOn' => $updatedOn
								);	
									$res1=$this->db->insert('tblinstructorcertificate',$certificate_data);
							}	
							if($res1){
								return true;
							}
							else{
								return false;
							}				
						}
							
					}
					else
					{
						return false;
					}	
				}
				else{
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

			  // invited learner register //
				public function edit_learner_invited($post_user) {
					if($post_user) 
					{
						if($post_user['UserId']>0)
						{	
							$user1_data=array(
								'Address1' => $post_user['Address1'],
								'City' => $post_user['City'],
								'CreatedBy' => $post_user['UserId'],
								'CreatedOn' => date('y-m-d H:i:s')
							);	
								$res1=$this->db->insert('tblmstaddresses',$user1_data);
								$addressesId = $this->db->insert_id();	

								$user_data2=array(
									'EducationLevelId' => $post_user['EducationLevelId'],
									'Field' => $post_user['Field'],
									'Skills' => $post_user['Keyword'],
									'CreatedBy' => $post_user['UserId'],
									'CreatedOn' => date('y-m-d H:i:s')
								);	
									$res2=$this->db->insert('tbluserdetail',$user_data2);
									$UserDetailId = $this->db->insert_id();
						}
						else 
						{
							$addressesId = $post_user['AddressesId']; 
						}
										
											$user_data=array(
												"FirstName"=>$post_user['FirstName'],
												"LastName"=>$post_user['LastName'],
												"Password"=>md5($post_user['Password']),
												"EmailAddress"=>$post_user['EmailAddress'],
												"PhoneNumber"=>$post_user['PhoneNumber'],
												"AddressesId" =>$addressesId, 
												"UserDetailId" =>$UserDetailId, 
												"IsStatus"=>0,
												"RegistrationCode"=>'',
												"IsActive"=>1,
												"UpdatedBy" =>$post_user['UserId'],
												"UpdatedOn" => date('y-m-d H:i:s')
											);	
											$this->db->where('UserId',trim($post_user['UserId']));
											$res = $this->db->update('tbluser',$user_data);
												// $res= $this->db->query('call inviteInstructor(?,?,?,?,?,?,?,?,?,@id)',$user_data);
												// $out_param_query = $this->db->query('select @id as out_param;');
												// $id=$out_param_query->result()[0]->out_param;
												if($res){
													//return $userId;
													//return $id;
													return true;
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

				
	
	
	 // invited user get id for register //
	public function get_userdata($user_id=Null)
	{
	  if($user_id)
	  {
		$this->db->select('user.UserId,user.InvitedByUserId,user.FirstName,user.LastName,user.Title,user.EmailAddress,user.Password,user.PhoneNumber,user.PhoneNumber2,user.ProfileImage,user.Biography,user.AdminPrime,user.IsActive,ur.RoleId,ur.RoleName');
		$this->db->where('user.UserId=',$user_id);
		$this->db->join('tblmstuserrole ur','ur.RoleId = user.RoleId', 'left');
		$result = $this->db->get('tbluser user');
		 $user_data= array();
		 foreach($result->result() as $row)
		 {
			$user_data=$row;
			
		 }
		 return $user_data;
		 
	  }
	  else
	  {
		  return false;
	  }
	}
	
		// list all admin users //
		public function getlist_admin()
		{
			$this->db->select('us.UserId,us.InvitedByUserId,us.RoleId,us.CompanyId,CONCAT(us.FirstName," ",us.LastName) as UserName,us.EmailAddress,us.Title,us.PhoneNumber,us.AdminPrime,us.AddressesId,us.IsStatus,us.IsActive,cp.Name,role.RoleName,CONCAT(us2.FirstName," ",us2.LastName) as InvitedUserName');
			$this->db->join('tbluser us2','us2.UserId = us.InvitedByUserId', 'left');
			$this->db->join('tblcompany cp','cp.CompanyId = us.CompanyId', 'left');
			$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
			$this->db->order_by('us.FirstName','asc');
			$this->db->where('role.RoleId',2);
			$result = $this->db->get('tbluser us');			
			//$result = $this->db->query('call getUsersList()');
			$res=array();
			if($result->result())
			{
				$res=$result->result();
			}
			return $res;
		}

	
	// ** list learner user //
	public function getlist_user()
	{
		$this->db->select('us.UserId,us.InvitedByUserId,us.RoleId,us.CompanyId,CONCAT(us.FirstName," ",us.LastName) as UserName,us.EmailAddress,us.Title,us.PhoneNumber,us.AddressesId,us.IsStatus,us.IsActive,role.RoleName,CONCAT(us2.FirstName," ",us2.LastName) as InvitedUserName');
		$this->db->join('tbluser us2','us2.UserId = us.InvitedByUserId', 'left');
		$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
		$this->db->order_by('us.FirstName','asc');
		$this->db->where('role.RoleId',4);
		$result = $this->db->get('tbluser us');			
	//	$result = $this->db->query('call getUsersList()');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}


// ** IsActive //
	public function isActiveChange($post_data) {
	
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
			$this->db->where('UserId',trim($post_data['UserId']));
			$res = $this->db->update('tbluser',$data);
			if($res) {
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}


		// ** IsActive prime //
		public function isActiveChangePrime($post_data) {
	
			if($post_data) {
				if(trim($post_data['AdminPrime'])==1){
					$AdminPrime = true;
				} else {
					$AdminPrime = false;
				}
				$data = array(
					'AdminPrime' => $AdminPrime,
					'UpdatedBy' => trim($post_data['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$this->db->where('UserId',trim($post_data['UserId']));
				$res = $this->db->update('tbluser',$data);
				if($res) {
					
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			
		}



	// list user role //
	public function getlist_userrole()
	{
		$this->db->select('RoleId,RoleName');
		$this->db->order_by('RoleName','asc');
		$this->db->where('IsActive=',1);
		$result=$this->db->get('tblmstuserrole');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
  // revoke user //
	public function delete_Invitation($post_revoke) {
	
		if($post_revoke) {
			
				$user_data = array(
					"UserId"=>trim($post_revoke['UserId']),
					"IsStatus" => 2,
					"RegistrationCode" =>null,
					"IsActive" => 0,
					"UpdatedBy" =>1,
					"UpdatedOn" => date('y-m-d H:i:s')
				
				);
				
				$this->db->where('UserId',$post_revoke['UserId']);
				$res = $this->db->update('tbluser',$user_data);
			//	$res= $this->db->query('call revokeUser(?,?,?,?,?,?)',$user_data);
				if($res) {

					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}	
			
		}
		
		 // user re-invite //
		public function ReInvite_Invitation($post_user) {
			if($post_user) {
					$user_data = array(
						"UserId"=>trim($post_user['UserId']),
						"IsStatus" =>1,
						"UpdatedBy" => 1,
						"UpdatedOn" => date('y-m-d H:i:s')
					);
					
					$this->db->where('UserId',$post_user['UserId']);
					$res = $this->db->update('tbluser',$user_data);
				//	$res= $this->db->query('call reinviteUser(?,?,?,?)',$user_data);
					return true;
		
				}
				else 
				{
					return false;
				}	
				
				
			}
			
	

	

	
}