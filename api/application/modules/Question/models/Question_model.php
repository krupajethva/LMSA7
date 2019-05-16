<?php

class Question_model extends CI_Model
{
			
	function getlist_Course($userid = NULL)
	{
	try{
		$result=$this->db->query('select cp.CourseId,cp.CourseId,cp.CourseFullName,COUNT(cs.CourseSessionId) as totalSession,(SELECT COUNT(mc.CourseId) FROM tblmstquestion as mc
		WHERE mc.CourseId=cs.CourseId) as totalcourse
        FROM tblcourseinstructor AS csi 
		LEFT JOIN  tblcoursesession AS cs ON cs.CourseSessionId = csi.CourseSessionId
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = cs.CourseId
        WHERE csi.UserId='.$userid.' AND cp.CourseId IS NOT null GROUP BY cp.CourseId');

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
	function getlist_question($coueseid = NULL)
	{
	try{
		$result=$this->db->query('select tmq.CourseId,tmq.QuestionId,tmq.QuestionName,tmq.IsActive,
		(SELECT COUNT(mc.QuestionId) FROM tbllearnertest as mc WHERE mc.QuestionId=tmq.QuestionId) as isdisabled 
        FROM tblmstquestion AS tmq WHERE tmq.CourseId='.$coueseid);

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
	public function add_question($post_question) {
		$post_QuestionEntity=$post_question['QuestionEntity'];
	//	$post_TopicList=$post_question['TopicList'];
		if($post_question) {
			
			if($post_QuestionEntity['IsActive']==1)
			{
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$question_data = array(
				"CourseId"=>trim($post_QuestionEntity['CourseId']),
				'QuestionName' => trim($post_QuestionEntity['QuestionName']),
				"IsActive"=>$IsActive,
				"CreatedBy" => trim($post_QuestionEntity['CreatedBy']),
				"CreatedOn" =>date('y-m-d H:i:s')
			
			);
			$res = $this->db->insert('tblmstquestion',$question_data);
			$QuestionId = $this->db->insert_id();
			foreach($post_question['TopicList'] as $topic)
					{
						if($topic['CorrectAnswer']==1)
						{
							$CorrectAnswer = true;
						} else {
							$CorrectAnswer = false;
						}
						$option_data = array(
							'QuestionId' => $QuestionId,
							'OptionValue' => $topic['OptionValue'],
							'CorrectAnswer' => $CorrectAnswer,
							'CreatedBy' => $post_QuestionEntity['CreatedBy'],
							'CreatedOn' => date('y-m-d H:i:s')
							);
							$res = $this->db->insert('tblmstquestionoption',$option_data);
						
					}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_QuestionEntity['CreatedBy']),
					'Module' => 'Question',
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
	public function get_Questiondata($Qid=Null)
	{
		try {
	  if($Qid)
	  {
		$result=$this->db->query('SELECT tmq.CourseId,tmq.QuestionId,tmq.QuestionName,tmq.IsActive 
		from tblmstquestion as tmq where tmq.QuestionId='.$Qid);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 //$Question_data= array();
		 foreach($result->result() as $row)
		 {
			//mysqli_next_result($this->db->conn_id);
			$res=$this->db->query('SELECT tmo.OptionId,tmo.QuestionId,tmo.OptionValue,tmo.CorrectAnswer,
			(SELECT COUNT(mc.QuestionId) FROM tbllearnertest as mc WHERE mc.QuestionId='.$row->QuestionId.') as isdisabled 
			from tblmstquestionoption as tmo where tmo.QuestionId='.$row->QuestionId);
			$subarray = array();			
			foreach($res->result() as $row1) {
				array_push($subarray,$row1);	
			}
			$row->TopicList=$subarray;
			$Question_data=$row;
			//array_push($Question_data,$row);
			
		 }
		 return $Question_data;
		 
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
	
	public function get_Coursedata($id=Null)
	{
		try {
	  if($id)
	  {
		$result=$this->db->query('SELECT tmq.CourseFullName 
		from tblcourse as tmq where tmq.CourseId='.$id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Question_data= array();
		 foreach($result->result() as $row)
		 {
			return $row;
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
	public function edit_question($post_question) {
		$post_QuestionEntity=$post_question['QuestionEntity'];
	//	$post_TopicList=$post_question['TopicList'];
		if($post_question) {
			
			if($post_QuestionEntity['IsActive']==1)
			{
				$IsActive = true;
			} else {
				$IsActive = false;
			}
			$question_data = array(
				"CourseId"=>trim($post_QuestionEntity['CourseId']),
				'QuestionName' => trim($post_QuestionEntity['QuestionName']),
				"IsActive"=>$IsActive,
				"UpdatedBy" => trim($post_QuestionEntity['UpdatedBy']),
				"UpdatedBy" =>date('y-m-d H:i:s')
			
			);
		//	$res = $this->db->insert('tblmstquestion',$Industry_data);
			$this->db->where('QuestionId',$post_QuestionEntity['QuestionId']);
			$res = $this->db->update('tblmstquestion',$question_data);
			$this->db->where('QuestionId',$post_QuestionEntity['QuestionId']);
			$res = $this->db->delete('tblmstquestionoption');
			foreach($post_question['TopicList'] as $topic)
					{
						if($topic['CorrectAnswer']==1)
						{
							$CorrectAnswer = true;
						} else {
							$CorrectAnswer = false;
						}
							$topic_data = array(
								'QuestionId' => $post_QuestionEntity['QuestionId'],
								'OptionValue' => $topic['OptionValue'],
								'CorrectAnswer' => $CorrectAnswer,
								'CreatedBy' => $post_QuestionEntity['CreatedBy'],
								'CreatedOn' => date('y-m-d H:i:s')
								);
								$res = $this->db->insert('tblmstquestionoption',$topic_data);
						
						
						
					}
			if($res) {
				$log_data = array(
					'UserId' => trim($post_QuestionEntity['UpdatedBy']),
					'Module' => 'Question',
					'Activity' =>'update'
	
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
	public function isActiveChange($post_data) {
		try{
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
			$this->db->where('QuestionId',trim($post_data['QuestionId']));
			$res = $this->db->update('tblmstquestion',$data);
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			if($res) {
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}	}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
		
	}
	public function delete_Question($id,$userid) {
		try{
			if($id) {
				
				$this->db->where('QuestionId',$id);
				$res = $this->db->delete('tblmstquestion');
				$this->db->where('QuestionId',$id);
				$res = $this->db->delete('tblmstquestionoption');
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
				if($res) {
					$log_data = array(
						'UserId' => trim($userid),
						'Module' => 'Question',
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
	

}
