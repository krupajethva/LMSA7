<?php

class Fileupload_model extends CI_Model
{
	

	public function add_Fileupload($post_Fileupload)
	{	try{
		if($post_Fileupload)
		{
			
			foreach($post_Fileupload['CourseImage'] as $row){
			$Fileupload_data = array(
				'CourseId' => $post_Fileupload['CourseId'],
				'CourseImage' => $row,
				'CourseVideo'=>'',
				'CourseDoc'=>'',
				'CreatedBy' => $post_Fileupload['CreatedBy']	
			);
			
			$res=$this->db->query('call addFileupload(?,?,?,?,?)',$Fileupload_data);
			//$out_param_query = $this->db->query('select @id as out_param;');
		}
		foreach($post_Fileupload['CourseVideo'] as $row){
			$Fileupload_data = array(
				'CourseId' => $post_Fileupload['CourseId'],
				'CourseVideo' => $row,
				'CourseImage'=>'',
				'CourseDoc'=>'',
				'CreatedBy' => $post_Fileupload['CreatedBy']	
			);$res=$this->db->query('call addFileupload(?,?,?,?,?)',$Fileupload_data);
		}
		foreach($post_Fileupload['CourseDoc'] as $row){
			$Fileupload_data = array(
				'CourseId' => $post_Fileupload['CourseId'],
				'CourseDoc' => $row,
				'CourseImage'=>'',
				'CourseVideo'=>'',
				'CreatedBy' => $post_Fileupload['CreatedBy']	
			);$res=$this->db->query('call addFileupload(?,?,?,?,?)',$Fileupload_data);
		}
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Fileupload['CreatedBy']),
						'Module' => 'upload',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
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
	function getlist_course()
	{
	try
	 {
		$this->db->select('con.CourseId,con.UserId,con.CourseFullName');
		$result = $this->db->get('tblcourse as con');
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
	
	//list Industry
	

}