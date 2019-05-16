<?php

class Userinvite_model extends CI_Model
{
	
	// ** invite user //
	public function invite_Instructor($post_user)
	{		
		if($post_user)
		{
			$this->db->select('UserId');
			$this->db->where('EmailAddress',trim($post_user['EmailAddress']));
			$query=$this->db->get('tbluser');
			if($query->num_rows() > 0)
			{
					return false;
			}
			else
			{
				if(isset($post_user['FirstName']) && !empty($post_user['FirstName']))
				{
					$FirstName = $post_user['FirstName'];
				}
				else{
					$FirstName=null;
				}
				if(isset($post_user['LastName']) && !empty($post_user['LastName']))
				{
					$LastName = $post_user['LastName'];
				}
				else{
					$LastName=null;
				}
					$user_data=array(
					"InvitedByUserId" => $post_user['CreatedBy'],
					"RoleId"=>3,
					"CompanyId"=>null,
					"FirstName" => $FirstName,
					"LastName" => $LastName,
					"EmailAddress"=>trim($post_user['EmailAddress']),
					"IsStatus"=>1,
					"RegistrationCode"=>trim($post_user['RegistrationCode']),
					"IsActive"=>0,
					"CreatedBy"=>trim($post_user['CreatedBy']),
					"CreatedOn"=>date('y-m-d H:i:s'),
					"UpdatedBy"=>trim($post_user['UpdatedBy']),
					"UpdatedOn"=>date('y-m-d H:i:s')
				);	
					$res=$this->db->insert('tbluser',$user_data);
					$userId = $this->db->insert_id();	
					if($res){
						return $userId;
						//return $id;
					}
					else
					{
						return false;
					}	 
							
			}
		}
		else
		{
			return false;
		}
	}

		// ** register open instructor user //
		public function openinvite_Instructor($post_user)
		{		
			if($post_user)
			{
				$this->db->select('UserId');
				$this->db->where('EmailAddress',trim($post_user['EmailAddress']));
				$query=$this->db->get('tbluser');
				if($query->num_rows() > 0)
				{
						return false;
				}
				else
				{
					 if($post_user['CompanyId'])
					{
						
						if(isset($post_user['CompanyId']) && !empty($post_user['CompanyId'])){
							$CompanyId = $post_user['CompanyId'];
						}	else {
							$CompanyId =null;
						}
	
						$user_data=array(
							"InvitedByUserId" =>0,
							"RoleId"=>3,
							"CompanyId"=>$CompanyId,
							"EmailAddress"=>trim($post_user['EmailAddress']),
							"IsStatus"=>1,
							"RegistrationCode"=>trim($post_user['RegistrationCode']),
							"IsActive"=>0,
							"CreatedBy"=>0,
							"CreatedOn"=>date('y-m-d H:i:s'),
							"UpdatedOn"=>date('y-m-d H:i:s')
						);	
							$res=$this->db->insert('tbluser',$user_data);
							$userId = $this->db->insert_id();	
							// $res= $this->db->query('call inviteInstructor(?,?,?,?,?,?,?,?,?,@id)',$user_data);
							// $out_param_query = $this->db->query('select @id as out_param;');
							// $id=$out_param_query->result()[0]->out_param;
							if($res){
								return $userId;
								//return $id;
							}
							else
							{
								return false;
							}	 
	
						
					}
					else 
					{
					 
						if(isset($post_user['Address2']) && !empty($post_user['Address2'])){
							$Address2 = $post_user['Address2'];
						}	else {
							$Address2 =null;
						}
	
						$user2_data=array(
							'Address1' => $post_user['Address1'],
							'Address2' => $Address2,
							'CountryId' => $post_user['CountryId'],
							'StateId' => $post_user['StateId'],
							'City' => $post_user['City'],
							'ZipCode' => $post_user['ZipCode'],
							'IsActive' => 1,
							'CreatedBy' =>0,
							'CreatedOn' => date('y-m-d H:i:s')
						);	
							$res2=$this->db->insert('tblmstaddresses',$user2_data);
							$addressesId = $this->db->insert_id();
					
	
					
						
						$user1_data=array(
							'IndustryId' => $post_user['IndustryId'],
							'Name' => $post_user['Name'],
							'EmailAddress' => $post_user['EmailAddressCom'],
							'Website' => $post_user['Website'],
							'AddressesId'=>$addressesId,
							'PhoneNumber' => $post_user['PhoneNumber'],
							'IsActive' => 1,
							'CreatedBy' =>0,
							'CreatedOn' => date('y-m-d H:i:s')
						);	
							$res1=$this->db->insert('tblcompany',$user1_data);
							$companyId = $this->db->insert_id();	
					
									if($companyId)
									{
										$user_data=array(
											"InvitedByUserId" =>0,
											"RoleId"=>3,
											"CompanyId"=>$companyId,
											"EmailAddress"=>trim($post_user['EmailAddress']),
											"IsStatus"=>1,
											"RegistrationCode"=>trim($post_user['RegistrationCode']),
											"IsActive"=>0,
											"CreatedBy"=>0,
											"CreatedOn"=>date('y-m-d H:i:s')
											
										);	
											$res=$this->db->insert('tbluser',$user_data);
											$userId = $this->db->insert_id();	
											// $res= $this->db->query('call inviteInstructor(?,?,?,?,?,?,?,?,?,@id)',$user_data);
											// $out_param_query = $this->db->query('select @id as out_param;');
											// $id=$out_param_query->result()[0]->out_param;
											if($res){
												return $userId;
												//return $id;
											}
											else
											{
												return false;
											}	
										}
									}
								
				}
			}
			else
			{
				return false;
			}
				
			
		}

	


		// List of industry //
	function getlist_industry()
	{

		$this->db->select('IndustryId,IndustryName');
		$this->db->where('IsActive','1');
		$this->db->order_by('IndustryName','asc');
		$result=$this->db->get('tblmstindustry');
	
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;

	}

	// dependencies state //
	public function getStateList($country_id = NULL) {
		if($country_id) {	
			$this->db->select('StateId,StateName');
			$this->db->where('CountryId',$country_id);
			$this->db->order_by('StateName','asc');
			$this->db->where('IsActive=',1);
			$result = $this->db->get('tblmststate');
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
		} else {
			return false;
		}
	}

	// List of country //
	public function getlist_Country() {
		try{	
		$this->db->select('*');
		$this->db->order_by('CountryName','asc');
		$result = $this->db->get('tblmstcountry');
		//$result = $this->db->query('call getCountryList()');
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

	// List of state //
	public function getlist_State() {
		try{
		
		$this->db->select('StateId,StateName,StateAbbreviation,CountryId,IsActive');
		$this->db->order_by('StateName','asc');
		$result = $this->db->get('tblmststate');
		//$result = $this->db->query('call getCountryList()');
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


	// List of company //
	function getlist_company()
	{
		$this->db->select('CompanyId,ParentId,IndustryId,Name,EmailAddress,Website,AddressesId,PhoneNumber,IsActive');
		$this->db->where('IsActive','1');
		$this->db->order_by('Name','asc');
		$result=$this->db->get('tblcompany');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}

	

	//list user role //
	public function getlist_userrole()
	{
		$this->db->select('RoleId,RoleName');
		$this->db->where('RoleId!=','5');
		$this->db->where('RoleId!=','1');
		$this->db->where('IsActive','1');
		$this->db->order_by('RoleName','asc');
		$result=$this->db->get('tblmstuserrole');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
	
	
}