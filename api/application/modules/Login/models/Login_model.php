<?php

class Login_model extends CI_Model {

	public function check_login($data) {
			$this->db->select('u.UserId,u.InvitedByUserId,u.RoleId,u.FirstName,u.LastName,u.EmailAddress,u.IsActive,u.IsStatus');
			$this->db->from('tbluser u');
			$this->db->where('u.EmailAddress',trim($data['EmailAddress']));
			$this->db->where('u.Password',md5(trim($data['Password'])));
			//$this->db->where('u.IsActive',1);
			//$this->db->where('u.IsStatus',1);
			$this->db->limit(1);
			$query = $this->db->get();
		    $res=$query->result();
		    if ($query->num_rows() > 0) {
				if($res[0]->IsActive==0 && $res[0]->IsStatus == 1)
				{
					return 'Activation';
				}
				if($res[0]->IsActive==0 && $res[0]->IsStatus == 0)
				{
					return 'Deactive';
				}
				else
				{
					 $login_data = array(
						'UserId ' => trim($res[0]->UserId),
						'LoginType' => 1,
						'PanelType' => 1
		
						);
			
					$res = $this->db->insert('tblloginlog',$login_data);
					return $query->result();
				}
			
		} else {
			return false;
		}
		
	}	
	




}
