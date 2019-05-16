<?php

class Course_model extends CI_Model
{
			
	public function add_Course($post_Course)
	{	//$post_Course=$aa['course'];
		//$post_topic=$aa['topic'];
		try{
		if($post_Course)
		{
			
		if($post_Course['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
					if($post_Course['Featurescheck']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}

					if(isset($post_Course['Keyword']) && !empty($post_Course['Keyword']))
					{
						$Keyword = $post_Course['Keyword'];
					}
					else{
						$Keyword = Null;
					}
				if(isset($post_Course['ResourcesId1']) && !empty($post_Course['ResourcesId1']))
				{
					$id1=$post_Course['ResourcesId1'];
				}
				else
				{
					$image_data = array(
						'InstructorId' => $post_Course['CreatedBy'],
						'FilePath' => $post_Course['CourseImage'],
						'Dataurl' => $post_Course['Dataurl'],
						'Keyword' => "CourseImage",
						'IsActive'=>1,
						'CreatedBy' => $post_Course['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
							);
						$res1=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
						 $out_param_query = $this->db->query('select @id as out_param;');
						$id1=$out_param_query->result()[0]->out_param;

				}
				if(isset($post_Course['ResourcesId2']) && !empty($post_Course['ResourcesId2']))
				{
					$id2=$post_Course['ResourcesId2'];
				}
				else
				{
					$Video_data = array(
						'InstructorId' => $post_Course['CreatedBy'],
						'FilePath' => $post_Course['CourseVideo'],
						'Dataurl' => $post_Course['Dataurl'],
						'Keyword' => "CourseVideo",
						'IsActive'=>1,
						'CreatedBy' => $post_Course['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
						);
						$res2=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$Video_data);
						 $out_param_query = $this->db->query('select @id as out_param;');
						$id2=$out_param_query->result()[0]->out_param;

				}

				

			$Course_data = array(
				'CategoryId' => $post_Course['CategoryId'],
				'CourseFullName' => $post_Course['CourseFullName'],
				'Price' => $post_Course['Price'],
				'NoOfQuestion'=>$post_Course['NoOfQuestion'],
				'AssessmentTime'=>$post_Course['AssessmentTime'],
				'Description' => $post_Course['Description'],
				 'CourseImageId' => $id1,
				 'CourseVideoId' => $id2,
				'Keyword' =>  $Keyword,
				'EmailBody' =>$post_Course['EmailBody'],
				'EmailBody2' =>$post_Course['EmailBody2'],
				'EmailBody3' =>$post_Course['EmailBody3'],
				'EmailBody4' =>$post_Course['EmailBody4'],
				'Requirement' =>$post_Course['Requirement'],
				'Featurescheck'=>$post_Course['Featurescheck'],
				'whatgetcheck'=>$post_Course['whatgetcheck'],
				'Targetcheck'=>$post_Course['Targetcheck'],
				'Requirementcheck'=>$post_Course['Requirementcheck'],
				'Morecheck'=>$post_Course['Morecheck'],
				'PublishIsStatus' =>$post_Course['PublishIsStatus'],
				'IsActive' => $IsActive,
				'CreatedBy' => $post_Course['CreatedBy'],
				'CreatedOn' => date('y-m-d H:i:s')
			);
			$res=$this->db->query('call addCourse(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@id)',$Course_data);
			 $out_param_query = $this->db->query('select @id as out_param;');
			$id=$out_param_query->result()[0]->out_param;
			// if(isset($post_Course['InstructorId']) && !empty($post_Course['InstructorId']))
			// 		{
			// 			$array = array();
			// 			foreach($post_Course['InstructorId'] as $key=>$value){
			// 				array_push($array,$value);
			// 			}
			// 			$InstructorId = implode(",",$array);
			// 		}
			// 		else{
			// 			$InstructorId = Null;
			// 		}

			// foreach($post_Course['InstructorId'] as $Instructor) {
			// 	$Instructor_data = array(
			// 		'CourseId'=>$id,
			// 		'UserId'=>$Instructor,
			// 		'CreatedBy' => $post_Course['CreatedBy'],
			// 		'CreatedOn' => date('y-m-d H:i:s')
					
			// 	);
			// 	$insert = $this->db->insert('tblCourseInstructor',$Instructor_data);
			// 	}
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Course['CreatedBy']),
						'Module' => 'Course',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					return $id;
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
	public function add_topic($aa)
	{	$post_Course=$aa['course'];
		$post_topic=$aa['topic'];
		try{
		if($post_topic)
		{
			$temp_topic = array();
			//$i = 0;
			$CourseId=$post_Course['CourseId'];
			foreach($post_topic as $topic) {
				$topic_data = array(
					'CourseId'=>$CourseId,
					'TopicName' => $topic['TopicName']
				
					
				);
				$res=$this->db->query('call addtopic(?,?,@id)',$topic_data);
				 $out_param_query1 = $this->db->query('select @id as out_param;');
				$TopicId=$out_param_query1->result()[0]->out_param;
				$row = $topic;
				$row['TopicId'] = $TopicId;
						//$temp_topic[i]->TopicId = $TopicId;
						//$j = 0;

						$subarray = array();
					foreach($topic['subtopic'] as $subtopic)
					{
						
							//	$SubTopicDescription=$topic['hh'].":".$topic['mm'].":".$topic['ss'];
							$SubTopicTime="".$subtopic['hh'].":".$subtopic['mm'].":00";
						 		if(isset($subtopic['ResourcesId3']) && !empty($subtopic['ResourcesId3']))
									{
										$id2=$subtopic['ResourcesId3'];
									}
									else
									{
										if(isset($subtopic['Video']) && !empty($subtopic['Video']))
										{
											$Video_data = array(
												'InstructorId' => $post_Course['CreatedBy'],
												'FilePath' => $subtopic['Video'],
												'Dataurl' => null,
												'Keyword' => "topicVideo",
												'IsActive'=>1,
												'CreatedBy' => $post_Course['CreatedBy'],
												'CreatedOn' => date('y-m-d H:i:s')
												);
												$res2=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$Video_data);
												$out_param_query = $this->db->query('select @id as out_param;');
												$id2=$out_param_query->result()[0]->out_param;
										}else
										{
											$id2=null;
										}
									

									}
							$Fileupload_data = array(
								'ParentId' => $TopicId,
								'TopicName' =>  $subtopic['SubTopicName'],
								'TopicTime' =>  $SubTopicTime,
								'TopicDescription' =>$subtopic['SubTopicDescription'],
								'Video'=>$id2
							);
							$res=$this->db->query('call addSubtopic(?,?,?,?,?,@id)',$Fileupload_data);
							$out_param_query = $this->db->query('select @id as out_param;');
							$subTopicId=$out_param_query->result()[0]->out_param;
							//$temp_topic['subtopic'][j]->TopicId = $subTopicId;
							//$j++;
							$subrow = $subtopic;
							$subrow['TopicId'] = $subTopicId;
							$subrow['ParentId'] = $TopicId;
							array_push($subarray,$subrow);
					}
					//$i++;
					$row['subtopic'] = $subarray;	
					array_push($temp_topic,$row);
				}
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{	
					$log_data = array(
						'UserId' => trim($post_Course['CreatedBy']),
						'Module' => 'topic',
						'Activity' =>'Add'
		
					);
					$log = $this->db->insert('tblactivitylog',$log_data);
					$return_data['Courselist'] = $temp_topic;
					$return_data['CourseId'] = $CourseId;
					return $return_data;
				}
				else
				{
					return false;
				}
		}
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	
	public function getSubCategoryList($Category_Id = NULL) {
		
		if($Category_Id) {
			
			$this->db->select('CategoryId,ParentId,CategoryName');
			$this->db->where('ParentId',$Category_Id);
			$this->db->order_by('CategoryName','asc');
			$this->db->where('IsActive=',1);
			$result = $this->db->get('tblmstcategory');
			
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
			
		} else {
			return false;
		}
	}
	public function getAllCourseKey() {
		try{
		// $this->db->select('*');
		$this->db->select('Description');
		$this->db->where('Key','CourseKeyword');
		$result = $this->db->get('tblmstconfiguration');
		//$result = $this->db->query('call getCountryList()');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		foreach($result->result() as $row) {
			$res = $row->Description;
			$res = explode(",", $res);
		}
		return $res;
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

		//  $this->db->select('cp.CourseId,cp.CategoryId,cp.CourseFullName,cp.CourseShortName,cp.CourseCode,cp.Price,cp.Duration,cp.ShowTo,cp.CourseImage as Favicon,cp.Description,cp.IsActive,
		//  in.StartDate,in.EndDate,in.Time,in.CountryId,in.StateId,in.Location,in.TotalSeats');
		// // $this->db->order_by('cp.Name','asc');
		// //$this->db->join('tblmstcategory ca', 'ca.CategoryId = cp.CategoryId', 'left');
		// $this->db->join('tblsessionschedule in', 'in.CourseId = cp.CourseId', 'left');
		//  $this->db->where('cp.CourseId',$Course_id);
		//  $result=$this->db->get('tblcourse cp');
		$result=$this->db->query('call getCourseById(?)',$Course_id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
	//   $Course_data= array();
	
		//  $result = json_decode(json_encode($result->result()), True);
		//  mysqli_next_result($this->db->conn_id);
		// foreach($result as $row){	
		
		// 	$row['selectedCharacters'] = array();
		// 	 $this->db->select('UserId');
		// 	 $this->db->where('CourseId',$row['CourseId']);
		// 	 $result1 = $this->db->get('tblcourseinstructor');
		// 	 $result1 = json_decode(json_encode($result1->result()), True);
		// 	 foreach($result1 as $row1){
		// 		 //print_r($result1->result());
		// 		array_push($row['selectedCharacters'],$row1['UserId']);
		// 	 }
		//  }
		
	// 	 $InstructorId = implode(",",$Course_data);
	// 	 $Instructor = explode(",",$InstructorId);
		foreach($result->result() as $row)
		 {
			$Course_data=$row;
		
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
	// public function get_skilldata($Course_id=Null)
	// {
	// 	try {
	//   if($Course_id)
	//   {
	// 	  	$Skill =$this->db->query("SELECT keyword FROM tblcourse WHERE CourseId=".$Course_id);
	// 		  $Course = $Skill->result();
	// 	    $aKeyword = explode(",", $Course[0]->keyword);
    //  	    $query ="SELECT CourseId,Keyword FROM tblcourse WHERE (CourseId!=".$Course_id." AND PublishStatus=1 AND IsActive=1) AND (Keyword like '%" . $aKeyword[0] . "%'";
	// 		 for($i = 1; $i < count($aKeyword); $i++) 
	// 		 {
	// 			if(!empty($aKeyword[$i]))
	// 		    {
    //        			 $query .= " OR Keyword like '%" . $aKeyword[$i] . "%')";
    //     		} else {
	// 				$query .= " )";
	// 			}
	// 		  }
	// 		  if(count($aKeyword)==1){
	// 			$query .= " )";
	// 		  }
	// 		  //$query .= " AND PublishStatus=1 AND IsActive=1";
	// 		  $result = $this->db->query($query);
		
	// 	 $db_error = $this->db->error();
	// 			if (!empty($db_error) && !empty($db_error['code'])) { 
	// 				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
	// 				return false; // unreachable return statement !!!
	// 			}
	
	// 			$Course_data= array();
	// 		if($result->result()) {
	// 			$Course_data = $result->result();
	// 		}
	// 		// return $Course_data;
	// 	//  foreach($result->result() as $row)
	// 	//  {
	// 	// 	$Course_data=$row;
			
	// 	//  }
	// 	 return $Course_data;
		 
	//   }else
	//   	{
	// 		  return false;
	//   	}
	//   }
	//   catch(Exception $e){
	// 	trigger_error($e->getMessage(), E_USER_ERROR);
	// 	return false;
	// 	}	
	// }
	
	 public function edit_Course($post_Course)
	 {
		 //$post_Course=$aa['course'];
	// 	$post_topic=$aa['topic'];
		try
		{
		if($post_Course) 
		{
					if($post_Course['IsActive']==1)
					{
						$IsActive = true;
					} else {
						$IsActive = false;
					}
							if(isset($post_Course['ResourcesId1']) && !empty($post_Course['ResourcesId1']))
							{
								$id1=$post_Course['ResourcesId1'];
							}
							else
							{ if($post_Course['CourseImage']==null)
								{
									$id1=$post_Course['CourseImage']=null;
								}else
								{
									$image_data = array(
										'InstructorId' => $post_Course['UpdatedBy'],
										'FilePath' => $post_Course['CourseImage'],
										'Dataurl' => $post_Course['Dataurl'],
										'Keyword' => "CourseImage",
										'IsActive'=>1,
										'CreatedBy' => $post_Course['UpdatedBy'],
										'CreatedOn' => date('y-m-d H:i:s')
											);
										$res1=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
										$out_param_query = $this->db->query('select @id as out_param;');
										$id1=$out_param_query->result()[0]->out_param;
								}

							}
							if(isset($post_Course['ResourcesId2']) && !empty($post_Course['ResourcesId2']))
							{
								$id2=$post_Course['ResourcesId2'];
							}
							else
							{
								if($post_Course['CourseVideo']==null)
								{
									$id2=$post_Course['CourseVideo']=null;
								}else
								{
								$Video_data = array(
									'InstructorId' => $post_Course['UpdatedBy'],
									'FilePath' => $post_Course['CourseVideo'],
									'Dataurl' => $post_Course['Dataurl'],
									'Keyword' => "CourseVideo",
									'IsActive'=>1,
									'CreatedBy' => $post_Course['UpdatedBy'],
									'CreatedOn' => date('y-m-d H:i:s')
									);
									$res2=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$Video_data);
									 $out_param_query = $this->db->query('select @id as out_param;');
									$id2=$out_param_query->result()[0]->out_param;
								}
			
							}

					if(isset($post_Course['Keyword']) && !empty($post_Course['Keyword']))
					{
						$Keyword = $post_Course['Keyword'];
					}
					else{
						$Keyword = Null;
					}
					
				$Course_data = array(
				'CategoryId' => $post_Course['CategoryId'],
				'CourseFullName' => $post_Course['CourseFullName'],
				'Price' => $post_Course['Price'],
				'NoOfQuestion'=> $post_Course['NoOfQuestion'],
				'AssessmentTime'=>$post_Course['AssessmentTime'],
				'Description' => $post_Course['Description'],
				'CourseImageId' => $id1,
				'CourseVideoId' => $id2,
				'Keyword' =>  $Keyword,
				'EmailBody' =>$post_Course['EmailBody'],
				'EmailBody2' =>$post_Course['EmailBody2'],
				'EmailBody3' =>$post_Course['EmailBody3'],
				'EmailBody4' =>$post_Course['EmailBody4'],
				'Requirement' =>$post_Course['Requirement'],
				'Featurescheck'=>$post_Course['Featurescheck'],
				'whatgetcheck'=>$post_Course['whatgetcheck'],
				'Targetcheck'=>$post_Course['Targetcheck'],
				'Requirementcheck'=>$post_Course['Requirementcheck'],
				'Morecheck'=>$post_Course['Morecheck'],
				'IsActive' => $IsActive,
				'UpdatedBy' => $post_Course['UpdatedBy'],
				'UpdatedOn' => date('y-m-d H:i:s'),
				'CourseId' => $post_Course['CourseId']
				
				);
			$res=$this->db->query('call updateCourse(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$Course_data);

			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			 if($res) 
			{	
			      $log_data = array(
					'UserId' =>trim($post_Course['UpdatedBy']),
					'Module' => 'Course',
				 	'Activity' =>'Update'
	
				    );
			      $log = $this->db->insert('tblactivitylog',$log_data);
				return $post_Course['CourseId'];
				}
			} else
				{
				 return false;
			    }
			
		}catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}		
	
	}
	public function get_Topicdata($Course_id=Null)
	{
		try {
	  if($Course_id)
	  {
		$result=$this->db->query('call getByTopicId(?)',$Course_id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		 $Course_data= array();
		 foreach($result->result() as $row)
		 {
			mysqli_next_result($this->db->conn_id);
			$res=$this->db->query('call getBySubtopicid(?)',$row->TopicId);
			// if($res->result()){
			// 	$row->subtopic = $res->result();
	
	
			// }
			$subarray = array();			
			foreach($res->result() as $row1) {
				$res = $row1->SubTopicTime;
				$res = explode(":", $res);
				$row1->hh = $res[0];
				$row1->mm = $res[1];
				$row1->ss = $res[2];
				array_push($subarray,$row1);
				
			}
			$row->subtopic=$subarray;
			array_push($Course_data,$row);
			
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
	
	function getlist_Course()
	{
	try{
	// 	$this->db->select('cp.CourseId,cp.CourseFullName,cp.CategoryId,cp.CourseShortName,cp.CourseCode,cp.Price,cp.Duration,cp.ShowTo,cp.CourseImage as Favicon,cp.Description,cp.IsActive,in.CategoryName as parentName');
	//  $this->db->join('tblmstcategory in', 'in.CategoryId = cp.CategoryId', 'left');
	// 	$result = $this->db->get('tblcourse cp');
	$result=$this->db->query('call getCourse()');
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

	function getlist_parent()
	{
	try
	 {
		$this->db->select('CategoryId,CategoryName,ParentId');
		$this->db->where('ParentId="0"');
		$result = $this->db->get('tblmstcategory');
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
	
	
	
	function getlist_SubCategory()
	{
	try
	 {
		$this->db->select('CategoryId,CategoryName');
		$this->db->where('ParentId!="0"');
		$result = $this->db->get('tblmstcategory');
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
			$this->db->where('CourseId',$post_Course['id']);
			$ress = $this->db->delete('tblcoursetopic');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				// $log_data = array(
				// 	'UserId' =>trim($post_Course['Userid']),
				// 	'Module' => 'Category',
				// 	'Activity' =>'Delete'
	
				// );
				// $log = $this->db->insert('tblactivitylog',$log_data);
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
	public function delete_topic($post_topic) 
	{
	 try{
		// $TopicId=$post_topic['TopicId'];
		if($post_topic) 
		{
		
			 $this->db->where('TopicId',$post_topic['TopicId']);
			$ress = $this->db->delete('tblcoursetopic');

			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($ress) {
				// $log_data = array(
				// 	'UserId' =>trim($post_Course['Userid']),
				// 	'Module' => 'Category',
				// 	'Activity' =>'Delete'
	
				// );
				// $log = $this->db->insert('tblactivitylog',$log_data);
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
				$this->db->where('CourseId',trim($post_data['CourseId']));
				$res = $this->db->update('tblcourse',$data);
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
		
		public function Clone_Course($postClone)
		{	$post_Clone=$postClone['Name'];
			try{
			if($post_Clone)
			{
			
				$Clone_data = array(
					'CategoryId' => $post_Clone['CategoryId'],
					'CourseFullName' => $post_Clone['CourseFullName'],
					'CourseShortName' => $post_Clone['CourseShortName'],
					'NoOfQuestion'=>$post_Course['NoOfQuestion'],
					'Price' => $post_Clone['Price'],
					'CourseCode' => $post_Clone['CourseCode'],
					'Description' => $post_Clone['Description'],
					'Duration' => $post_Clone['Duration'],
					'ShowTo' => $post_Clone['ShowTo'],
					'CourseImage' => $post_Clone['CourseImage'],
					//'IsActive' => $IsActive,
				//	'CreatedBy' => $post_Clone['CreatedBy'],
					'CreatedOn' => date('y-m-d H:i:s')
				);
					$res=$this->db->insert('tblcourse',$Clone_data);
					 $course_id = $this->db->insert_id();
				
			
				$Sessionschedule_data = array(
					'CourseId' => trim($course_id),
					//'UserId' =>  trim($post_Course['UserId']),
					'CreatedOn' => date('y-m-d H:i:s')
				);
				$res = $this->db->insert('tblsessionschedule',$Sessionschedule_data);
				
				
					$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}	
					if($res)
					{	
						return $course_id;;
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
	
	

public function edittopic($aa)
{
	$post_Course=$aa['course'];
	$post_topic=$aa['topic'];
   try
   {
   if($aa) 
   {	
		  $CourseId=$post_Course['CourseId'];
		  foreach($post_topic as $topic) {
			  if(isset( $topic['TopicId']) && $topic['TopicId']>0 )
			  {
					$topic_data = array(
						'TopicId'=>$topic['TopicId'],
						'TopicName' => $topic['TopicName']
					
						
					);
					$res=$this->db->query('call updatetopic(?,?)',$topic_data);
					$TopicId=$topic['TopicId'];
			  }else
			  {
					$topic_data = array(
					'CourseId'=>$CourseId,
					'TopicName' => $topic['TopicName']	
					);
					$res=$this->db->query('call addtopic(?,?,@id)',$topic_data);
					$out_param_query1 = $this->db->query('select @id as out_param;');
					$TopicId=$out_param_query1->result()[0]->out_param;
				
			  }
			   foreach($topic['subtopic'] as $row){
					$SubTopicTime="".$row['hh'].":".$row['mm'].":00";
					if(isset($row['TopicId']) && $row['TopicId']>0 )
					{
						if(isset($row['ResourcesId3']) && !empty($row['ResourcesId3']))
							{
								$id2=$row['ResourcesId3'];
							}
							else
							{
								if(isset($row['Video']) && !empty($row['Video']))
								{
									$Video_data = array(
										'InstructorId' => $post_Course['UpdatedBy'],
										'FilePath' => $row['Video'],
										'Dataurl' => null,
										'Keyword' => "topicVideo",
										'IsActive'=>1,
										'CreatedBy' => $post_Course['UpdatedBy'],
										'CreatedOn' => date('y-m-d H:i:s')
										);
										$res2=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$Video_data);
										 $out_param_query = $this->db->query('select @id as out_param;');
										$id2=$out_param_query->result()[0]->out_param;
								}else
								{
									$id2=null;
									 
								}
			
							}
						$Fileupload_data = array(
							'TopicId' => $row['TopicId'],
							'ParentId' => $row['ParentId'],
							'TopicName' =>  $row['SubTopicName'],
							'TopicTime' =>  $SubTopicTime,
							'TopicDescription' =>$row['SubTopicDescription'],
							'Video' =>$id2
					
						);
						$res=$this->db->query('call updatesubtopic(?,?,?,?,?,?)',$Fileupload_data);
						
					}else
					{
						$SubTopicTime="".$row['hh'].":".$row['mm'].":00";
						if(isset($row['ResourcesId3']) && !empty($row['ResourcesId3']))
						   {
							   $id2=$row['ResourcesId3'];
						   }
						   else
						   {
							   if(isset($row['Video']) && !empty($row['Video']))
							   {
								   $Video_data = array(
									   'InstructorId' => $post_Course['CreatedBy'],
									   'FilePath' => $row['Video'],
									   'Dataurl' => null,
									   'Keyword' => "topicVideo",
									   'IsActive'=>1,
									   'CreatedBy' => $post_Course['CreatedBy'],
									   'CreatedOn' => date('y-m-d H:i:s')
									   );
									   $res2=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$Video_data);
									   $out_param_query = $this->db->query('select @id as out_param;');
									   $id2=$out_param_query->result()[0]->out_param;
							   }else
							   {
								   $id2=null;
							   }
						   

						   }
						$Fileupload_data = array(
							'ParentId' => $TopicId,
							'TopicName' =>  $row['SubTopicName'],
							'TopicTime' =>  $SubTopicTime,
							'TopicDescription' =>$row['SubTopicDescription'],
							'Video'=>$id2
						);
						$res=$this->db->query('call addSubtopic(?,?,?,?,?,@id)',$Fileupload_data);
						$out_param_query = $this->db->query('select @id as out_param;');
					}
					
				  }	
			  }
	   $db_error = $this->db->error();
	   if (!empty($db_error) && !empty($db_error['code'])) { 
		   throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
		   return false; // unreachable return statement !!!
	   }
	   if($res)
	   {	
	
		   return $post_Course['CourseId'];;
	   }
	   else
	   {
		   return false;
	   }
	} 
   }catch(Exception $e){
	   trigger_error($e->getMessage(), E_USER_ERROR);
	   return false;
   }
   		

}

public function get_Allimage($User_id=Null)
{
	try {
  if($User_id)
  {
		 $this->db->select('cp.ResourcesId,cp.InstructorId as fid,cp.FilePath,cp.Keyword');
		$this->db->where('cp.Keyword','CourseImage');
		 $this->db->where('cp.InstructorId',$User_id);
		 $result=$this->db->get('tblresources cp');
	
	 $db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$Course_data = array();
			if($result->result()) {
				$Course_data = $result->result();
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
public function get_Allvideo($User_id=Null)
{
	try {
  if($User_id)
  {
		 $this->db->select('cp.ResourcesId,cp.InstructorId as fid,cp.FilePath,cp.Keyword');
		$this->db->where('cp.Keyword!=','CourseImage');
		 $this->db->where('cp.InstructorId',$User_id);
		 $result=$this->db->get('tblresources cp');
	
	 $db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$Course_data = array();
			if($result->result()) {
				$Course_data = $result->result();
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
public function get_DefalutBadge()
{
	try {
		$result= $this->db->query('select cp.ResourcesId,cp.InstructorId as fid,cp.FilePath,cp.Keyword,cp.Dataurl
		 FROM tblresources as cp WHERE cp.Keyword="DefalutBadges" AND cp.IsActive=1');
	
	 $db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}
			$Course_data = array();
			if($result->result()) {
				$Course_data = $result->result();
			}
		return $Course_data;

	 
  
  }
  catch(Exception $e){
	trigger_error($e->getMessage(), E_USER_ERROR);
	return false;
	}	
}
public function deleteSubTopic($post_SubTopic) 
	{//$post_SubTopic=$post_Sub['TopicId'];
		//$post_UserId=$post_Sub['UserId'];
	 try{
		if($post_SubTopic) 
		{
			
	
			$this->db->where('TopicId',$post_SubTopic['TopicId']);
			$res = $this->db->delete('tblcoursetopic');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				// $log_data = array(
				// 	'UserId' =>trim($post_UserId['UserId']),
				// 	'Module' => 'Course Sub Topic',
				// 	'Activity' =>'Delete'
	
				// );
				// $log = $this->db->insert('tblactivitylog',$log_data);
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
	
	public function add_badges($post_badges)
	{	
		if($post_badges)
		{
			if(isset($post_badges['ResourcesId']) && !empty($post_badges['ResourcesId']))
					{
						$id1=$post_badges['ResourcesId'];
					}
					else
					{
						$image_data = array(
							'InstructorId' => $post_badges['CreatedBy'],
							'FilePath' => $post_badges['badgeImage'],
							'Dataurl' =>$post_badges['Dataurl'],
							'Keyword' => "CourseImage",
							'IsActive'=>1,
							'CreatedBy' => $post_badges['CreatedBy'],
							'CreatedOn' => date('y-m-d H:i:s')
								);
							$res1=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
							 $out_param_query = $this->db->query('select @id as out_param;');
							$id1=$out_param_query->result()[0]->out_param;
	
					}
					$badges_data=array(
						'badgeletter'=>$post_badges['badgeletter'],
						'CourseId'=>$post_badges['CourseId'],
						'BadgeImageId' => $id1,
						'CreatedBy' => $post_badges['CreatedBy'],
						'CreatedOn' => date('y-m-d H:i:s')
					);	
						$res=$this->db->insert('tblbadges',$badges_data);			
										if($res){
											return true;
											//return $id;
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
	public function get_badgedata($Course_id=Null)
	{
		try {
	  if($Course_id)
	  {

		$result=$this->db->query('SELECT bg.BadgesId,bg.CourseId,bg.badgeletter,bg.BadgeImageId,
		res.FilePath as badgeImage,res.InstructorId as rid
		from tblbadges as bg 
		LEFT JOIN tblresources as res ON res.ResourcesId = bg.BadgeImageId
		where bg.CourseId='.$Course_id);
		 $db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
				$badge_data = array();
		foreach($result->result() as $row)
		 {
			$badge_data=$row;
		
	 	}
		 return $badge_data;
		 
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
	public function edit_badges($post_badges)
	{	
		if($post_badges)
		{
			if(isset($post_badges['ResourcesId']) && !empty($post_badges['ResourcesId']))
					{
						$id1=$post_badges['ResourcesId'];
					}
					else
					{ 
						if($post_badges['BadgeImageId']>0)
						{
							$id1=$post_badges['BadgeImageId'];
						}
						else
						{
							$image_data = array(
								'InstructorId' => $post_badges['UpdatedBy'],
								'FilePath' => $post_badges['badgeImage'],
								'Dataurl' =>$post_badges['Dataurl'],
								'Keyword' => "CourseImage",
								'IsActive'=>1,
								'UpdatedBy' => $post_badges['UpdatedBy'],
								'UpdatedOn' => date('y-m-d H:i:s')
									);
								$res1=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
								 $out_param_query = $this->db->query('select @id as out_param;');
								$id1=$out_param_query->result()[0]->out_param;

						}	
						
	
					}
					$badges_data=array(
						'badgeletter'=>$post_badges['badgeletter'],
						'BadgeImageId' => $id1,
						'UpdatedBy' => $post_badges['UpdatedBy'],
						'UpdatedOn' => date('y-m-d H:i:s')
					);	
						$this->db->where('CourseId',$post_badges['CourseId']);
						$res=$this->db->update('tblbadges',$badges_data);			
										if($res){
											return true;
											//return $id;
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
