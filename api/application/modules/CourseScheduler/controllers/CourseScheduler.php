<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");
use \Firebase\JWT\JWT;
class CourseScheduler extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CourseScheduler_model');
		include APPPATH . 'vendor/firebase/php-jwt/src/JWT.php';
	}
	// demo function
public function abc()
{   $new_data=  array("484", "501","297");
	$this->db->select('UserId');
	$this->db->where('CourseSessionId',3);
	$old= $this->db->get('tblcourseinstructor');
	$Old_Result=$old->result();
	$old_data = array();
	foreach($Old_Result as $row)
	{
		array_push($old_data, $row->UserId);
	}
	$old_data1 = $old_data;
   $array_delete=array();
   $array_new=array();
	// $this->db->where('CourseSessionId',$post_Session['CourseSessionId']);
	// 	$ress = $this->db->delete('tblcourseinstructor');
		foreach($new_data as $row)
		{
			if (in_array($row, $old_data))
			{ 
				//$key = array_search($row,$old_data);
				//$array_delete = array_diff($old_data, [$key]);
				array_splice($old_data, array_search($row, $old_data ), 1);
		
			}
		  else
			{
				$Courseinstructo_data = array(
					'CourseSessionId' =>3,
					'UserId' =>  $row,
					'IsPrimary'=>0,
					'Approval'=>0,
					'CreatedBy' =>484

				);
				$ress=$this->db->query('call addcourseinstructor(?,?,?,?,?)',$Courseinstructo_data);
			array_push($array_new,$row);
			}
		}
		if(count($old_data)>0){
			$this->db->where_in('UserId',$old_data);
			$this->db->where('CourseSessionId',3);
			$res_delete = $this->db->delete('tblcourseinstructor');
			$fatch=implode(",",$old_data);
			$user=$this->db->query('SELECT  GROUP_CONCAT(CONCAT(FirstName," ",LastName) SEPARATOR ",") as deletename
			FROM tbluser WHERE UserId IN ('.$fatch.')');
	
			$user_Result=$user->result();
			$deleteName= $user_Result[0]->deletename;
			echo $deleteName;
		}else
		{
			echo "error";
		}
		$array_match=array();
			foreach($old_data1 as $row)
			{
				if (in_array($row, $old_data))
				{
				//echo $row;
				}
			  else
				{
			
				array_push($array_match,$row);
				}
			}
		print_r($new_data);
		print_r($old_data1);
		print_r($old_data);
		print_r($array_new);
		print_r($array_match);

}
	// add or edit scheduler
public function addScheduler()
{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		$pCourse=$post_Course['course'];
		$CourseId=$pCourse['CourseId'];
		$post_Courseschedular=$post_Course['schedularList'];
		if ($post_Course) 
			{ 
				$result = $this->CourseScheduler_model->add_CourseScheduler($post_Course);
				if($result)
				{
						echo json_encode($result);
				}
	   			else
	   			{
                 echo json_encode('null');
	  			 }
			}
}
	public function getAllDefaultData()
	{

		$data['country']=$this->CourseScheduler_model->getlist_country();
	$data['state']=$this->CourseScheduler_model->getlist_state();
		$data['instructor']=$this->CourseScheduler_model->getlist_instructor();
		$data['instructor1']=$data['instructor'];
		echo json_encode($data);
	}
	public function getStateList($country_id = NULL) {
		
		if(!empty($country_id)) {
			
			$result = [];
			$result = $this->CourseScheduler_model->getStateList($country_id);			
			echo json_encode($result);				
		}			
	}
	public function getById($Course_id=null,$userid=null)
	{	
		
		if(!empty($Course_id))
		{
			$data=[];
	
			//$data['skill']=$this->Course_model->get_skilldata($Course_id);	
			$data['coursesession']=$this->CourseScheduler_model->get_Coursesession($Course_id,$userid);
			mysqli_next_result($this->db->conn_id);
			$data['coursename']=$this->CourseScheduler_model->get_Coursename($Course_id);
		//  print_r($data);
		echo json_encode($data);
		}
	}
	public function deleteScheduler() {
		$post_Scheduler = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_Scheduler)
		 {
				$result = $this->CourseScheduler_model->delete_Scheduler($post_Scheduler);
				if($result)
				 {
					echo json_encode("Delete successfully");
				}
		} 
			
	}
	public function addClone() {
		$post_Clone = json_decode(trim(file_get_contents('php://input')), true);		
		$Courseschedular=$post_Clone['schedularList'];
		if ($post_Clone)
		 {
			if($Courseschedular['CourseSessionId'] > 0){
				$result = $this->CourseScheduler_model->Clone_Course($post_Clone);
				if($result) {
					
					echo json_encode($result);
					}
		 	}
		
			
		} 
			
	}
}