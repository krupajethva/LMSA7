<?php

class Reset_model extends CI_Model
{
	  // add new password //
	public function reset_pass($post_pass) 
	{
		if($post_pass)
		{
			
			$pass_data = array(
				'Password' =>md5(trim($post_pass['Password'])),
				'ResetPasswordCode' =>'',
				'UpdatedOn' => date('y-m-d H:i:s')
				
			);
			
			$this->db->where('UserId',trim($post_pass['UserId']));
			//$this->db->where('IsStatus',0);
			$res = $this->db->update('tbluser',$pass_data);
			
			return true;
			
				
		} 
		else
		{
				return false;
		}	
	}

	
	 // check link used or not //
	public function reset_passlink2($post_passlink) 
	{
		if($post_passlink)
		{	
				$this->db->select('UserId,ResetPasswordCode');				
				$this->db->where('UserId',trim($post_passlink['UserId']));
				$this->db->where('ResetPasswordCode',trim($post_passlink['ResetPasswordCode']));
				$this->db->limit(1);
				$this->db->from('tbluser');
			    $query= $this->db->get();	
				if ($query->num_rows() == 1) 
				{
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
	
	
	
	
	
}