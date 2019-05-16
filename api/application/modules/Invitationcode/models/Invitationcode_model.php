<?php

class Invitationcode_model extends CI_Model
 {
	
	public function Invitation_code($post_Invitation) 
	{      
		
		$datetime1=date('Y-m-d',strtotime('-'.'30'.'days'));
		$this->db->select('UserId,EmailAddress,UpdatedOn');	
		$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));
		$this->db->where('UpdatedOn >',$datetime1);
		$this->db->limit(1);
		$result = $this->db->get('tbluser');	
		if ($result->num_rows() == 1) 
		{
			$d=trim($post_Invitation['Code']);
			$this->db->select('UserId,Code,EmailAddress');				
			$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));	
			//$this->db->where('Code',trim($post_Invitation['Code']));
			$this->db->where('Code = BINARY ',$d);
		//	$this->db->where('UserId',trim($post_Invitation['UserId']));
			$this->db->limit(1);
			$this->db->from('tbluser');
			$query = $this->db->get();

				if ($query->num_rows() == 1) 
				{
					return $query->result();
				
				} else
				{
					$this->db->select('UserId,EmailAddress,IsStatus');				
					$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));
					$this->db->where('IsStatus',2);
					$this->db->from('tbluser');
					$query = $this->db->get();
				
					if($query->num_rows() == 1)
					{
						return 'revoked';
						
					}else
					{
						return 'code';
						
					}
					
				}
		}else
		{
				$this->db->select('UserId,EmailAddress');	
				$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));
				$result = $this->db->get('tbluser');	
				if($result->num_rows() == 1)
							{
								return 'days';
								
							}else
							{
								
								return 'email';
								
							}
			
		}
		
		
	}
	
	
	// public function Invitation_code($post_Invitation) 
	// {      
	// 			$d=trim($post_Invitation['Code']);
	// 			$this->db->select('UserId,Code,EmailAddress');				
	// 			$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));	
	// 			//$this->db->where('Code',trim($post_Invitation['Code']));
	// 			$this->db->where('Code = BINARY ',$d);
	// 		//	$this->db->where('UserId',trim($post_Invitation['UserId']));
	// 			$this->db->limit(1);
	// 			$this->db->from('tbluser');
	// 			$query = $this->db->get();
			
	// 			if ($query->num_rows() == 1) 
	// 			{
	// 				return $query->result();
				
	// 			} else
	// 			{
	// 				$this->db->select('EmailAddress,IsStatus');				
	// 				$this->db->where('EmailAddress',trim($post_Invitation['EmailAddress']));
	// 				$this->db->where('IsStatus',2);
	// 				$this->db->from('tbluser');
	// 				$query = $this->db->get();
				
	// 				if($query->num_rows() == 1)
	// 				{
	// 					return 'revoked';
						
	// 				}else
	// 				{
	// 					return 'code';
						
	// 				}
					
	// 			}
			
		
		
		
		
	// }


	public function get_userdata($User_Id=Null)
	{
	  if($User_Id)
	  {
		$this->db->select('*');
		$this->db->where('UserId',$User_Id);
		$result=$this->db->get('tbluser');
		$user_data= array();
		foreach($result->result() as $row)
		{
		   $user_data=$row;
		   
		}
		return $user_data;
		 
	  }
	  else
	  {
		  return false;
	  }
	}
	
	
	
}
