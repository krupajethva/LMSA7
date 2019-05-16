<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

class Course extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Course_model');
	}

	public function getAllCourse()
	{
		$data=$this->Course_model->getlist_Course();
		
		echo json_encode($data);
	}
	public function skillsData()
	{
	// 	$data=[ "Amsterdam",
	// 	"London",
	// 	"Paris",
	// 	"Washington",
	// 	"New York",
	// 	"Los Angeles",
	// 	"Sydney",
	// 	"Melbourne",
	// 	"Canberra",
	// 	"Beijing",
	// 	"New Delhi",
	// 	"Kathmandu",
	// 	"Cairo",
	// 	"Cape Town",
	// 	"Kinshasa"
	//   ];
	$data=$this->Course_model->getAllCourseKey();
 	echo json_encode($data);
	}
	
	public function addCourse()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Course) 
			{// $post_id=$post_Course['course'];
				if($post_Course['CourseId']>0)
				{
					$result = $this->Course_model->edit_Course($post_Course);
					if($result)
					{
						echo json_encode($result);	
					}	
				}
				else
				{
					$result = $this->Course_model->add_Course($post_Course);
					if($result)
					{
						//print_r('success');
					echo json_encode($result);	
					}	
				}
					
			}
	}
	// public function edit_Course()
	// {
		
	// 	$post_Course = json_decode(trim(file_get_contents('php://input')), true);
	// 	if ($post_Course) 
	// 		{ 
	// 			if($post_Course['CourseId']>0)
	// 			{
	// 				$result = $this->Course_model->edit_Course($post_Course);
	// 				if($result)
	// 				{
	// 					echo json_encode('success');	
	// 				}	
	// 			}
				
					
	// 		}
	// }
	public function addtopic()
	{
		
		$post_topic = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_topic) 
			{ 	//$post_id=$post_topic['course'];
				// if($post_id['TopicId']>0)
				// {
					$result = $this->Course_model->add_topic($post_topic);
					if($result)
					{
						//print_r($result);
					  echo json_encode($result);	
					}	
				//}
					
			}
	}
	public function edittopic()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		//$post_Course=$post_Course['course'];
	$post_topic=$post_Course['topic'];
		if ($post_Course) 
			{ 
				
					$result = $this->Course_model->edittopic($post_Course);
					if($result)
					{
						echo json_encode($result);	
					}	
				
			}
	}
	public function getAllParent() {
		
		$data['parent']=$this->Course_model->getlist_parent();
		$data['sub']=$this->Course_model->getlist_SubCategory();

		echo json_encode($data);
				
	}
	public function getSubCategoryList($Category_Id = NULL) {
		
		if(!empty($Category_Id)) {					
			
			$result = [];
			$result = $this->Course_model->getSubCategoryList($Category_Id);			
			echo json_encode($result);				
		}			
	}
	
	public function getById($Course_id=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
	
			//$data['skill']=$this->Course_model->get_skilldata($Course_id);	
			$data=$this->Course_model->get_Coursedata($Course_id);
			//print_r($data);
		echo json_encode($data);
		}
	}
	public function badgegetById($Course_id=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
			if($Course_id)
			{
				$data=$this->Course_model->get_badgedata($Course_id);
				if($data)
				{
					echo json_encode($data);
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
			//$data['skill']=$this->Course_model->get_skilldata($Course_id);	
			
			//print_r($data);
	
		
		}
	}
	public function delete() {
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Course)
		 {
			if($post_Course['id'] > 0){
				$result = $this->Course_model->delete_Course($post_Course);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
		 	}
		
			
		} 
			
	}
	public function deletetopic() {
		$post_topic = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_topic)
		 {
			 //$TopicId=$post_topic['TopicId'];
			if($post_topic['TopicId'] > 0){
				$result = $this->Course_model->delete_topic($post_topic);
				if($result) {
					
					echo json_encode("Delete successfully");
					}
			 }else
			 {
				echo json_encode("Delete successfully");
			 }
		
			
		} 
			
	}
	public function deleteSubTopic() {
		$post_SubTopic = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_SubTopic)
		 {if($post_SubTopic['TopicId'] > 0){
				$result = $this->Course_model->deleteSubTopic($post_SubTopic);
				if($result)
				 {
					echo json_encode("Delete successfully");
				}
			}else
			{
			   echo json_encode("Error");
			}
		} 
			
	}

	// public function getAllParent() {
		
	// 	$data=$this->Category_model->getlist_parent();
		
	// 	echo json_encode($data);
				
	// }
	public function isActiveChange() {
		
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) {
			$result = $this->Course_model->isActiveChange($post_data);
			if($result) {
				echo json_encode('success');	
			}						
		}		
	}


	// public function uploadFileup()
	// {
		
	// 	if($_FILES){
			
	// 		if(isset($_FILES['CourseImage']) && !empty($_FILES['CourseImage'])){
	// 			alert($_FILES['CourseImage']);
	
	// 			move_uploaded_file($_FILES["CourseImage"]["tmp_name"], "../assets/Course/".$_FILES["CourseImage"]["name"]);
	// 		}
			
	// 	}
	// 	echo json_encode('success');
			
	// }


	public function uploadFile($id)
	{
		if($_FILES)
		{
			// $this->db->select('can.CandidateId,job.JobPositionName');
			// $this->db->join('tblmstjobposition job','job.JobPositionId = can.JobPositionId', 'left');
			// $this->db->where('can.CandidateId',$id);
			// $result = $this->db->get('tblcandidate can');	
			// $positionName = $result->result()[0]->JobPositionName;

			if(isset($_FILES['CourseImage']) && !empty($_FILES['CourseImage']))
			{	
				//$dirname=str_replace(' ','_',$id);
				$directoryname="../assets/Instructor/".$id."/";
				$directoryname1= $directoryname."image/";
				if(!is_dir($directoryname1)){
					mkdir($directoryname1, 0755, true);
					}

				$target_dir=$directoryname1;
				$newfilename= str_replace(" ", "_", basename($_FILES["CourseImage"]["name"]));
				$target_file = $target_dir . $newfilename;
				move_uploaded_file($_FILES["CourseImage"]["tmp_name"], $target_file);
				//move_uploaded_file($_FILES["CourseImage"]["tmp_name"], "../assets/Course/".$_FILES["CourseImage"]["name"]);
				
			} 
				//echo json_encode('success');
		
		
		if(isset($_FILES['Video']) && !empty($_FILES['Video']))
		{	
			//$dirname=str_replace(' ','_',$id);
			$directoryname="../assets/Instructor/".$id."/";
			$directoryname1= $directoryname."Video/";
			if(!is_dir($directoryname1)){
				mkdir($directoryname1, 0755, true);
				}

			$target_dir=$directoryname1;
			$newfilename= str_replace(" ", "_", basename($_FILES["Video"]["name"]));
			$target_file = $target_dir . $newfilename;
			move_uploaded_file($_FILES["Video"]["tmp_name"], $target_file);
			//move_uploaded_file($_FILES["CourseImage"]["tmp_name"], "../assets/Course/".$_FILES["CourseImage"]["name"]);
			
		} 
			}//echo json_encode('success');
				// if($_FILES){
		// 	if(isset($_FILES['Video']) && !empty($_FILES['Video'])){
		// 		move_uploaded_file($_FILES["Video"]["tmp_name"], "../assets/Course/".$_FILES["Video"]["name"]);
		// 	}
		// 	//echo json_encode('success');
		// }
		echo json_encode('success');
	}
	public function uploadFile2($vCount=null,$id=null)
	{
		if(!empty($vCount))
		{
			if($_FILES)
			{
				for($i=0; $i<$vCount; $i++)
				{ 
					
					if(isset($_FILES['Video'.$i]) && !empty($_FILES['Video'.$i]))
					{
						$directoryname="../assets/Instructor/".$id."/";
						$directoryname1= $directoryname."Video/";
						if(!is_dir($directoryname1)){
							mkdir($directoryname1, 0755, true);
							}
		
						$target_dir=$directoryname1;
						$newfilename= str_replace(" ", "_", basename($_FILES["Video".$i]["name"]));
						$target_file = $target_dir . $newfilename;
						move_uploaded_file($_FILES["Video".$i]["tmp_name"], $target_file);
						//move_uploaded_file($_FILES["Video".$i]["tmp_name"], "../assets/Course/video/".$_FILES["Video".$i]["name"]);
					}
				}			
				echo json_encode('success');			
			} else {
				echo json_encode('error');
			}

		}
	
	}
	public function badgeuploadFile($id)
	{
		if($_FILES)
		{
			if(isset($_FILES['badgeImage']) && !empty($_FILES['badgeImage']))
			{	
				//$dirname=str_replace(' ','_',$id);
				$directoryname="../assets/Instructor/".$id."/";

				$directoryname="../assets/Instructor/".$id."/";
				$directoryname1= $directoryname."image/";
				if(!is_dir($directoryname1)){
					mkdir($directoryname1, 0755, true);
					}

				$target_dir=$directoryname1;
				$newfilename= str_replace(" ", "_", basename($_FILES["badgeImage"]["name"]));
				$target_file = $target_dir . $newfilename;
				move_uploaded_file($_FILES["badgeImage"]["tmp_name"], $target_file);
				//move_uploaded_file($_FILES["CourseImage"]["tmp_name"], "../assets/Course/".$_FILES["CourseImage"]["name"]);
				
			} 
	
			}
		echo json_encode('success');
	
	}
	public function addClone() {
		$post_Clone = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Clone)
		 {
			if($post_Clone['id'] > 0){
				$result = $this->Course_model->Clone_Course($post_Clone);
				if($result) {
					
					echo json_encode($result);
					}
		 	}
		
			
		} 
			
	}
	public function getByTopicId($Course_id=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
			$data=$this->Course_model->get_Topicdata($Course_id);
			
			echo json_encode($data);
		}
	}
	public function getAllimage($User_id=null)
	{	
		
		if(!empty($User_id))
		{
			$data=[];
			$data['image']=$this->Course_model->get_Allimage($User_id);
			$data['video']=$this->Course_model->get_Allvideo($User_id);
			$data['defalutbadge']=$this->Course_model->get_DefalutBadge();
			echo json_encode($data);
		}
	}
	public function addbadges()
	{
		
		$post_badges = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_badges) 
			{ 
			
					

					if($post_badges['BadgesId']>0)
					{
						$result = $this->Course_model->edit_badges($post_badges);
						if($result)
						{
							echo json_encode($result);	
						}	
					}
					else
					{
						$result = $this->Course_model->add_badges($post_badges);
						if($result)
						{
							echo json_encode('success');	
						}
					}
				
					
			}
	}
	// public function BadgeupLoadFileSelect($data=null,$id=null)
	// {
	// 	if($data)
	// 	{
	// 		if(isset($data) && !empty($data))
	// 		{	
	// 			//$dirname=str_replace(' ','_',$id);
	// 			$src="../assets/Instructor/badges/".$data;

	// 			$dest="../assets/Instructor/".$id."/image/".$data;
	// 			if(!copy($src,$dest))
	// 			{
	// 				echo json_encode('error');
	// 			}
	// 			else
	// 			{
	// 				echo json_encode('success');
	// 			}
				
	// 		} 
	// 		}
		
	
	// }

}