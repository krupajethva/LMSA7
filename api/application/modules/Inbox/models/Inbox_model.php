<?php

class Inbox_model extends CI_Model
 {

	// get id wise Data //
	public function get_Inboxdata($EmailNotificationId = NULL)
	{
		try{
		if($EmailNotificationId) {
			 $result=$this->db->query("SELECT u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,u.EmailAddress,
			 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ')
			  FROM tbluser u 
			  WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
			   (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
				 FROM tbluser u
				 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
				   (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
				 FROM tbluser u
				 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
			   FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE e.EmailNotificationId='$EmailNotificationId'");
			$result = json_decode(json_encode($result->result()), True);
			 foreach($result as $row1){	
				 $row1['selectedCharacters']=explode(",",$row1['SenderId']);
				 $row1['selectedCharactersCc']=explode(",",$row1['CcEmailAddress']);
				
			 }
				return $row1;
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
		
	}

	 //  get list Inbox data //
	public function getlist_Inbox($user_id) {
		try{
		$result=$this->db->query("SELECT CONCAT(u.FirstName,' ',u.LastName) as Name,u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,
		
		(SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
		 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
		  (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
		 FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE (e.IsDelete!=1 and ((e.ToEmailAddress LIKE '%$user_id%') OR (e.CcEmailAddress LIKE '%$user_id%') OR (e.BccEmailAddress LIKE '%$user_id%')))ORDER BY e.EmailNotificationId DESC");
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

 //  get list Inbox count data //
	public function getlist_Inboxcount($user_id) {
		try{
		$this->db->select('COUNT(eml.EmailNotificationId) as Unreadcount');
		$this->db->where('eml.IsRead',0);
		$this->db->where('eml.IsDraft!=',1);	
		$this->db->where('eml.SenderId!=',$user_id);
		$result = $this->db->get('tblemailnotification eml');
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

		// ** get list sendbox data //
	public function getlist_Sendbox($user_id) {
		try{
		$result=$this->db->query("SELECT u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,
		(SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
		 (SELECT GROUP_CONCAT(CONCAT(u.FirstName,' ',u.LastName) SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as Names,
		 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
		  (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
		 FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE (e.IsDraft!=1 AND e.IsDelete!=1 AND (e.SenderId='$user_id')) ORDER BY e.EmailNotificationId DESC");
			
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
	
	  //  get list Starred data //
	public function getlist_Addstar($user_id) {	
		try{
		$result=$this->db->query("SELECT CONCAT(u.FirstName,' ',u.LastName) as Name,u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,
		(SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
		 (SELECT GROUP_CONCAT(CONCAT(u.FirstName,' ',u.LastName) SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as Names,
		 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
		  (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
		  FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE (e.IsStar=1 AND e.IsDelete!=1 AND (e.SenderId='$user_id' OR (e.ToEmailAddress LIKE '%$user_id%' OR (e.CcEmailAddress LIKE '%$user_id%') OR (e.BccEmailAddress LIKE '%$user_id%')))) ORDER BY e.EmailNotificationId DESC");


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
	

	// ** get list draft data //
	public function getlist_Draft($user_id) {
		try{	
		$result=$this->db->query("SELECT u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,
		(SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
		 (SELECT GROUP_CONCAT(CONCAT(u.FirstName,' ',u.LastName) SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as Names,
		 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
		  (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
		  FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE (e.IsDraft=1 AND e.IsDelete!=1 AND (e.SenderId='$user_id' OR (e.ToEmailAddress LIKE '%$user_id%' OR (e.CcEmailAddress LIKE '%$user_id%') OR (e.BccEmailAddress LIKE '%$user_id%')))) ORDER BY e.EmailNotificationId DESC");
		$res = array();
		$result = json_decode(json_encode($result->result()), True);
		 foreach($result as $row1){	
			 $row1['selectedCharacters']=explode(",",$row1['ToEmailAddress']);
			 $row1['selectedCharactersCc']=explode(",",$row1['CcEmailAddress']);
			 $row1['selectedCharactersBcc']=explode(",",$row1['BccEmailAddress']);
			 array_push($res,$row1);
		 }
		    return $res;
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}	
		
	}


	// ** get list draft count data //
	public function getlist_Draftcount($user_id) {
		try{	
		$this->db->select('COUNT(eml.EmailNotificationId) as Draftcount');
		$this->db->join('tbluser us','us.UserId = eml.SenderId', 'left');
		$this->db->where('eml.IsDraft',1);
		$this->db->where('us.UserId',$user_id);
		$result = $this->db->get('tblemailnotification eml');
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

	
	public function getlist_Spam($user_id) {
		try{	
		$result=$this->db->query("SELECT CONCAT(u.FirstName,' ',u.LastName) as Name,u.EmailAddress,e.EmailNotificationId,e.InvitedByUserId,e.SenderId,e.ToEmailAddress,e.CcEmailAddress,e.BccEmailAddress,e.Subject,e.MessageBody,e.IsRead,e.IsStar,e.IsDraft,e.IsDelete,e.IsActive,e.CreatedOn,e.UpdatedOn,
		(SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as ToEmailAddressGroup,
		 (SELECT GROUP_CONCAT(CONCAT(u.FirstName,' ',u.LastName) SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.ToEmailAddress)) as Names,
		 (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.CcEmailAddress)) as CcEmailAddressGroup,
		  (SELECT GROUP_CONCAT(u.EmailAddress SEPARATOR ', ') 
		 FROM tbluser u
		 WHERE FIND_IN_SET(u.UserId, e.BccEmailAddress)) as BccEmailAddressGroup
		  FROM tblemailnotification e LEFT JOIN tbluser u ON u.UserId=e.SenderId WHERE (e.IsDelete=1 AND (e.SenderId='$user_id' OR (e.ToEmailAddress LIKE '%$user_id%' OR (e.CcEmailAddress LIKE '%$user_id%') OR (e.BccEmailAddress LIKE '%$user_id%')))) ORDER BY e.EmailNotificationId DESC");
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


// ** delete emails
	public function delete_Inbox($post_Inbox) {
		try{
			if($post_Inbox) {
				
				 $this->db->where('EmailNotificationId',$post_Inbox['id']);
				 $res = $this->db->delete('tblemailnotification');
				 $db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
				if($res) {
					$log_data = array(
						'UserId' => trim($post_Inbox['Userid']),
						'Module' => 'Inbox Email',
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
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}


		// ** add to Multi Emails as Unread
		public function unread_MultiEmails($post_Email) {
		try{
			if($post_Email) {
				foreach($post_Email['MultiId'] as $read)
				{
								$Email_data = array(
							'IsRead' =>0,
							"UpdatedBy" =>  trim($post_Email['Userid']),
							'UpdatedOn' => date('y-m-d H:i:s')	
						);
						$this->db->where('EmailNotificationId',$read);
						$res = $this->db->update('tblemailnotification',$Email_data);
						$db_error = $this->db->error();
						if (!empty($db_error) && !empty($db_error['code'])) { 
							throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
							return false; // unreachable return statement !!!
						}
				}
				if($res) {
					$log_data = array(
						'UserId' => trim($post_Email['Userid']),
						'Module' => 'Inbox Email',
						'Activity' =>'Add as Unread'
	
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		 
		}


			// ** add send to Multi Emails as Unread
			public function unread_sendMultiEmails($post_Email) {
			try{
				if($post_Email) {
					foreach($post_Email['MultiId'] as $read)
					{
									$Email_data = array(
								'IsRead' =>0,
								"UpdatedBy" =>  trim($post_Email['Userid']),
								'UpdatedOn' => date('y-m-d H:i:s')	
							);
							$this->db->where('EmailNotificationId',$read);
							$res = $this->db->update('tblemailnotification',$Email_data);
							$db_error = $this->db->error();
							if (!empty($db_error) && !empty($db_error['code'])) { 
								throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
								return false; // unreachable return statement !!!
							}
					}
					if($res) {
						$log_data = array(
							'UserId' => trim($post_Email['Userid']),
							'Module' => 'Inbox Email',
							'Activity' =>'Add as Unread'
		
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
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			}
		


	// ** add to Multi Emails as Read
	public function read_MultiEmails($post_Email) {
	try{	
		if($post_Email) {
			foreach($post_Email['MultiId'] as $read)
			{
							$Email_data = array(
						'IsRead' =>1,
						"UpdatedBy" =>  trim($post_Email['Userid']),
						'UpdatedOn' => date('y-m-d H:i:s')	
					);
					$this->db->where('EmailNotificationId',$read);
					$res = $this->db->update('tblemailnotification',$Email_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Inbox Email',
					'Activity' =>'Add as Unread'

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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	 
	}


	// ** add Multi Emails as Starred
	public function addStar_MultiEmails($post_Email) {
	try{	
		if($post_Email) {
			foreach($post_Email['MultiId'] as $starred)
			{
							$Email_data = array(
						'IsStar' =>1,
						"UpdatedBy" =>  trim($post_Email['Userid']),
						'UpdatedOn' => date('y-m-d H:i:s')
					);
					$this->db->where('EmailNotificationId',$starred);
					$res = $this->db->update('tblemailnotification',$Email_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Inbox Email',
					'Activity' =>'Add as Starred'

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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}


	// ** add sendbox to mark as multie sttared
	public function addStar_sendMultiEmails($post_Email) {
	try{	
		if($post_Email) {
			foreach($post_Email['MultiId'] as $starred)
			{
							$Email_data = array(
						'IsStar' =>1,
						"UpdatedBy" =>  trim($post_Email['Userid']),
						'UpdatedOn' => date('y-m-d H:i:s')
					);
					$this->db->where('EmailNotificationId',$starred);
					$res = $this->db->update('tblemailnotification',$Email_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Inbox Email',
					'Activity' =>'Add as Starred'

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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}


	// ** delete Multi Emails
	public function delete_AllPermInbox($post_Email) {
	try{
				if($post_Email) {
					
					foreach($post_Email['MultiId'] as $important)
					{			
							$this->db->where('EmailNotificationId',$important);
							$res = $this->db->delete('tblemailnotification');
					}
					$db_error = $this->db->error();
						if (!empty($db_error) && !empty($db_error['code'])) { 
							throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
							return false; // unreachable return statement !!!
						}
					if($res) {
						$log_data = array(
							'UserId' => trim($post_Email['Userid']),
							'Module' => 'Multie Inbox Email',
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	 
	}


	// ** add as Spams Multi Emails
	public function delete_MultiEmails($post_Email) {
	try{	
		if($post_Email) {
			foreach($post_Email['MultiId'] as $important)
			{
							$Email_data = array(
						'IsDelete' =>1,
						"UpdatedBy" =>  trim($post_Email['Userid']),
						'UpdatedOn' => date('y-m-d H:i:s')
					);
					$this->db->where('EmailNotificationId',$important);
					$res = $this->db->update('tblemailnotification',$Email_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Inbox Email',
					'Activity' =>'Add as Spams'

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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	


public function delete_Emails($post_Email) {
try{		
	if($post_Email) {
		if($post_Email['IsDelete']=='1')
		{
			$IsDelete = false;
		} else {
			$IsDelete = true;
		}
				$Email_data = array(
			'EmailNotificationId' => trim($post_Email['EmailNotificationId']),		
			'IsDelete' =>$IsDelete,
			'IsDraft' =>0,
			"UpdatedBy" =>  trim($post_Email['Userid']),
			'UpdatedOn' => date('y-m-d H:i:s')
		
		);
		$this->db->where('EmailNotificationId',$post_Email['EmailNotificationId']);
		$res = $this->db->update('tblemailnotification',$Email_data);
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		if($res) {
			$log_data = array(
				'UserId' => trim($post_Email['Userid']),
				'Module' => 'Inbox Email',
				'Activity' =>'Add or Remove as Spams'

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
catch(Exception $e){
	trigger_error($e->getMessage(), E_USER_ERROR);
	return false;
}
}
public function recoverMail($post_Email) {
	try{		
		if($post_Email) {
			if($post_Email['IsDelete']=='1')
			{
				$IsDelete = false;
			} else {
				$IsDelete = true;
			}
					$Email_data = array(
				'EmailNotificationId' => trim($post_Email['EmailNotificationId']),		
				'IsDelete' =>$IsDelete,
				"UpdatedBy" =>  trim($post_Email['Userid']),
				'UpdatedOn' => date('y-m-d H:i:s')
			
			);
			$this->db->where('EmailNotificationId',$post_Email['EmailNotificationId']);
			$res = $this->db->update('tblemailnotification',$Email_data);
			$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Recover Email',
					'Activity' =>'Recover email from spam to inbox'
	
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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

    // ** add to Email as Read only
	public function read_Emails($post_Email) {
	try{
			if($post_Email) {
				if($post_Email['IsRead']=='1')
				{
					$IsRead = false;
				} else {
					$IsRead = true;
				}
						$Email_data = array(
					'EmailNotificationId' => trim($post_Email['EmailNotificationId']),		
					'IsRead' =>$IsRead,
					"UpdatedBy" =>  trim($post_Email['Userid']),
					'UpdatedOn' => date('y-m-d H:i:s')
				
				);
				$this->db->where('EmailNotificationId',$post_Email['EmailNotificationId']);
				$res = $this->db->update('tblemailnotification',$Email_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($res) {
					$log_data = array(
						'UserId' => trim($post_Email['Userid']),
						'Module' => 'Inbox Email',
						'Activity' =>'Add or Remove as Unread'
	
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		}


		// ** add to Email as Read
	public function readOnly_Emails($post_Email) {
	try{	
		if($post_Email) {
			
					$Email_data = array(
				'EmailNotificationId' => trim($post_Email['EmailNotificationId']),		
				'IsRead' =>1,
				"UpdatedBy" =>  trim($post_Email['Userid']),
				'UpdatedOn' => date('y-m-d H:i:s')
			
			);
			$this->db->where('EmailNotificationId',$post_Email['EmailNotificationId']);
			$res = $this->db->update('tblemailnotification',$Email_data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_Email['Userid']),
					'Module' => 'Inbox Email',
					'Activity' =>'Mark as Read'

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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

		// ** add to Email as Starred
		public function addStar_Emails($post_Email) {
		try{
			if($post_Email) {
				if($post_Email['IsStar']=='1')
				{
					$IsStar = false;
				} else {
					$IsStar = true;
				}
						$Email_data = array(
					'EmailNotificationId' => trim($post_Email['EmailNotificationId']),		
					'IsStar' => $IsStar,
					"UpdatedBy" =>  trim($post_Email['Userid']),
					'UpdatedOn' => date('y-m-d H:i:s')
				
				);
				$this->db->where('EmailNotificationId',$post_Email['EmailNotificationId']);
				$res = $this->db->update('tblemailnotification',$Email_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($res) {
					$log_data = array(
						'UserId' => trim($post_Email['Userid']),
						'Module' => 'Inbox Email',
						'Activity' =>'Add or Remove as Starred'
	
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
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		}




	 // ** Email add as draft //
		public function addDraftEmail($post_Inbox)
		{	
			try{			
					if($post_Inbox)
					{		
						if(isset($post_Inbox['UserId']))
						{
							$ToEmailAddress11 = $post_Inbox['UserId'];
							$ToEmailAddressarray = implode(",", $ToEmailAddress11);

							if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
								$SenderId = $post_Inbox['CreatedBy'];
							}	else {
								$SenderId =0;
							}

							if(isset($post_Inbox['UserId2']) && !empty($post_Inbox['UserId2'])){
								$CcEmailAddress11 = $post_Inbox['UserId2'];
								$CcEmailAddressarray = implode(",", $CcEmailAddress11);
							}	else {
								$CcEmailAddressarray ='';
							}
							
							if(isset($post_Inbox['UserId3']) && !empty($post_Inbox['UserId3'])){
								$BccEmailAddress11 = $post_Inbox['UserId3'];
								$BccEmailAddressarray = implode(",", $BccEmailAddress11);
							}	else {
								$BccEmailAddressarray ='';
							}

							if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
								$SenderId = $post_Inbox['CreatedBy'];
							}	else {
								$SenderId =0;
							}

							if(isset($post_Inbox['Subject']) && !empty($post_Inbox['Subject'])){
								$Subject = $post_Inbox['Subject'];
							}	else {
								$Subject ='';
							}

							if(isset($post_Inbox['MessageBody']) && !empty($post_Inbox['MessageBody'])){
								$MessageBody = $post_Inbox['MessageBody'];
							}	else {
								$MessageBody ='';
							}

											$Inbox_data = array(
												"SenderId" => $SenderId,
												"ToEmailAddress" =>$ToEmailAddressarray,
												"CcEmailAddress" =>$CcEmailAddressarray,
												"BccEmailAddress" =>$BccEmailAddressarray,
												"Subject" => trim($Subject),
												"MessageBody" => trim($MessageBody),
												"IsDraft" => 1,
												"IsRead" => 1,
												"CreatedBy" =>trim($SenderId),
												"CreatedOn" =>date('y-m-d H:i:s')
			
										);
										$res1 = $this->db->insert('tblemailnotification',$Inbox_data);
										$EmailNotificationId = $this->db->insert_id();
			
										if($post_Inbox['Attachment']!='')
										{
											foreach($post_Inbox['Attachment'] as $attach)
											{
														$attach_data=array(	
															"EmailNotificationId" => $EmailNotificationId,
															"Attachment" =>  $attach,
															"CreatedBy" =>trim($post_Inbox['CreatedBy']),
															"CreatedOn" =>date('y-m-d H:i:s')		
														);		
														$res=$this->db->insert('tblEmailAttachment',$attach_data);
						
											}			
												
										}
									
							return true;
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

	 // ** Email add as draft //
	 public function editDraftEmail($post_Inbox)
	 {	
		 try{			
				 if($post_Inbox)
				 {		
					 if(isset($post_Inbox['UserId']))
					 {
						 $ToEmailAddress11 = $post_Inbox['UserId'];
						 $ToEmailAddressarray = implode(",", $ToEmailAddress11);

						 if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
							 $SenderId = $post_Inbox['CreatedBy'];
						 }	else {
							 $SenderId =0;
						 }

						 if(isset($post_Inbox['UserId2']) && !empty($post_Inbox['UserId2'])){
							 $CcEmailAddress11 = $post_Inbox['UserId2'];
							 $CcEmailAddressarray = implode(",", $CcEmailAddress11);
						 }	else {
							 $CcEmailAddressarray ='';
						 }
						 
						 if(isset($post_Inbox['UserId3']) && !empty($post_Inbox['UserId3'])){
							 $BccEmailAddress11 = $post_Inbox['UserId3'];
							 $BccEmailAddressarray = implode(",", $BccEmailAddress11);
						 }	else {
							 $BccEmailAddressarray ='';
						 }

						 if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
							 $SenderId = $post_Inbox['CreatedBy'];
						 }	else {
							 $SenderId =0;
						 }

						 if(isset($post_Inbox['Subject']) && !empty($post_Inbox['Subject'])){
							 $Subject = $post_Inbox['Subject'];
						 }	else {
							 $Subject ='';
						 }

						 if(isset($post_Inbox['MessageBody']) && !empty($post_Inbox['MessageBody'])){
							 $MessageBody = $post_Inbox['MessageBody'];
						 }	else {
							 $MessageBody ='';
						 }

										 $Inbox_data = array(
											 "SenderId" => $SenderId,
											 "ToEmailAddress" =>$ToEmailAddressarray,
											 "CcEmailAddress" =>$CcEmailAddressarray,
											 "BccEmailAddress" =>$BccEmailAddressarray,
											 "Subject" => trim($Subject),
											 "MessageBody" => trim($MessageBody),
											 "IsDraft" => 1,
											 "IsRead" => 1,
											 "UpdatedBy" =>trim($SenderId),
											 "UpdatedOn" =>date('y-m-d H:i:s')
		 
									 );
									 $this->db->where('EmailNotificationId',$post_Inbox['EmailNotificationId']);
									 $res1 = $this->db->update('tblemailnotification',$Inbox_data);
									// $EmailNotificationId = $this->db->insert_id();
		 
									 if($post_Inbox['Attachment']!='')
									 {
										 foreach($post_Inbox['Attachment'] as $attach)
										 {
													 $attach_data=array(	
														 //"EmailNotificationId" => $post_Inbox['EmailNotificationId'],
														 "Attachment" =>  $attach,
														 "UpdatedBy" =>trim($post_Inbox['UpdatedBy']),
														 "UpdatedOn" =>date('y-m-d H:i:s')		
													 );		
													 $this->db->where('EmailNotificationId',$post_Inbox['EmailNotificationId']);
													 $res=$this->db->update('tblEmailAttachment',$attach_data);
					 
										 }			
											 
									 }
								 
						 return true;
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


		//list user role
	public function getlist_user()
	{
		$this->db->select('UserId as value,CONCAT(FirstName, " ",LastName, " (",EmailAddress,")") as label');
		$this->db->where('IsActive=',1);
		$this->db->where('IsStatus=',0);
		$this->db->order_by('FirstName',"ASC");
		$result=$this->db->get('tbluser');
		$res=array();
		if($result->result())
		{
			$res=$result->result();
		}
		return $res;
	}







	 // ** new email add // 
		public function addEmail($post_Inbox)
		{
			try{				
				if($post_Inbox)
				{		
					if(isset($post_Inbox['EmailNotificationId']) && !empty($post_Inbox['EmailNotificationId']))
					{

						if($post_Inbox['EmailNotificationId']>0)
						{
							$resultTo=$this->db->query("SELECT aa.UserId,aa.FirstName,aa.LastName,aa.EmailAddress,a.ToEmailAddress FROM tblemailnotification as a INNER JOIN tbluser aa ON find_in_set(aa.UserId, a.ToEmailAddress)>0 WHERE find_in_set(aa.UserId, a.ToEmailAddress) and a.EmailNotificationId=".$post_Inbox['EmailNotificationId']);
							$ToEmailAddress11=$resultTo->result();
							$EmailNotificationId = $post_Inbox['EmailNotificationId'];	
							
							if(isset($post_Inbox['selectedCharacters']) && !empty($post_Inbox['selectedCharacters'])){
								$ToEmailAddress11 = $post_Inbox['selectedCharacters'];
								$ToEmailAddressarray = implode(",", $ToEmailAddress11);
							}	else {
								$ToEmailAddressarray ='';
							}	

						
							if(isset($post_Inbox['selectedCharactersCc']) && !empty($post_Inbox['selectedCharactersCc'])){
								
								$CcEmailAddress11 = $post_Inbox['selectedCharactersCc'];
							$CcEmailAddressarray = implode(",", $CcEmailAddress11);
							}	else {
								$CcEmailAddressarray='';
							}
							
							if(isset($post_Inbox['selectedCharactersBcc']) && !empty($post_Inbox['selectedCharactersBcc'])){
								$BccEmailAddress11 = $post_Inbox['selectedCharactersBcc'];
								$BccEmailAddressarray = implode(",", $BccEmailAddress11);
							}	else {
								$BccEmailAddressarray ='';
							}

							if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
								$SenderId = $post_Inbox['CreatedBy'];
							}	else {
								$SenderId =0;
							}

							if(isset($post_Inbox['Subject']) && !empty($post_Inbox['Subject'])){
								$Subject = $post_Inbox['Subject'];
							}	else {
								$Subject ='';
							}

							if(isset($post_Inbox['InvitedByUserId']) && !empty($post_Inbox['InvitedByUserId'])){
								$InvitedByUserId = $post_Inbox['InvitedByUserId'];
							}	else {
								$InvitedByUserId =NULL;
							}

										$Inbox_data1 =array(
														"InvitedByUserId" => $InvitedByUserId,
														"SenderId" => $SenderId,
														"ToEmailAddress" =>$ToEmailAddressarray,
														"CcEmailAddress" =>$CcEmailAddressarray,
														"BccEmailAddress" =>$BccEmailAddressarray,
														"Subject" => trim($Subject),
														"IsDraft" => 0,
														"MessageBody" => trim($post_Inbox['MessageBody']),
														"CreatedBy" =>trim($post_Inbox['CreatedBy']),
														"CreatedOn" =>date('y-m-d H:i:s')
															);
											$this->db->where('EmailNotificationId',trim($post_Inbox['EmailNotificationId']));
											$res1 = $this->db->update('tblemailnotification',$Inbox_data1);
										

											if($post_Inbox['Attachment']!='')
											{
												foreach($post_Inbox['Attachment'] as $attach)
												{
															$attach_data=array(	
																"EmailNotificationId" => $post_Inbox['EmailNotificationId'],
																"Attachment" =>  $attach,
																"CreatedBy" =>trim($post_Inbox['CreatedBy']),
																"CreatedOn" =>date('y-m-d H:i:s')		
															);		
															$res=$this->db->insert('tblEmailAttachment',$attach_data);
												}					
											}
											else
											{
												return $EmailNotificationId;
											}	
						}
					}
					else
					{
					
						if(isset($post_Inbox['UserId']) && !empty($post_Inbox['UserId'])){
							$ToEmailAddress11 = $post_Inbox['UserId'];
						   $ToEmailAddress = implode(",", $ToEmailAddress11);
						}	
						else {	
							$ToEmailAddress ='';			
						}
						
						
						if(isset($post_Inbox['UserId2']) && !empty($post_Inbox['UserId2'])){
							$CcEmailAddress11 = $post_Inbox['UserId2'];
							$CcEmailAddress = implode(",", $CcEmailAddress11);
						}	
						else {
							$CcEmailAddress ='';			
						}
						
						if(isset($post_Inbox['UserId3']) && !empty($post_Inbox['UserId3'])){
							$BccEmailAddress11 = $post_Inbox['UserId3'];
							$BccEmailAddress = implode(",", $BccEmailAddress11);
						}	else {
							$BccEmailAddress ='';
						}

						if(isset($post_Inbox['CreatedBy']) && !empty($post_Inbox['CreatedBy'])){
							$SenderId = $post_Inbox['CreatedBy'];
						}	else {
							$SenderId =0;
						}

						if(isset($post_Inbox['InvitedByUserId']) && !empty($post_Inbox['InvitedByUserId'])){
							$InvitedByUserId = $post_Inbox['InvitedByUserId'];
						}	else {
							$InvitedByUserId =NULL;
						}
						
									$Inbox_data = array(
										"InvitedByUserId" => $InvitedByUserId,
										"SenderId" => $SenderId,
										"ToEmailAddress" =>$ToEmailAddress,
										"CcEmailAddress" =>$CcEmailAddress,
										"BccEmailAddress" =>$BccEmailAddress,
										"Subject" => trim($post_Inbox['Subject']),
										"MessageBody" => trim($post_Inbox['MessageBody']),
										"CreatedBy" =>trim($post_Inbox['CreatedBy']),
										"CreatedOn" =>date('y-m-d H:i:s')

								);
								$res1 = $this->db->insert('tblemailnotification',$Inbox_data);
								$EmailNotificationId = $this->db->insert_id();

								if($post_Inbox['Attachment']!='')
								{
									foreach($post_Inbox['Attachment'] as $attach)
									{
												$attach_data=array(	
													"EmailNotificationId" => $EmailNotificationId,
													"Attachment" =>  $attach,
													"CreatedBy" =>trim($post_Inbox['CreatedBy']),
													"CreatedOn" =>date('y-m-d H:i:s')		
												);		
												$res=$this->db->insert('tblEmailAttachment',$attach_data);
				
									}					
								}
								else
								{
									//return true;
									return $EmailNotificationId;
								}	
					}		
					//return true;
					return $EmailNotificationId;
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


	
}
