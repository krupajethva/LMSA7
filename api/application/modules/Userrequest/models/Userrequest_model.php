<?php

class Userrequest_model extends CI_Model
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
			else
			{
				if($post_user['CompanyId']==0)
				{
	
					$user1_data=array(
				//	"CompanyId" => $post_user['CompanyId'],
					"Name" => $post_user['Name'],
					"InvitedByUserId" => $post_user['InvitedByUserId'],
					"EmailAddressCom" => $post_user['EmailAddressCom'],
					"Address" => $post_user['Address'],
					"IndustryId" => $post_user['IndustryId'],
					"Website" => $post_user['Website'],
					"WorkingDays" => $post_user['WorkingDays'],
					"PhoneNo" => $post_user['PhoneNo'],
					"CreatedBy"=>1,
					"CreatedOn"=>date('y-m-d H:i:s')
					
						
					);	
						
						$res1=$this->db->insert('tblcompany',$user1_data);
						$companyId = $this->db->insert_id();	
				}
				else 
				{
					$companyId = $post_user['CompanyId']; 
				}
				
				
									$user_data=array(
									"UserId"=>trim($post_user['UserId']),
									"CompanyId"=>$companyId,
									"DepartmentId"=>trim($post_user['DepartmentId']),
									"FirstName"=>trim($post_user['FirstName']),
									"LastName"=>trim($post_user['LastName']),
									"EmailAddress"=>trim($post_user['EmailAddress']),
									"PhoneNumber"=>trim($post_user['PhoneNumber']),
									"CreatedBy"=>1,
									"CreatedOn"=>date('y-m-d H:i:s')
										
									);	
										
										$res=$this->db->insert('tbluser',$user_data);
	
										$userId = $this->db->insert_id();	
	
										if($res){
											return $userId;
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



	public function getlist_user()
	{
			$this->db->select('us.UserId,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.EmailAddress,us.PhoneNumber,us.IsStatus,cp.Name,dep.DepartmentName');
			$this->db->join('tblcompany cp','cp.CompanyId = us.CompanyId', 'left');
			$this->db->join('tblmstdepartment dep','dep.DepartmentId = us.DepartmentId', 'left');
			//$this->db->join('tbluser usms','tb.UserId = us.Sales_Assign', 'left');
			$this->db->order_by('UserId','asc');
			$this->db->where('us.RoleId is NULL');
			$this->db->where('us.IsStatus is NULL');
			$result = $this->db->get('tbluser us');
				$res=array();
				if($result->result())
				{
					$res=$result->result();
				}
				return $res;
	
	}
	
	
		
	
	//Delete UserList
	public function delete_user($post_user) 
	{
	
		if($post_user) 
		{		
			$this->db->where('UserId',$post_user['id']);
			$res = $this->db->delete('tbluser');	
		} 
		else 
		{
			return false;
		}
		
	}
	
	//Edit UserList
	 public function edit_user($post_user) 
	 {
		if($post_user) 
		{		
				$user_data = array(
				"UserId"=>trim($post_user['UserId']),	
				"RoleId"=>trim($post_user['RoleId']),
				"CompanyId"=>trim($post_user['CompanyId']),
				"DepartmentId"=>trim($post_user['DepartmentId']),
				"FirstName"=>trim($post_user['FirstName']),
				"LastName"=>trim($post_user['LastName']),
				"EmailAddress"=>trim($post_user['EmailAddress']),
				"PhoneNumber"=>trim($post_user['PhoneNumber']),
				"IsStatus"=>1,
				"Code"=>trim($post_user['Code']),
				"UpdatedBy"=>1,
				"UpdatedOn"=> date('y-m-d H:i:s')
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
	
	
	public function get_userdata($User_Id=Null)
	{
	  if($User_Id)
	  {
		$this->db->select('*');
		$this->db->where('UserId',$User_Id);
		$result=$this->db->get('tbluser');
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
	
	

	function getlist_allcompany()
	{
		
		$this->db->select('CompanyId,Name');
		$this->db->where('InvitedByUserId="0"');
		$result = $this->db->get('tblcompany');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
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

		$result=$this->db->get('tblmstuserrole');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	
	
	
	
}