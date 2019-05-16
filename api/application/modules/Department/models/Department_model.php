<?php

class Department_model extends CI_Model
{
	
	public function add_department($post_department)
	{	
		
		if($post_department)
		{
			if($post_department['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
			 
			$department_data=array(
				"DepartmentId"=>trim($post_department['DepartmentId']),
				"DepartmentName"=>trim($post_department['DepartmentName']),
				"IsActive"=>$IsActive,
				'CreatedOn' => date('y-m-d H:i:s'),
				"CreatedBy" =>trim($post_department['CreatedBy'])
				
			);	
				
				$res=$this->db->insert('tblmstdepartment',$department_data);
				if($res)
				{
					$log_data = array(
						'UserId' => trim($post_department['CreatedBy']),
						'Module' => 'Department',
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
	public function getlist_department()
	{
		//$this->db->select('*');
		$this->db->select('dep.DepartmentId,dep.DepartmentName,dep.IsActive,(SELECT COUNT(u.UserId) FROM tbluser as u WHERE u.DepartmentId=dep.DepartmentId) as isdisabled');
		$this->db->order_by('DepartmentName','asc');
		$result=$this->db->get('tblmstdepartment dep');
		
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
		
	
	//Delete UserList
	public function delete_department($department_id) 
	{
	
		if($department_id) 
		{
			
			$this->db->where('DepartmentId',$department_id['id']);
			$res = $this->db->delete('tblmstdepartment');
			
			if($res) {
				$log_data = array(
					'UserId' =>  trim($department_id['Userid']),
					'Module' => 'Department',
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
	 public function edit_department($post_department) {
		
		if($post_department) 
		{		
			if($post_department['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

				$department_data = array(
				//"ProjectIsStatusId"=>$post_department['ProjectIsStatusId'],
				"DepartmentId"=>$post_department['DepartmentId'],
				"DepartmentName"=>$post_department['DepartmentName'],
				"IsActive"=>$IsActive,
				"UpdatedBy" => $post_department['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s')
			);
			
			$this->db->where('DepartmentId',trim($post_department['DepartmentId']));
			$res = $this->db->update('tblmstdepartment',$department_data);
			
			if($res) 
			{	
				$log_data = array(
				'UserId' => $post_department['UpdatedBy'],
				'Module' => 'Department',
				'Activity' =>'Update'

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
	
	
	public function get_departmentdata($department_id=Null)
	{
	  if($department_id)
	  {
		 $this->db->select('DepartmentId,DepartmentName,IsActive');
		 $this->db->where('DepartmentId',$department_id);
		 $result=$this->db->get('tblmstdepartment');
		 $department_data = array();
		 foreach($result->result() as $row) {
			 $department_data = $row;
		 }
		 return $department_data;
		 
			 } else {
		 return false;
	 	}
	}
	
	
	
	
}