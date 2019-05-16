<?php

class Userprofile_model extends CI_Model
{
	
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
	

	//Edit ProjectList
	 public function edit_user($post_user) {
		
		if($post_user) 
		{
				$user_data = array(
				"UserId"=>trim($post_user['UserId']),
				"RoleId"=>trim($post_user['RoleId']),
				"CompanyId"=>trim($post_user['CompanyId']),
				"DepartmentId"=>trim($post_user['DepartmentId']),
				"CountryId"=>trim($post_user['CountryId']),
				"StateId"=>trim($post_user['StateId']),
				"FirstName"=>trim($post_user['FirstName']),
				"LastName"=>trim($post_user['LastName']),
				"Title"=>trim($post_user['Title']),
				"EmailAddress"=>trim($post_user['EmailAddress']),
				"Address1"=>trim($post_user['Address1']),
				"Address2"=>trim($post_user['Address2']),
				"PhoneNumber"=>trim($post_user['PhoneNumber']),
				"PhoneNumberL"=>trim($post_user['PhoneNumberL']),
				"PhoneNumberL"=>trim($post_user['PhoneNumberL']),
				'UpdatedBy' =>1,
				'UpdatedOn' => date('y-m-d H:i:s')
			);
						
			
			$this->db->where('UserId',trim($post_user['UserId']));
			$res = $this->db->update('tbluser',$user_data);
			
			return true;
		
		}
		else 
		{
			return false;
		}	
	}
	
	
	public function get_userdata($user_id=Null)
	{
	  if($user_id)
	  {

		$this->db->select('user.UserId,user.FirstName,user.LastName,user.Title,user.EmailAddress,user.Password,user.Address1,user.Address2,user.PhoneNumber,user.PhoneNumberL,coun.CountryId,coun.CountryName,sta.StateId,sta.StateName,cp.CompanyId,cp.Name,dep.DepartmentId,dep.DepartmentName,ur.RoleId,ur.RoleName');
		$this->db->where('user.UserId=',$user_id);
		$this->db->join('tblcompany cp','cp.CompanyId = user.CompanyId', 'left');
		$this->db->join('tblmstdepartment dep','dep.DepartmentId = user.DepartmentId', 'left');
		$this->db->join('tblmstuserrole ur','ur.RoleId = user.RoleId', 'left');
		$this->db->join('tblmstcountry coun', 'coun.CountryId = user.UserId', 'left');
		$this->db->join('tblmststate sta', 'sta.StateId = user.UserId', 'left');
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
	
	
	function getlist_state()
	{
		$this->db->select('*');
		$result=$this->db->get('tblmststate');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
	function getlist_company()
	{
		$this->db->select('*');
		$result=$this->db->get('tblcompany');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}

	public function getlist_department()
	{
		$this->db->select('*');
	//	$this->db->order_by('DepartmentName','asc');
		$result=$this->db->get('tblmstdepartment');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}


	//list user role
	public function getlist_userrole()
	{
		$this->db->select('*');
		$result=$this->db->get('tblmstuserrole');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
	public function getlist_country() {
	
		$this->db->select('*');
		$result = $this->db->get('tblmstcountry');
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
		
	}

	
	

	

	
}