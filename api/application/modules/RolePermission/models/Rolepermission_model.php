<?php

class Rolepermission_model extends CI_Model
 {

	public function getuserrolelist()
	{
		try{
		$this->db->select('RoleId,RoleName');
		//$this->db->where('RoleId!=',4);
	//	$this->db->where('RoleId!=',5);
		$result=$this->db->get('tblmstuserrole');
		$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	public function getpermissionlist($role_id = NULL)
	{
		try{
		if($role_id){
			$query = "SELECT s.ScreenId,s.DisplayName,s.Name,s.IsActive,r.PermissionId,
			(CASE WHEN r.AddEdit = 1 THEN 'true' ELSE NULL END) AS AddEdit,
			(CASE WHEN r.Delete = 1 THEN 'true' ELSE NULL END) AS dlt,
			(CASE WHEN r.View = 1 THEN 'true' ELSE NULL END) AS View FROM tblmstscreen as s 
			LEFT JOIN tblrolespermission as r ON s.ScreenId = r.ScreenId  
			WHERE s.IsActive = 1 AND s.InMenu = 1 AND r.RoleId = ".$role_id;
			$result = $this->db->query($query);
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$res=array();
			if($result->result())
			{
				$res=$result->result();
			}
			return $res;
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
		
	}

	public function update_permission($post_permission) {
		try{
		if($post_permission) {

			foreach($post_permission as $post){

				if($post['View']==true){
					$View = 1;
				} else {
					$View = 0;
				}
				if($post['AddEdit']==true){
					$AddEdit = 1;
				} else {
					$AddEdit = 0;
				}
				if($post['dlt']==true){
					$dlt = 1;
				} else {
					$dlt = 0;
				}

				$permission_data = array(
					'View' => $View,
					'AddEdit' => $AddEdit,
					'Delete' => $dlt,
					'UpdatedBy' => 1,
					'UpdatedOn' => date('y-m-d H:i:s'),
				);				
				$this->db->where('PermissionId',$post['PermissionId']);
				$res = $this->db->update('tblrolespermission',$permission_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			}			
			if($res) {
				return true;
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
