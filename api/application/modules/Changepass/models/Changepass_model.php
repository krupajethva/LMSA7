<?php

class Changepass_model extends CI_Model
{
	
	public function change_pass($post_pass) 
	{
		try{
		if($post_pass)
		{
				$this->db->select('UserId,Password,EmailAddress,FirstName');				
				$this->db->where('UserId',trim($post_pass['UserId']));
				$this->db->where('Password',md5(trim($post_pass['Password'])));
				$this->db->limit(1);
				$this->db->from('tbluser');
				$query = $this->db->get();
				
				if ($query->num_rows() == 1) 
				{
					$pass_data = array(
						
						'Password'=>md5($post_pass['nPassword']),
						'CreatedOn' => date('y-m-d H:i:s'),
						'UpdatedOn' => date('y-m-d H:i:s')
					);
			
					$this->db->where('UserId',trim($post_pass['UserId']));
					$res = $this->db->update('tbluser',$pass_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
					return true;
				
				} 
				else
				{
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


	
	
	
	
	
	
	
	
	
}