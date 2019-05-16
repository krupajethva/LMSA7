<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rolepermission extends MY_Controller {


    public function __construct() {
	
		parent::__construct();		
		$this->load->model('Rolepermission_model');
		
	}

	public function getLeftMenu($role_id = NULL){
		if (!empty($role_id)) {
			if($role_id){
				$query = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and (s.InvitedByUserId=0 or s.ScreenId=s.InvitedByUserId) and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
				$res = $this->db->query($query);
				$array = json_decode(json_encode($res->result()), True);
				$result = array();
				foreach($array as $row){
					if($row['InvitedByUserId']==0){
						$sub_query = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and s.InvitedByUserId!=s.ScreenId and s.InvitedByUserId=".$row['ScreenId']." and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
						$sub_res = $this->db->query($sub_query);
						$sub_array = json_decode(json_encode($sub_res->result()), True); 
						if(count($sub_array)>0){
							$row['check']=true;
							$result1 = array();
							$row['child'] = array();
							foreach($sub_array as $sub_row){
								if($sub_row['Url']==''){
									$sub_query1 = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and s.InvitedByUserId!=s.ScreenId and s.InvitedByUserId=".$sub_row['ScreenId']." and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
									$sub_res1 = $this->db->query($sub_query1);
									$sub_array1 = json_decode(json_encode($sub_res1->result()), True); 
									if(count($sub_array1)>0){
										$sub_row['check']=true;
										$sub_row['child']=$sub_array1;
										array_push($result1,$sub_row);
									} else {
										$sub_row['check']=false;
										//$sub_row['child']=$sub_array1;
										array_push($result1,$sub_row);
									}
								} else {
									$sub_row['check']=false;
									array_push($result1,$sub_row);
								}
								array_push($row['child'],$sub_row);
											
							}
							array_push($result,$row);
						}
					} else {
						$row['check']=false;
						array_push($result,$row);
					}				
				}
		
				//print_r($result);
				echo json_encode($result);

			} elseif($role_id){
				$query = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and (s.InvitedByUserId=0 or s.ScreenId=s.InvitedByUserId) and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
				$res = $this->db->query($query);
				$array = json_decode(json_encode($res->result()), True);
				$result = array();
				foreach($array as $row){
					if($row['InvitedByUserId']==0){
						$sub_query = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and s.InvitedByUserId!=s.ScreenId and s.InvitedByUserId=".$row['ScreenId']." and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
						$sub_res = $this->db->query($sub_query);
						$sub_array = json_decode(json_encode($sub_res->result()), True); 
						if(count($sub_array)>0){
							$row['check']=true;
							$result1 = array();
							$row['child'] = array();
							foreach($sub_array as $sub_row){
								if($sub_row['Url']==''){
									$sub_query1 = "SELECT s.ScreenId,s.InvitedByUserId,s.DisplayName,s.Name,s.SelectedClass,s.Url,s.Icon FROM `tblmstscreen` AS s LEFT JOIN tblrolespermission AS r ON s.ScreenId=r.ScreenId WHERE r.RoleId=$role_id and s.InvitedByUserId!=s.ScreenId and s.InvitedByUserId=".$sub_row['ScreenId']." and (r.View=1 or r.AddEdit=1 or r.Delete=1) ORDER BY s.SerialNo ASC";
									$sub_res1 = $this->db->query($sub_query1);
									$sub_array1 = json_decode(json_encode($sub_res1->result()), True); 
									if(count($sub_array1)>0){
										$sub_row['check']=true;
										$sub_row['child']=$sub_array1;
										array_push($result1,$sub_row);
									}
								} else {
									$sub_row['check']=false;
									array_push($result1,$sub_row);
								}
								array_push($row['child'],$sub_row);
											
							}
							array_push($result,$row);
						}
					} else {
						$row['check']=false;
						array_push($result,$row);
					}				
				}
				echo json_encode($result);

			}
		}
	}

	public function getDefault($role_id = NULL)
	{	
		if (!empty($role_id)) {
			$data['role']=$this->Rolepermission_model->getuserrolelist();
			if($role_id==5){
				$data['permission']=$this->Rolepermission_model->getpermissionlist(1);
			} elseif($role_id==1) {
				$data['permission']=$this->Rolepermission_model->getpermissionlist(2);
			} elseif($role_id==2) {
				$data['permission']=$this->Rolepermission_model->getpermissionlist(3);
			}		
			echo json_encode($data);			
		}		
	}

	public function getRolePermission($role_id = NULL)
	{
		if (!empty($role_id)) {
			$data=$this->Rolepermission_model->getpermissionlist($role_id);		
			echo json_encode($data);			
		}		
	}

	public function update_permission() {
		
		$post_permission = json_decode(trim(file_get_contents('php://input')), true);		

		if ($post_permission) {
			$result = $this->Rolepermission_model->update_permission($post_permission);
			if($result) {
				echo json_encode($result);	
			}							
		}
		
	}	
		
}
