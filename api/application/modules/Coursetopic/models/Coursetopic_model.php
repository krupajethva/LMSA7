<?php

class Coursetopic_model extends CI_Model
{
			
	public function add_Coursetopic($add)
	{	$post_topic=$add['topic'];
		$post_Course=$add['course'];
		try{

		if($post_Course && $post_topic)
		{
			foreach($post_topic as $topic) {
			$Course_data = array(
				'CourseId' => $post_Course['CourseId'],
				'TopicName' => $topic['TopicName'],
				'DisplayOrder' => $topic['DisplayOrder'],
				'Description' => $topic['Description'],
				'CreatedBy' => $post_Course['CreatedBy'],
				'CreatedOn' => date('y-m-d H:i:s')
			);
			$res=$this->db->insert('tblcoursetopic',$Course_data);
			}
			
					 if($res) {
						 return true;
					 } else {
						 return false;
					 }
				
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Category['CreatedBy']),
						'Module' => 'Course',
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
	

	
	
	public function get_Coursedata($Course_id=Null)
	{
		try {
	  if($Course_id)
	  {

		 $this->db->select('cp.CourseId,cp.TopicName,cp.DisplayOrder,cp.Description,cp.IsActive,cp.TopicId');
		//$this->db->join('tblsessionschedule in', 'in.CourseId = cp.CourseId', 'left');
		 $this->db->where('cp.CourseId',$Course_id);
		 $result=$this->db->get('tblcoursetopic cp');
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Course_data= array();
		 if($result->result())
		 {
			$Course_data=$result->result();
			
		 }
		 return $Course_data;
		 
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
	
	 public function edit_Coursetopic($add)
	 {
		$post_topic=$add['topic'];
		$post_Course=$add['course'];
		try
		{
		if($post_Course) {
			$this->db->where('CourseId',$post_Course['CourseId']);
			$ress = $this->db->delete('tblcoursetopic');
			 if($ress)
			 {
				foreach($post_topic as $topic) {
					$Course_data = array(
						'CourseId' => $post_Course['CourseId'],
						'TopicName' => $topic['TopicName'],
						'DisplayOrder' => $topic['DisplayOrder'],
						'Description' => $topic['Description'],
						'CreatedBy' => $post_Course['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
					);
					$res=$this->db->insert('tblcoursetopic',$Course_data);
					}
					$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			if($res) 
			{	
				// $log_data = array(
				// 	'UserId' =>trim($post_Category['UpdatedBy']),
				// 	'Module' => 'Course',
				// 	'Activity' =>'Update'
	
				// );
				// $log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else
				{
				 return false;
			    }
	
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
	
	// function getlist_Coursetopic()
	// {
	// try{
	// 	$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseShortName,cp.CourseCode,cp.Price,cp.Duration,cp.ShowTo,cp.CourseImage as Favicon,cp.Description,cp.IsActive,in.CategoryName as parentName');
	//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.CategoryId', 'left');
	// 	$result = $this->db->get('tblcourse cp');
	// 	$db_error = $this->db->error();
	// 			if (!empty($db_error) && !empty($db_error['code'])) { 
	// 				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
	// 				return false; // unreachable return statement !!!
	// 			}
	// 	$res=array();
	// 	if($result->result())
	// 	{
	// 		$res=$result->result();
	// 	}
	// 	return $res;
	// 	}catch(Exception $e){
	// 	trigger_error($e->getMessage(), E_USER_ERROR);
	// 	return false;
	// 	}	
	// }
	function getlist_course()
	{
	try
	 {
		$this->db->select('con.CourseId,con.UserId,con.CourseFullName,(SELECT COUNT(mc.TopicId) FROM tblcoursetopic as mc WHERE mc.CourseId=con.CourseId) as isdisabled');
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
	

	


	public function delete_Course($post_Course) 
	{
	 try{
		if($post_Course) 
		{
			
			$this->db->where('CourseId',$post_Course['id']);
			$res = $this->db->delete('tblcourse');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) 
			{
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
	
	
	
	//list Industry
	
	
}