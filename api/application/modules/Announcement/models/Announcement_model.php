<?php

class Announcement_model extends CI_Model
 {	
	public function getAnnouncementTypes() {
        $result = $this->db->query('call getAnnouncementTypes()');
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	public function getAnnouncementAudience() {
        $this->db->select('aa.AudienceId,aa.Name,aa.IsActive');
		$this->db->order_by('aa.AudienceId','asc');
		$result = $this->db->get('tblannouncementaudience as aa');	
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	public function getAnnouncements($Id=Null) {
		if($Id) {
		$result = $this->db->query('call getAnnouncements(?)',$Id);
		//mysqli_next_result($this->db->conn_id);
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	else{
		return false;
	}
	}
    public function addAnnouncement($post_announce) {
		try{
		if($post_announce) {			
			if(trim($post_announce['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$AudienceUserIds=array();
			array_push($AudienceUserIds,$post_announce['UserId']);
			foreach ($post_announce['AudienceId'] as $audience)
			{
				if($audience == 2)
				{
					$this->db->select('if.InstructorFollowerId,if.FollowerUserId,if.IsActive');
					$this->db->where('if.InstructorUserId',trim($post_announce['UserId']));
					$result = $this->db->get('tblinstructorfollowers as if');
					foreach($result->result() as $row) {
						if(!(in_array($row->FollowerUserId,$AudienceUserIds))){
							array_push($AudienceUserIds,$row->FollowerUserId);
						}
					}
				}
				if($audience == 3)
				{
					$this->db->select('u.UserId,u.IsActive');
					$this->db->where('u.RoleId',4);
					$result = $this->db->get('tbluser as u');
					foreach($result->result() as $row) {
						if(!(in_array($row->UserId,$AudienceUserIds))){
							array_push($AudienceUserIds,$row->UserId);
						}
					}
				}
			}
			$announce_data = array(
				'AnnouncementTypeId' => trim($post_announce['AnnouncementTypeId']),
				'UserId' => trim($post_announce['UserId']),
				'AudienceUserIds' => implode(',', $AudienceUserIds),
				'AudienceId' => implode(',', $post_announce['AudienceId']),
                'Title' => trim($post_announce['Title']),	
                'StartDate' => trim($post_announce['StartDate']),	
				'EndDate' => trim($post_announce['EndDate']),
				'Description' => trim($post_announce['Description']),	
                'Location' => trim($post_announce['Location']),	
                'Organizer' => trim($post_announce['Organizer']),	
				'IsActive' => $IsActive,
				'CreatedBy' => trim($post_announce['CreatedBy']),
				'UpdatedBy' => trim($post_announce['UpdatedBy']),
				'Module' => 'Announcement'
			);			
			$res = $this->db->query('call addAnnouncement(?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$announce_data);	
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}		
			if($res) {
				return $AudienceUserIds;
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
	public function addAnnouncementType($post_announcetype) {
		try{
			if($post_announcetype) {			
				if(trim($post_announcetype['IsActive'])==1){
					$IsActive = true;
				} else {
					$IsActive = false;
				}
				$announcetype_data = array(
					'TypeName' => trim($post_announcetype['TypeName']),
					'ColorCode' => trim($post_announcetype['ColorCode']),
					'IsActive' => $IsActive,
					'CreatedBy' => trim($post_announcetype['CreatedBy']),
					'UpdatedBy' => trim($post_announcetype['UpdatedBy']),
					'UpdatedOn' => date('y-m-d H:i:s'),
				);			
				$res = $this->db->insert('tblannouncementtype',$announcetype_data);
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}		
				if($res) {
					$log_data = array(
						'UserId' => trim($post_announcetype['UpdatedBy']),
						'Module' => 'AnnouncementType',
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
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
	}
	public function getAnnounceTypeById($announcetype_id = NULL) {
		try{
		if($announcetype_id) {
			$this->db->select('at.AnnouncementTypeId,at.TypeName,at.ColorCode,at.IsActive');
			$this->db->where('at.AnnouncementTypeId',$announcetype_id);
			$result = $this->db->get('tblannouncementtype as at');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$announcetype_data = array();
			foreach($result->result() as $row) {
				$announcetype_data = $row;
			}
			return $announcetype_data;
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	public function getAnnouncementById($announce_id = NULL) {
		try{
		if($announce_id) {
			$this->db->select('a.AnnouncementId,a.UserId,a.AnnouncementTypeId,a.AudienceId,a.Title,a.StartDate,,a.EndDate,a.Description,a.Location,a.Organizer,a.IsActive');
			$this->db->where('a.AnnouncementId',$announce_id);
			$result = $this->db->get('tblannouncement as a');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$announce_data = array();
			foreach($result->result() as $row) {
				$row->AudienceId = explode(',', $row->AudienceId);
				$announce_data = $row;
			}
			return $announce_data;
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}	
	}
	public function editAnnouncementType($post_announcetype) {
		try{
		if($post_announcetype) {
			if(trim($post_announcetype['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$announcetype_data = array(
				'TypeName' => trim($post_announcetype['TypeName']),
				'ColorCode' => trim($post_announcetype['ColorCode']),
				'IsActive' => $IsActive,
				'UpdatedBy' => trim($post_announcetype['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s'),
			);			
			$this->db->where('AnnouncementTypeId',trim($post_announcetype['AnnouncementTypeId']));
			$res = $this->db->update('tblannouncementtype',$announcetype_data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_announcetype['UpdatedBy']),
					'Module' => 'AnnouncementType',
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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}
	public function editAnnouncement($post_announce) {
		try{
		if($post_announce) {
			if(trim($post_announce['IsActive'])==1){
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$AudienceUserIds=array();
			array_push($AudienceUserIds,$post_announce['UserId']);
			foreach ($post_announce['AudienceId'] as $audience)
			{
				if($audience == 2)
				{
					$this->db->select('if.InstructorFollowerId,if.FollowerUserId,if.IsActive');
					$this->db->where('if.InstructorUserId',trim($post_announce['UserId']));
					$result = $this->db->get('tblinstructorfollowers as if');
					foreach($result->result() as $row) {
						if(!(in_array($row->FollowerUserId,$AudienceUserIds))){
							array_push($AudienceUserIds,$row->FollowerUserId);
						}
					}
				}
				if($audience == 3)
				{
					$this->db->select('u.UserId,u.IsActive');
					$this->db->where('u.RoleId',4);
					$result = $this->db->get('tbluser as u');
					foreach($result->result() as $row) {
						if(!(in_array($row->UserId,$AudienceUserIds))){
							array_push($AudienceUserIds,$row->UserId);
						}
					}
				}
			}
			$announce_data = array(
				'AnnouncementTypeId' => trim($post_announce['AnnouncementTypeId']),
				'UserId' => trim($post_announce['UserId']),
				'AudienceUserIds' => implode(',', $AudienceUserIds),
				'AudienceId' => implode(',', $post_announce['AudienceId']),
                'Title' => trim($post_announce['Title']),	
                'StartDate' => trim($post_announce['StartDate']),	
				'EndDate' => trim($post_announce['EndDate']),
				'Description' => trim($post_announce['Description']),	
                'Location' => trim($post_announce['Location']),	
                'Organizer' => trim($post_announce['Organizer']),	
				'IsActive' => $IsActive,
				'UpdatedBy' => trim($post_announce['UpdatedBy']),
			);			
			$this->db->where('AnnouncementId',trim($post_announce['AnnouncementId']));
			$res = $this->db->update('tblannouncement',$announce_data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_announce['UpdatedBy']),
					'Module' => 'Announcement',
					'Activity' =>'Update'
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return $AudienceUserIds;
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