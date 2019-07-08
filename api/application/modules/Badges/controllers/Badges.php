<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

class Badges extends CI_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Badges_model');
	}
	public function getAllBadges()
	{
		$data=$this->Badges_model->getlist_Badges();
		
		echo json_encode($data);
	}
	public function addbadges()
	{
		$post_badges = json_decode(trim(file_get_contents('php://input')), true);
		if ($post_badges) 
			{ 
					if($post_badges['ResourcesId']>0)
					{
						$result = $this->Badges_model->edit_badges($post_badges);
						if($result)
						{
							echo json_encode($result);	
						}	
					}
					else
					{
						$result = $this->Badges_model->add_badges($post_badges);
						if($result)
						{
							echo json_encode('success');	
						}
					}		
			}
	}
	public function badgegetById($Course_id=null)
	{	
		if(!empty($Course_id))
		{
			$data=[];
			if($Course_id)
			{
				$data=$this->Badges_model->get_badgedata($Course_id);
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
		}
	}
	public function delete() 
	{
		$post_Course = json_decode(trim(file_get_contents('php://input')), true);		
		if ($post_Course)
		 {
			if($post_Course['id'] > 0)
			{
				$result = $this->Badges_model->delete_badge($post_Course);
				if($result) 
				{
					echo json_encode("Delete successfully");
				}else
				{
					echo json_encode('error');	
				}
		 	}
		} 	
	}
	public function isActiveChange()
	{
		$post_data = json_decode(trim(file_get_contents('php://input')), true);	
		if ($post_data) 
		{
			$result = $this->Badges_model->isActiveChange($post_data);
			if($result) 
			{
				echo json_encode('success');	
			}else
			{
				echo json_encode('error');	
			}

		}else
		{
			echo json_encode('error');	
		}	
	}
	
	public function badgeuploadFile($id)
	{
		if($_FILES)
		{
			if(isset($_FILES['BadgeImage']) && !empty($_FILES['BadgeImage']))
			{	
				//$dirname=str_replace(' ','_',$id);
				//$directoryname="../src/assets/Instructor/".$id."/";

				$directoryname="../src/assets/Instructor/".$id."/";
				$directoryname1= $directoryname."image/";
				if(!is_dir($directoryname1))
				{
					mkdir($directoryname1, 0755, true);
				}
				$target_dir=$directoryname1;
				$newfilename= str_replace(" ", "_", basename($_FILES["BadgeImage"]["name"]));
				$target_file = $target_dir . $newfilename;
				move_uploaded_file($_FILES["BadgeImage"]["tmp_name"], $target_file);
				//move_uploaded_file($_FILES["CourseImage"]["tmp_name"], "../assets/Course/".$_FILES["CourseImage"]["name"]);
				echo json_encode('success');
			}else
			{
				echo json_encode('error2');
			} 
	
			}
			else
			{
				echo json_encode('error');
			}
	}
}