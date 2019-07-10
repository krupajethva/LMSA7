<?php

class Instructor_model extends CI_Model
{
	// ** Delete instructor //
	public function delete_user($post_user) 
	{
	try{
		if($post_user) 
		{	
			$post_user['UserId'];
			$post_user['AddressesId'];
			$this->db->where('UserId',$post_user['UserId']);
			$res = $this->db->delete('tbluser');
			$this->db->where('AddressesId',$post_user['AddressesId']);
			$res = $this->db->delete('tblmstaddresses');	
			//$res= $this->db->query('call userInstructorDelete(?)',$post_user['id']);
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}		
			if($res) {
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
		
	}
	
 	// list all instructor users //
	public function getlist_user()
	{
	try{
		$this->db->select('us.UserId,us.InvitedByUserId,us.RoleId,us.CompanyId,CONCAT(us.FirstName," ",us.LastName) as UserName,us.EmailAddress,us.Title,us.PhoneNumber,us.AddressesId,us.IsStatus,us.IsActive,role.RoleName,CONCAT(us2.FirstName," ",us2.LastName) as InvitedUserName');
		$this->db->join('tbluser us2','us2.UserId = us.InvitedByUserId', 'left');
		$this->db->join('tblmstuserrole role','role.RoleId = us.RoleId', 'left');
		$this->db->order_by('us.FirstName','asc');
		//$this->db->where('IsStatus',3);
		$this->db->where('role.RoleId',3);
		$result = $this->db->get('tbluser us');		
	//	$result = $this->db->query('call getInstructorList()');	
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

	// list all instructor certificate//
	public function getCertificateById($userId)
	{
		try{
			$this->db->select('tic.Certificate,tic.CertificateId,tic.UserId');
			$this->db->where('tic.UserId = '.$userId);
			$result = $this->db->get('tblinstructorcertificate tic');		
		//	$result = $this->db->query('call getInstructorList()');	
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$certificate_data= array();
			if($result->result()) {
				$certificate_data = $result->result();
			}			
			return $certificate_data;	
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
	}

	// ** IsActive user instructor //
	public function isActiveChange($post_data) {
	try{
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
			$this->db->where('UserId',trim($post_data['UserId']));
			$res = $this->db->update('tbluser',$data);
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
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