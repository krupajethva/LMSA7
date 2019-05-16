<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

class Fileupload extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Fileupload_model');
	}

	
	
	public function getAllCourse() {
		
		$data=$this->Fileupload_model->getlist_course();
		
		echo json_encode($data);
				
	}
		
	public function addFileupload()
	{
		
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_Course) 
			{
				// if($post_Course['CourseId']>0)
				// {
				// 	$result = $this->Course_model->edit_Course($post_Course);
				// 	if($result)
				// 	{
				// 		echo json_encode($post_Course);	
				// 	}	
				// }
				// else
				// {
					$result = $this->Fileupload_model->add_Fileupload($post_Course);
					if($result)
					{
						echo json_encode($post_Course);	
					}	
				//}
					
			}
	}
	public function uploadFile($iCount=null,$vCount=null,$dCount=null)
	{
		if(!empty($iCount))
		{
		if($_FILES){
			for($i=0; $i<$iCount; $i++)
			{
			if(isset($_FILES['Image'.$i]) && !empty($_FILES['Image'.$i]))
			{
				move_uploaded_file($_FILES["Image".$i]["tmp_name"], "../src/assets/Upload/image/".$_FILES["Image".$i]["name"]);
			}
		}
			//echo json_encode($_FILES);
		}
		}
		if(!empty($vCount))
		{
		if($_FILES){
			for($i=0; $i<$vCount; $i++)
			{
			if(isset($_FILES['Video'.$i]) && !empty($_FILES['Video'.$i]))
			{
				move_uploaded_file($_FILES["Video".$i]["tmp_name"], "../src/assets/Upload/video/".$_FILES["Video".$i]["name"]);
			}
		}
			//echo json_encode($_FILES);
		}
		}
	

	if(!empty($dCount))
		{
		if($_FILES){
			for($i=0; $i<$dCount; $i++)
			{
			if(isset($_FILES['Document'.$i]) && !empty($_FILES['Document'.$i]))
			{
				move_uploaded_file($_FILES["Document".$i]["tmp_name"], "../src/assets/Upload/Document/".$_FILES["Document".$i]["name"]);
			}
		}
			//echo json_encode($_FILES);
		}
		}
	
	
	
	echo json_encode($_FILES);
	
	
	
}
}