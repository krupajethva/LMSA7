<?php

class Company_model extends CI_Model
{
	
		// state dependencie //
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
	
		 //  add company //
	public function add_company($post_company)
	{	
		if($post_company)
		{
				if($post_company['CompanyId']==0)
				{
					if($post_company['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

					if(isset($post_company['Address2']) && !empty($post_company['Address2'])){
						$Address2 = $post_company['Address2'];
					}	else {
						$Address2 =NULL;
					}
					$user1_data=array(
						'Address1' => $post_company['Address1'],
						'Address2' => $Address2,
						'CountryId' => $post_company['CountryId'],
						'StateId' => $post_company['StateId'],
						'City' => $post_company['City'],
						'ZipCode' => $post_company['ZipCode'],
						'IsActive' => $IsActive,
						'CreatedBy' => $post_company['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
					);	
						$res1=$this->db->insert('tblmstaddresses',$user1_data);
						$addressesId = $this->db->insert_id();	
				}
				else 
				{
					$addressesId = $post_company['AddressesId']; 
				}
								
									$user_data=array(
										'IndustryId' => $post_company['IndustryId'],
										'Name' => $post_company['Name'],
										'EmailAddress' => $post_company['EmailAddress'],
										'Website' => $post_company['Website'],
										'AddressesId'=>$addressesId,
										'PhoneNumber' => $post_company['PhoneNumber'],
										'IsActive' => $IsActive,
										'CreatedBy' => $post_company['CreatedBy'],
										'CreatedOn' => date('y-m-d H:i:s')
									);	
										$res=$this->db->insert('tblcompany',$user_data);
										$userId = $this->db->insert_id();	
										// $res= $this->db->query('call inviteInstructor(?,?,?,?,?,?,?,?,?,@id)',$user_data);
										// $out_param_query = $this->db->query('select @id as out_param;');
										// $id=$out_param_query->result()[0]->out_param;
										if($res){
											return true;
											//return $id;
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




	 // get id company //
	public function get_companydata($Company_Id=Null)
	{
	  if($Company_Id)
	  {

		 $this->db->select('com.CompanyId,com.ParentId,com.IndustryId,com.Name,com.EmailAddress,com.Website,com.AddressesId,com.PhoneNumber,com.IsActive,add.Address1,add.Address2,add.CountryId,add.StateId,add.City,add.ZipCode,add.IsActive');
		 $this->db->join('tblmstaddresses add', 'add.AddressesId = com.AddressesId', 'left');
		 $this->db->where('CompanyId',$Company_Id);
		 $result=$this->db->get('tblcompany com');
		 $company_data= array();
		 foreach($result->result() as $row)
		 {
			$company_data=$row;
			
		 }
		 return $company_data;
		 
	  }
	  else
	  {
		  return false;
	  }
	}
	
	 // company update //
	public function edit_company($post_company)
	{	
		if($post_company)
		{
			if($post_company['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
				if($post_company['CompanyId']>0)
				{
					if($post_company['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

					

						$company_data=array(
							'CompanyId' => $post_company['CompanyId'],
							'IndustryId' => $post_company['IndustryId'],
							'Name' => $post_company['Name'],
							'EmailAddress' => $post_company['EmailAddress'],
							'Website' => $post_company['Website'],
							'AddressesId'=>$post_company['AddressesId'],
							'PhoneNumber' => $post_company['PhoneNumber'],
							'IsActive' => $IsActive,
							'UpdatedBy' => $post_company['UpdatedBy'],
							'UpdatedOn' => date('y-m-d H:i:s')
						);	
								$this->db->where('CompanyId',trim($post_company['CompanyId']));
								$res1 = $this->db->update('tblcompany',$company_data);
						
				}
				else 
				{
					$addressesId = $post_company['AddressesId']; 
				}
							
						$user1_data=array(
							'AddressesId' => $post_company['AddressesId'],
							'Address1' => $post_company['Address1'],
							'Address2' => $post_company['Address2'],
							'CountryId' => $post_company['CountryId'],
							'StateId' => $post_company['StateId'],
							'City' => $post_company['City'],
							'ZipCode' => $post_company['ZipCode'],
							'IsActive' => $IsActive,
							'UpdatedBy' => $post_company['UpdatedBy'],
							'UpdatedOn' => date('y-m-d H:i:s')
						);	
						$this->db->where('AddressesId',trim($post_company['AddressesId']));
						$res = $this->db->update('tblmstaddresses',$user1_data);
						if($res){
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

	 // list all company //
	function getlist_company()
	{
		$this->db->select('cp.CompanyId,cp.Name,cp.EmailAddress,cp.Website,cp.AddressesId,cp.PhoneNumber,cp.IsActive,(SELECT COUNT(u.UserId) FROM tbluser as u WHERE u.CompanyId=cp.CompanyId) as isdisabled');
		$result = $this->db->get('tblcompany cp');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}

	// list country //
	public function getlist_Country() {
		try{
		 $this->db->select('*');
		// $this->db->select('co.CountryId,co.CountryName,co.CountryAbbreviation,co.PhonePrefix,co.IsActive');
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


	// list state //
	public function getlist_State() {
		try{
		// $this->db->select('StateId,StateName,StateAbbreviation,CountryId,IsActive');
		$this->db->select('*');
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

	 // delete company // 
	public function delete_company($post_company) 
	{
		if($post_company) 
		{
			$post_company['CompanyId'];
			$post_company['AddressesId'];
			$this->db->where('CompanyId',$post_company['CompanyId']);
			$res = $this->db->delete('tblcompany');
			$this->db->where('AddressesId',$post_company['AddressesId']);
			$res = $this->db->delete('tblmstaddresses');
			
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_company['Userid']),
					'Module' => 'Company',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
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
	

	// ** isActive //
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
			$this->db->where('CompanyId',trim($post_data['CompanyId']));
			$res = $this->db->update('tblcompany',$data);
			if($res) {
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	//list Industry //
	public function getlist_Industry() {
		$this->db->select('*');
		// $this->db->select('IndustryId,IndustryName');
		$this->db->where('IsActive="1"');
		$this->db->order_by('IndustryName','asc');
		$result = $this->db->get('tblmstindustry');
		
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
		
	}
	
}