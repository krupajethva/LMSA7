<?php

class Userrole_model extends CI_Model
{
	
	public function add_userrole($post_userrole)
	{	
		
		if($post_userrole)
		{
			if($post_userrole['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
			 
			$userrole_data=array(
				"RoleId"=>trim($post_userrole['RoleId']),
				"RoleName"=>trim($post_userrole['RoleName']),
				"IsActive"=>$IsActive,
				"CreatedBy" =>trim($post_userrole['CreatedBy']),
				"CreatedOn" =>date('y-m-d H:i:s')
			);	
				
				$res=$this->db->insert('tblmstuserrole',$userrole_data);
				if($res)
				{
					$log_data = array(
						'UserId' =>trim($post_userrole['CreatedBy']),
						'Module' => 'Userrole',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
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
	
	//list project IsStatus
	public function getlist_userrole()
	{
		$this->db->select('usr.RoleId,usr.RoleName,usr.IsActive,(SELECT COUNT(u.UserId) FROM tbluser as u WHERE u.RoleId=usr.RoleId) as isdisabled');
		$this->db->order_by('RoleName','asc');
		$result=$this->db->get('tblmstuserrole usr');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
		
	
	//Delete UserList
	public function delete_userrole($role_id) 
	{
	
		if($role_id) 
		{
			
			$this->db->where('RoleId',$role_id['id']);
			$res = $this->db->delete('tblmstuserrole');
			
			if($res) {
				$log_data = array(
					'UserId' => trim($role_id['Userid']),
					'Module' => 'Userrole',
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
	
	//Edit ProjectList
	 public function edit_userrole($post_userrole) {
		if($post_userrole['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
		if($post_userrole) 
		{
				$userrole_data = array(
				//"ProjectIsStatusId"=>$post_userrole['ProjectIsStatusId'],
				"RoleId"=>$post_userrole['RoleId'],
				"RoleName"=>$post_userrole['RoleName'],
				"IsActive"=>$IsActive,
				"UpdatedBy" =>trim($post_userrole['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
			);
			
			$this->db->where('RoleId',trim($post_userrole['RoleId']));
			$res = $this->db->update('tblmstuserrole',$userrole_data);
			
			if($res) 
			{
				$log_data = array(
					'UserId' => trim($post_userrole['UpdatedBy']),
					'Module' => 'Userrole',
					'Activity' =>'Edit'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else
				{
				 return false;
			    }
		}
		else 
		{
			return false;
		}	
	
	}
	
	
	public function get_userroledata($role_id=Null)
	{
	  if($role_id)
	  {
		 $this->db->select('RoleId,RoleName,IsActive');
		 $this->db->where('RoleId',$role_id);
		 $result=$this->db->get('tblmstuserrole');
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
	
	
	
	
}