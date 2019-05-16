<?php

class CertificateTemplate_model extends CI_Model
{
			
	public function add_Certificate($post_Certificate)
	{	try{
		
		if($post_Certificate['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
			$Certificate_data = array(
				'CertificateName' => $post_Certificate['CertificateName'],
				'CertificateTemplate' => $post_Certificate['CertificateTemplate'],
				'IsActive' => $IsActive,
				'CreatedBy' => $post_Certificate['CreatedBy'],
				'CreatedOn' => date('y-m-d H:i:s'),
				'UpdatedBy' => $post_Certificate['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s')
			);
				
				// $res=$this->db->insert('tblmstcategory',$Certificate_data);
				$res=$this->db->query('call addCertificate(?,?,?,?,?,?,?)',$Certificate_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					// $log_data = array(
					// 	'UserId' => trim($post_Certificate['CreatedBy']),
					// 	'Module' => 'Certificate',
					// 	'Activity' =>'Add'
		
					// );
					// $log = $this->db->insert('tblactivitylog',$log_data);
					return true;
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
	
	public function get_Certificatedata($Certificate_id=Null)
	{
		try {
	  if($Certificate_id)
	  {

		//  $this->db->select('cp.CertificateId,cp.CertificateName,cp.ParentId,cp.CertificateCode,cp.CertificateTemplate,cp.IsActive');
		// // $this->db->order_by('cp.Name','asc');

		//  $this->db->where('CertificateId',$Certificate_id);
		//  $result=$this->db->get('tblmstcategory cp');
		$result=$this->db->query('call getCertificateById(?)',$Certificate_id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Certificate_data= array();
		 foreach($result->result() as $row)
		 {
			$Certificate_data=$row;
			
		 }
		 return $Certificate_data;
		 
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
	
	 public function edit_Certificate($post_Certificate)
	 {
		try
		{
		if($post_Certificate) {
			if($post_Certificate['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					
			
			$Certificate_data = array(
				'CertificateId' => $post_Certificate['CertificateId'],
				'CertificateName' => $post_Certificate['CertificateName'],
				'CertificateTemplate' => $post_Certificate['CertificateTemplate'],
				'IsActive' => $IsActive,
				'UpdatedBy' =>trim($post_Certificate['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s')
				
			);
			$res=$this->db->query('call updateCertificate(?,?,?,?,?,?)',$Certificate_data);
			// $this->db->where('CertificateId',trim($post_Certificate['CertificateId']));
			// $res = $this->db->update('tblmstcategory',$Certificate_data);

			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			if($res) 
			{	
				$log_data = array(
					'UserId' =>trim($post_Certificate['UpdatedBy']),
					'Module' => 'CertificateTemplate',
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
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}		
	
	}
	
	function getlist_Certificate()
	{
		
	

try{
		// $this->db->select('cp.CertificateId,cp.CertificateName,cp.ParentId,cp.CertificateCode,cp.CertificateTemplate,cp.IsActive,in.CertificateName as parentName');
		//  //$this->db->select('cp.CertificateId,cp.ParentId,cp.Name,cp.EmailAddressCom,cp.Address,cp.IndustryId,cp.Website,cp.PhoneNo,cp.IsActive,in.IndustryName');
		//  $this->db->join('tblmstcategory in', 'in.CertificateId = cp.ParentId', 'left');
		// $result = $this->db->get('tblmstcategory cp');
		$result=$this->db->query('call getCertificate()');
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
	}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}

	


	public function delete_Certificate($post_Certificate) 
	{
	 try{
		if($post_Certificate) 
		{
			$id=$post_Certificate['id'];
			// $this->db->where('CertificateId',$post_Certificate['id']);
			// $res = $this->db->delete('tblmstcategory');
			$res=$this->db->query('call deleteCertificate(?)',$id);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_Certificate['Userid']),
					'Module' => 'Certificate',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
			

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
				$this->db->where('CertificateId',trim($post_data['CertificateId']));
				$res = $this->db->update('tblcertificatetemplate',$data);
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
			}	}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}
		public function getRoleList() {
	
			$this->db->select('RoleId,RoleName,IsActive');
			$this->db->where('RoleName!=','IT');
			$this->db->order_by('RoleName','asc');
			$result = $this->db->get('tblmstuserrole');
			
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;		
		}
	
		public function getPlaceholderList() {
		
			$this->db->select('PlaceholderId,PlaceholderName,IsActive');
			$this->db->where('IsActive',1);
			$result = $this->db->get('tblmstemailplaceholder');
			
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;		
		}
		
	
	
	
	//list Industry
	
	
}