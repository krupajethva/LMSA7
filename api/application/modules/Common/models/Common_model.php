<?php

class Common_model extends CI_Model
 {	
	public function get_permissiondata($data = NULL)
	{	
		try{	
		if($data) {			
			$this->db->select('rp.PermissionId,rp.RoleId,rp.ScreenId,rp.View,rp.AddEdit,rp.Delete');
			$this->db->join('tblrolespermission rp', 'rp.ScreenId = s.ScreenId', 'left');
			$this->db->where('s.Name',trim($data['screen']));
			$this->db->where('rp.RoleId',trim($data['RoleId']));
			$this->db->where('rp.IsActive',1);
			$result = $this->db->get('tblmstscreen s');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$permission_data = array();
			foreach($result->result() as $row) {
				$permission_data = $row;
			}
			return $permission_data;
			
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	public function getCompanyDetails($data = NULL)
	{	
		try{	
		if($data) {			
			$this->db->select('c.CompanyId,c.CompanyLogo,c.Favicon,c.ThemeCode');
			$this->db->where('c.WorkspaceURL',trim($data['company']));
			$result = $this->db->get('tblcompany c');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$company_data = array();
			foreach($result->result() as $row) {
				$company_data = $row;
			}
			return $company_data;
			
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	public function getCompanyList()
	{	
		try{		
		$this->db->select('CONCAT(CompanyName," (",WorkspaceURL,")") as CompanyName');
		$this->db->where('WorkspaceURL IS NOT NULL');
		$result = $this->db->get('tblcompany');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$company_data = array();
		foreach($result->result() as $row) {
			array_push($company_data,$row->CompanyName);
		}
		return $company_data;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}

	public function check_workspace_url($data) {
		try{
		if($data) {	
			$this->db->select('c.CompanyId,c.WorkspaceURL');
			$this->db->where('c.CompanyName',trim($data['name']));
			$this->db->limit(1);
			$result = $this->db->get('tblcompany c');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
			if ($result->num_rows() == 1) {
				return $result->result()[0]->WorkspaceURL;				
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
