<?php

class Forgotpass_model extends CI_Model
{
	
	// forgot password //
	public function forgot_pass($post_pass) 
	{
	try{
		if($post_pass)
		{
				$this->db->select('UserId,EmailAddress,ResetPasswordCode');				
				$this->db->where('EmailAddress',trim($post_pass['EmailAddress']));
	
				$this->db->limit(1);
				$this->db->from('tbluser');
				$query = $this->db->get();
				
				if ($query->num_rows() == 1) 
				{
					$pass_data = array(
						'ResetPasswordCode' =>$post_pass['ResetPasswordCode'],
						'CreatedOn' => date('y-m-d H:i:s'),
						'UpdatedOn' => date('y-m-d H:i:s')
					);
					
					$this->db->where('EmailAddress',trim($post_pass['EmailAddress']));
					$res = $this->db->update('tbluser',$pass_data);
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
					if($res)
					{
					    $pass = array();
						foreach($query->result() as $row) {
							$pass = $row;
						}
						return $query->result()[0]->UserId;
					}else
					{
						return false;
					}
				
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