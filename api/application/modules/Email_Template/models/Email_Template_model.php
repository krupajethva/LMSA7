<?php

class Email_Template_model extends CI_Model
 {

	public function add_email($post_email) {
	
		if($post_email) {
			
			if(trim($post_email['check'])==0){
				if(trim($post_email['IsActive'])==1){

					$this->db->select('EmailId');
					$this->db->where('TokenId',trim($post_email['TokenId']));
					$this->db->where('To',trim($post_email['To']));
					$this->db->where('IsActive',true);
					$query = $this->db->get('tblemailtemplate');
					
					if($query->num_rows() > 0){
						return 'sure';		
					} 
				}	
			}	
			
			if(trim($post_email['IsActive'])==1){
				$email_updatedata = array(
					'IsActive' => false,
				);
				$this->db->where('TokenId',trim($post_email['TokenId']));
				$this->db->where('To',trim($post_email['To']));
				$this->db->where('IsActive',true);
				$update_res = $this->db->update('tblemailtemplate',$email_updatedata);
			}

			if(trim($post_email['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			if(isset($post_email['BccEmail']) && !empty(trim($post_email['BccEmail']))){
				$BccEmail = trim($post_email['BccEmail']);
			} else {
				$BccEmail = '';
			}		
			$email_data = array(
				'TokenId' => trim($post_email['TokenId']),
				'Subject' => trim($post_email['Subject']),
				'EmailBody' => trim($post_email['EmailBody']),
				'To' => trim($post_email['To']),
				'Cc' => trim($post_email['Cc']),
				'Bcc' => trim($post_email['Bcc']),
				'BccEmail' => $BccEmail,
				'IsActive' => $IsActive,
				'CreatedBy' => trim($post_email['CreatedBy']),
				'CreatedOn' =>  date('y-m-d H:i:s'),
				//'UpdatedBy' => trim($post_email['UpdatedBy'])
			);

			$res = $this->db->insert('tblemailtemplate',$email_data);
			//$res= $this->db->query('call emailTemplateAdd(?,?,?,?,?,?,?,?,?,?,?)',$email_data);
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_email['CreatedBy']),
					'Module' => 'Email Template',
					'Activity' =>'Add'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		
		} else {
			return false;
		}
		
	}
	
	public function getlist_email() {

		$this->db->select('et.EmailId,tok.TokenId,tok.TokenName,et.Subject,et.EmailBody,et.To,et.Cc,et.Bcc,et.IsActive,role1.RoleName as roleTo,role2.RoleName as roleCc,role3.RoleName as roleBcc');
		$this->db->join('tblmstuserrole role1', 'role1.RoleId = et.To', 'left');
		$this->db->join('tblmstuserrole role2', 'role2.RoleId = et.Cc', 'left');
		$this->db->join('tblmstuserrole role3', 'role3.RoleId = et.Bcc', 'left');
		$this->db->join('tblmsttoken tok', 'tok.TokenId = et.TokenId', 'left');
		$this->db->order_by('EmailId','asc');
		$result = $this->db->get('tblemailtemplate as et');
		// $result = $this->db->query('call emailTemplateList()');
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;		
	}
	
	// ** isActive
	public function isActiveChange($post_data) {
	
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
			$this->db->where('EmailId',trim($post_data['EmailId']));
			$res = $this->db->update('tblemailtemplate',$data);
			if($res) {
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}

	
	public function get_emaildata($email_id = NULL) {
		
		if($email_id) {
			
			$this->db->select('et.EmailId,tok.TokenId,tok.TokenName,et.Subject,et.EmailBody,et.To,et.Cc,et.Bcc,et.BccEmail,et.IsActive');
			$this->db->where('et.EmailId',$email_id);
			$this->db->join('tblmsttoken tok', 'tok.TokenId = et.TokenId', 'left');
			$result = $this->db->get('tblemailtemplate as et');
			
			$email_data = array();
			foreach($result->result() as $row){
				$email_data = $row;
			}
			return $email_data;
			
		} else {
			return false;
		}
	}
	
	
	public function edit_email($post_email) {
	
		if($post_email) {
			
			// if(trim($post_email['check'])==0){
			// 	if(trim($post_email['IsActive'])==1){

			// 		$this->db->select('EmailId');
			// 		$this->db->where('TokenId',trim($post_email['TokenId']));
			// 		$this->db->where('To',trim($post_email['To']));
			// 		$this->db->where('IsActive',true);
			// 		$query = $this->db->get('tblemailtemplate');
			// 		if($query->num_rows() > 0){
			// 			return 'sure';		
			// 		} 
			// 	}	
			// }	
			
			if(trim($post_email['IsActive']==1)){
				$email_updatedata = array(
					'IsActive' => false,
				);
				$this->db->where('TokenId',trim($post_email['TokenId']));
				$this->db->where('To',trim($post_email['To']));
				$this->db->where('IsActive',true);
				$update_res = $this->db->update('tblemailtemplate',$email_updatedata);
			}
						
			if(trim($post_email['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			if(isset($post_email['BccEmail']) && !empty(trim($post_email['BccEmail']))){
				$BccEmail = trim($post_email['BccEmail']);
			} else {
				$BccEmail = '';
			}		
			$email_data = array(
				'EmailId' => trim($post_email['EmailId']),
				'TokenId' => trim($post_email['TokenId']),
				'Subject' => trim($post_email['Subject']),
				'EmailBody' => trim($post_email['EmailBody']),
				'To' => trim($post_email['To']),
				'Cc' => trim($post_email['Cc']),
				'Bcc' => trim($post_email['Bcc']),
				'BccEmail' => $BccEmail,
				'IsActive' => $IsActive,
				'UpdatedBy' => trim($post_email['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s'),
			);

			$this->db->where('EmailId',$post_email['EmailId']);
			$res = $this->db->update('tblemailtemplate',$email_data);
			// $res= $this->db->query('call emailTemplateUpdate(?,?,?,?,?,?,?,?,?,?,?)',$post_email);
			if($res) {
				$log_data = array(
					'UserId' => trim($post_email['UpdatedBy']),
					'Module' => 'Email Template',
					'Activity' =>'Update'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		
		} else {
			return false;
		}
	}
	
	
	public function delete_email($email_id) {
	
		if($email_id) {
			
			// $this->db->where('EmailId',$email_id['id']);
			// $res = $this->db->delete('tblemailtemplate');
			$res= $this->db->query('call emailTemplateDelete(?)',$email_id['id']);	
			if($res) {
				$log_data = array(
					'UserId' =>  trim($email_id['Userid']),
					'Module' => 'Email Template',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}
		} else {
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

	
	public function getlist_tocken() {
	
		$this->db->select('*');
		$this->db->where('IsActive',1);
		$result = $this->db->get('tblmsttoken');
		
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;		
	}
	

	
}
