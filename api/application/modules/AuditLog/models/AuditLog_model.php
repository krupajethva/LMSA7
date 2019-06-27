<?php

class AuditLog_model extends CI_Model
 {	

		 // email log list //
	public function getEmailLog() {
	try{
		$this->db->select('el.EmailLogId,el.From,el.Cc,el.Bcc,el.To,el.Subject,el.MessageBody,el.CreatedOn');
		$this->db->order_by('el.EmailLogId',"desc");
		$result = $this->db->get('tblemaillog as el');	
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

	 // login log list //
	public function getLoginLog() {
	try{
		$this->db->select('ll.tblLoginLogId,ll.UserId,ll.LoginType,ll.PanelType,ll.CreatedOn,CONCAT(u.FirstName," ",u.LastName) as UserName,ur.RoleName');
		$this->db->order_by('ll.tblLoginLogId',"desc");
		$this->db->join('tbluser u', 'u.UserId = ll.UserId', 'left');
		$this->db->join('tblmstuserrole ur', 'ur.RoleId = u.RoleId', 'left');
		$result = $this->db->get('tblloginlog as ll');
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

	  // activity list //
	public function listActivityLog() {
	try{
		$this->db->select('al.ActivityLogId,al.UserId,al.Module,al.Activity,al.CreatedOn,u.RoleId,CONCAT(u.FirstName," ",u.LastName) as UserName,ur.RoleName');
		$this->db->order_by('al.ActivityLogId',"desc");
		$this->db->join('tbluser u', 'u.UserId = al.UserId', 'left');
		$this->db->join('tblmstuserrole ur', 'ur.RoleId = u.RoleId', 'left');
		$this->db->where('ur.RoleId',4);
		$result = $this->db->get('tblactivitylog as al');
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
	public function getActivityByUser($id = null) {
		try {
			if($id)
			{
				$this->db->select('ta.Module, ta.Activity, ta.CreatedOn');
				$this->db->order_by('ta.ActivityLogId',"desc");
				$this->db->where('ta.UserId', $id);
				$result = $this->db->get('tblactivitylog as ta');		
				$res = array();
				if($result->result()) {
					$res = $result->result();
				}
				return $res;
			}else
			{
				return false;
			}
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}
}
