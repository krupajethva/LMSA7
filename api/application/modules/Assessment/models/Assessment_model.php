<?php

class Assessment_model extends CI_Model
{

	function getby_Assessment($SessionId = NULL)
	{
	try{
		$result=$this->db->query('select cp.CourseId,cp.CourseFullName,csi.CourseSessionId,cp.AssessmentTime,cp.AssessmentTime as AsTotaltime
        FROM tblcoursesession AS csi 
        LEFT JOIN  tblcourse AS cp ON cp.CourseId = csi.CourseId
        WHERE csi.CourseSessionId='.$SessionId);

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		if($result)
		{
			$Course_data= array();
		 $result = json_decode(json_encode($result->result()), True);
		// mysqli_next_result($this->db->conn_id);
		foreach($result as $row)
		{	
			$parsed = explode(":",$row['AssessmentTime']);
			 $row['AssessmentTime']=$parsed[0] * 3600 + $parsed[1] * 60 + $parsed[2];
			$row['user'] = array();
			 $this->db->select('in.UserId,in.FirstName');
			 $this->db->join('tbluser in', 'in.UserId = ins.UserId', 'left');
			 $this->db->where('CourseSessionId',$row['CourseSessionId']);
			 $result1 = $this->db->get('tblcourseinstructor ins');
			 $result1 = json_decode(json_encode($result1->result()), True);
			 foreach($result1 as $row1){
				 //print_r($result1->result());
				array_push($row['user'],$row1['FirstName']);
			 }
			 $data = $row;
		 }
			$InstructorId = implode(", ",$row['user']);
			$row['user'] = $InstructorId;
	
			}
		return $row;
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	public function finalsubmit($ResultId=Null,$userId=NULL,$ttime=NULL,$stime=NULL)
	{
		try {
	  if($ResultId)
	  {
		// $ttime="01:00:00";
		// $stime="00:42:59";
		
		$seconds = strtotime($ttime) - strtotime($stime);
		
		
		 $hours   = floor($seconds  / 3600); 
		 $minutes = floor(($seconds - ($hours * 3600))/60);
		 $seconds = floor(($seconds - ($hours * 3600) - ($minutes*60)));
		$stoptime= $hours.":".$minutes.":".$seconds;
		$result=$this->db->query('SELECT tlt.QuestionId,tlt.ResultId,tlt.OptionId,tlt.OptionId,tmo.CorrectAnswer,trs.TotalAttendQuestion,trs.TotalCorrectAnswer
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		LEFT JOIN tblmstquestionoption AS tmo ON tmo.OptionId=tlt.OptionId
		where trs.LearnerId='.$userId.' AND trs.ResultId='.$ResultId);
		   $k=0;	

					  $subarray = array();		
				   foreach($result->result() as $row1) {
					   if($row1->CorrectAnswer>0)
					   {
                        $k=$k+1;
					   }
					 $tot=((100 * $k) / $row1->TotalAttendQuestion);
				
				   }		
				    $pers=number_format($tot, 2);
				//    echo $k;
				// 	echo $pers;
				 $data = array(
					'TotalCorrectAnswer' => $k,
					"TotalTime"=>$stoptime,
					'Result'=>$pers,
					'UpdatedBy' => $userId,
					'UpdatedOn' => date('y-m-d H:i:s')
				);	
				 $this->db->where('ResultId',$ResultId);
				$this->db->where('LearnerId',$userId);
				$ress = $this->db->update('tblmstresult',$data);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		//$Question_data= array();
		if($ress)
		 {
			return true;
			//$Question_data=$result->result();
		  }else
		  {
			return false;
		  }
	// return $Question_data; 
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
	public function assessment_result($ResultId=Null)
	{
		try {
	  if($ResultId)
	  {

		$result=$this->db->query('SELECT tlt.ResultId,trs.TotalAttendQuestion,trs.TotalTime,trs.Result,trs.UpdatedOn,trs.LearnerId,us.FirstName,us.LastName
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
	    LEFT JOIN tbluser AS us ON us.UserId=trs.LearnerId
		where trs.ResultId='.$ResultId.' GROUP BY tlt.ResultId');

		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($result)
				{
					foreach($result->result() as $row)
					{
					   $Course_data=$row;
				   
					}
					return $Course_data;
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
	public function Certificate_Signature($ResultId=Null)
	{
		try {
	  if($ResultId)
	  {

		$result=$this->db->query('select re.InstructorId as rid,re.FilePath,re.Dataurl,ins.CourseInstructorId,us.UserId,us.SignatureId
		FROM tblmstresult AS rs
				 LEFT JOIN tblcoursesession AS csi ON csi.CourseSessionId=rs.CourseSessionId
                LEFT JOIN  tblcourseinstructor AS ins ON ins.CourseSessionId=rs.CourseSessionId 
                LEFT JOIN  tbluser AS us ON us.UserId=ins.UserId 
                LEFT JOIN  tblresources re ON re.ResourcesId = us.SignatureId 
				WHERE rs.ResultId='.$ResultId.' AND ins.IsPrimary=1');

		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($result)
				{
					foreach($result->result() as $row)
					{
						
					   $Course_data=$row;
				   
					}
					return $Course_data;
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
	public function get_Questiondata($Session=Null,$userId=NULL)
	{
		try {
	  if($Session)
	  {
	
		$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
		from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		where trs.LearnerId='.$userId.' AND trs.CourseSessionId='.$Session.' ORDER BY tlt.SerialNo ASC');
				foreach($result->result() as $row)
				{
				   $res=$this->db->query('SELECT tmo.OptionId,tmo.OptionValue 
				   from tblmstquestionoption as tmo where tmo.QuestionId='.$row->QuestionId);
				   $subarray = array();			
				   foreach($res->result() as $row1) {
					   array_push($subarray,$row1);	
				   }
				   $row->child=$subarray;
				   $Question_data=$row;
				}
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$Question_data= array();
		if($result->result())
		 {

			$Question_data=$result->result();
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
	public function Submit_ans($post_data)
	{
		try {
	  if($post_data)
			{	
				$data = array(
				'OptionId' => $post_data['OptionId'],
				'UpdatedBy' => $post_data['UserId'],
				'UpdatedOn' => date('y-m-d H:i:s')
			);			
		 $this->db->where('ResultId',trim($post_data['ResultId']));
			$this->db->where('QuestionId',trim($post_data['QuestionId']));
			$res = $this->db->update('tbllearnertest',$data);

		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		// $Question_data= array();
	
		if($res)
		 {
			return true;
		
	 	}else{
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
	public function MarkasReview($post_data) {
		try{
		if($post_data) {
			if(trim($post_data['MarkasReview'])==1){
				$MarkasReview = true;
			} else {
				$MarkasReview = false;
			}
			$data = array(
				'MarkasReview' => $MarkasReview,
				'UpdatedBy' => trim($post_data['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s'),
			);			
			$this->db->where('ResultId',trim($post_data['ResultId']));
			$this->db->where('QuestionId',trim($post_data['QuestionId']));
			$res = $this->db->update('tbllearnertest',$data);
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
	function getby_Assessment_result($ResultId = NULL)
	{
	try{
		$result=$this->db->query('select cp.CourseId,cp.CourseFullName,csi.CourseSessionId,bg.badgeletter,re.InstructorId as rid,re.FilePath,re.Dataurl	
		FROM tblmstresult AS rs
				 LEFT JOIN tblcoursesession AS csi ON csi.CourseSessionId=rs.CourseSessionId
				LEFT JOIN  tblcourse AS cp ON cp.CourseId = csi.CourseId
				LEFT JOIN  tblbadges AS bg ON bg.CourseId = csi.CourseId 
				LEFT JOIN  tblresources re ON re.ResourcesId = bg.BadgeImageId 
				WHERE rs.ResultId='.$ResultId);

		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res=array();
		if($result)
		{
			$Course_data= array();
		 $result = json_decode(json_encode($result->result()), True);
		// mysqli_next_result($this->db->conn_id);
		foreach($result as $row)
		{	
			$row['user'] = array();
			 $this->db->select('in.UserId,in.FirstName');
			 $this->db->join('tbluser in', 'in.UserId = ins.UserId', 'left');
			 $this->db->where('CourseSessionId',$row['CourseSessionId']);
			 $result1 = $this->db->get('tblcourseinstructor ins');
			 $result1 = json_decode(json_encode($result1->result()), True);
			 foreach($result1 as $row1){
				 //print_r($result1->result());
				array_push($row['user'],$row1['FirstName']);
			 }
			 $data = $row;
		 }
			//$InstructorId = implode(", ",$row['user']);
			$row['user'] = $row['user'];
	
			}
		return $row;
		}catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
		}	
	}
	
	public function addCertificate($post_data) {
		try{
		if($post_data) {
		
			$data = array(
				'Certificate' => $post_data['Certificate'],
				'UpdatedBy' => trim($post_data['UpdatedBy']),
				'UpdatedOn' => date('y-m-d H:i:s'),
			);		
			$this->db->where('CourseCertificateId','1');
			$res = $this->db->update('tblcoursecertificate',$data);
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
	public function get_CourseCertificat($CertificatId=Null)
	{
		try {
	  if($CertificatId)
	  {

		$result=$this->db->query('SELECT Certificate from tblcoursecertificate 
		  where CourseCertificateId='.$CertificatId);

		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				if($result)
				{
					foreach($result->result() as $row)
					{
					   $Course_data=$row;
				   
					}
					return $Course_data;

					//print_r($Course_data);
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
	public function assessment_check($post_data)
	{
		try {
	  if($post_data)
	  {
		  if($post_data['all']==true)
		  {
			$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
			from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
			LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
			where trs.LearnerId='.$post_data['UserId'].' AND trs.CourseSessionId='.$post_data['CourseSessionId'].' ORDER BY tlt.SerialNo ASC');

		  }else if($post_data['all'] ==false && $post_data['UnAnswred']==true && $post_data['Reviewed'] == false)
		  {
			$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
			from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
			LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
			where trs.LearnerId='.$post_data['UserId'].' AND tlt.OptionId=0 AND trs.CourseSessionId='.$post_data['CourseSessionId'].' ORDER BY tlt.SerialNo ASC');
				
		  }else if($post_data['all'] ==false && $post_data['UnAnswred']==true && $post_data['Reviewed'] == true)
		  {
			$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
			from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
			LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
			where trs.LearnerId='.$post_data['UserId'].' AND trs.CourseSessionId='.$post_data['CourseSessionId'].' AND (tlt.OptionId=0 OR tlt.MarkasReview=1) ORDER BY tlt.SerialNo ASC');

		  }else if($post_data['all'] ==false && $post_data['UnAnswred']==false && $post_data['Reviewed'] == true)
		  {
			$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
			from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
			LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
			where trs.LearnerId='.$post_data['UserId'].' AND trs.CourseSessionId='.$post_data['CourseSessionId'].' AND tlt.MarkasReview=1 ORDER BY tlt.SerialNo ASC');

		  }else
		  {
			$result=$this->db->query('SELECT tlt.SerialNo,tlt.QuestionId,tmq.QuestionName,tlt.ResultId,tlt.OptionId,tlt.MarkasReview,trs.TotalAttendQuestion
			from tblmstresult as trs LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
			LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
			where trs.LearnerId='.$post_data['UserId'].' AND trs.CourseSessionId='.$post_data['CourseSessionId'].' ORDER BY tlt.SerialNo ASC');
		  }
		 
		  foreach($result->result() as $row)
		  {
			  $res=$this->db->query('SELECT tmo.OptionId,tmo.OptionValue 
			  from tblmstquestionoption as tmo where tmo.QuestionId='.$row->QuestionId);
			  $subarray = array();			
			  foreach($res->result() as $row1) {
				  array_push($subarray,$row1);	
			  }
			  $row->child=$subarray;
			  $Question_data=$row;
		  }
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$Question_data= array();
		if($result->result())
		 {

			$Question_data=$result->result();
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
	public function timeoutsubmit($ResultId=Null,$userId=NULL)
	{
		try {
	  if($ResultId)
	  {
		
	
		$result=$this->db->query('SELECT tlt.QuestionId,tlt.ResultId,cp.AssessmentTime,tlt.OptionId,tlt.OptionId,tmo.CorrectAnswer,trs.TotalAttendQuestion,trs.TotalCorrectAnswer
		from tblmstresult as trs 
        LEFT JOIN tbllearnertest AS tlt ON tlt.ResultId=trs.ResultId
		LEFT JOIN tblmstquestion AS tmq ON tmq.QuestionId=tlt.QuestionId
		LEFT JOIN tblmstquestionoption AS tmo ON tmo.OptionId=tlt.OptionId
        LEFT JOIN  tblcoursesession as csi on csi.CourseSessionId=trs.CourseSessionId
        LEFT JOIN tblcourse as cp ON cp.CourseId=csi.CourseId
		where trs.LearnerId='.$userId.' AND trs.ResultId='.$ResultId);
		   		$k=0;	
				$subarray = array();		
				foreach($result->result() as $row1)
				{
					$stoptime=$row1->AssessmentTime;
					   if($row1->CorrectAnswer>0)
					   {
                        $k=$k+1;
					   }
					 $tot=((100 * $k) / $row1->TotalAttendQuestion);
				
				}		
				$pers=number_format($tot, 2);
				 $data = array(
					'TotalCorrectAnswer' => $k,
					"TotalTime"=>$stoptime,
					'Result'=>$pers,
					'UpdatedBy' => $userId,
					'UpdatedOn' => date('y-m-d H:i:s')
				);	
				 $this->db->where('ResultId',$ResultId);
				$this->db->where('LearnerId',$userId);
				$ress = $this->db->update('tblmstresult',$data);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		//$Question_data= array();
		if($ress)
		 {
			return true;
			//$Question_data=$result->result();
		  }else
		  {
			return false;
		  }
	// return $Question_data; 
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
}
