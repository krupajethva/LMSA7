<?php

class OpenRegister_model extends CI_Model
{
	
	
	public function add_user($post_user)
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
			
			$user_data=array(
			"FirstName"=>trim($post_user['FirstName']),	
			"LastName"=>trim($post_user['LastName']),
			"RoleId"=>trim($post_user['RoleId']),
			"CompanyId"=>trim($post_user['CompanyId']),
			"DepartmentId"=>trim($post_user['DepartmentId']),
			"IsStatus"=>1,
			"EmailAddress"=>trim($post_user['EmailAddress']),
			"Code"=>trim($post_user['Code']),
			"CreatedBy"=>1,
			"CreatedOn"=>date('y-m-d H:i:s')
				
			);	
				
				$res=$this->db->insert('tbluser',$user_data);
				if($res)
				{
					return $this->db->insert_id();
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
	

	
	
	function getlist_company()
	{
		$this->db->select('CompanyId,Name,');
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

	public function getlist_department()
	{
		$this->db->select('DepartmentId,DepartmentName');
		$this->db->where('IsActive','1');
		$this->db->order_by('DepartmentName','asc');
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
		$this->db->select('RoleId,RoleName');
		$this->db->where('IsActive','1');
		$this->db->order_by('RoleName','asc');
		$this->db->where('RoleId = 3 OR RoleId = 4');
		$result=$this->db->get('tblmstuserrole');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	

	
	

	

	
}