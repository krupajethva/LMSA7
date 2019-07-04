<?php

class Coursebeforereminders_model extends CI_Model
{
    public function update($data)
    {
        if ($data) {
            $post_data = $data;
            $updatetdata = array(
                "CourseId" => trim($post_data['CourseId']),
                "RemainderDay1" =>  trim($post_data['RemainderDay1'] ? $post_data['RemainderDay1'] : '0'),
                "RemainderDay2" =>  trim($post_data['RemainderDay2'] ? $post_data['RemainderDay2'] : '0'),
                "RemainderDay3" =>  trim($post_data['RemainderDay3'] ? $post_data['RemainderDay3'] : '0'),
                "Reminder1SendTo" => trim(($post_data['candidate1'] ? $post_data['candidate1'] : '0')
                    . ',' . ($post_data['instructor1'] ? $post_data['instructor1'] : '0')),
                "Reminder2SendTo" => trim(($post_data['candidate2'] ? $post_data['candidate2'] : '0')
                    . ',' . ($post_data['instructor2'] ? $post_data['instructor2'] : '0')),
                "Reminder3SendTo" => trim(($post_data['candidate3'] ? $post_data['candidate3'] : '0')
                    . ',' . ($post_data['instructor3'] ? $post_data['instructor3'] : '0')),
            );
            $this->db->where('CourseBeforeReminderId', $post_data['CourseBeforeReminderId']);
            $res = $this->db->update('tblcoursebeforereminder', $updatetdata);
            if ($res) {
                $response = new stdClass(); 
                $response->success = true;
                $response->message = "updated successfully";
                return $response;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insert($data)
    {
        if ($data) {
            $post_data = $data;
            $insertdata = array(
                "CourseId" => trim($post_data['CourseId']),

                "RemainderDay1" =>  trim($post_data['RemainderDay1'] ? $post_data['RemainderDay1'] : '0'),
                "RemainderDay2" =>  trim($post_data['RemainderDay2'] ? $post_data['RemainderDay2'] : '0'),
                "RemainderDay3" =>  trim($post_data['RemainderDay3'] ? $post_data['RemainderDay3'] : '0'),
                "Reminder1SendTo" => trim(($post_data['candidate1'] ? $post_data['candidate1'] : '0')
                    . ',' . ($post_data['instructor1'] ? $post_data['instructor1'] : '0')),
                "Reminder2SendTo" => trim(($post_data['candidate2'] ? $post_data['candidate2'] : '0')
                    . ',' . ($post_data['instructor2'] ? $post_data['instructor2'] : '0')),
                "Reminder3SendTo" => trim(($post_data['candidate3'] ? $post_data['candidate3'] : '0')
                    . ',' . ($post_data['instructor3'] ? $post_data['instructor3'] : '0')),
            );
            $res = $this->db->insert('tblcoursebeforereminder', $insertdata);
            $insertdata['CourseBeforeReminderId'] = $this->db->insert_id();
            
            if ($res) {
                $response = new stdClass();
                $response->success = true;
                $response->message = "Added successfully";
                return $response;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function course_list()
    {
        $result=$this->db->query("SELECT co.CourseId,co.CourseFullName FROM tblcourse co WHERE co.CourseId NOT IN (SELECT br.CourseId FROM tblcoursebeforereminder br) AND  co.IsActive='1'");
        if ($result) {
            return $result;
        }
        return $result;
      
    }

    public function getAllDetails()
    {
        $this->db->select('tr.CourseBeforeReminderId, tr.CourseId,tr.RemainderDay1,tr.RemainderDay2,tr.RemainderDay3,tc.CourseFullName,Reminder1SendTo,Reminder2SendTo,Reminder3SendTo');
        $this->db->join('tblcourse as tc', 'tr.CourseId=tc.CourseId');
        $this->db->from('tblcoursebeforereminder as tr');

        $query = $this->db->get();
        if ($query) {
            return $query;
        }
        return $query;
    }

    public function getlist()
    {
        $this->db->select('CourseId,RemainderDay1,RemainderDay2,RemainderDay3,Reminder1SendTo,Reminder2SendTo,Reminder3SendTo');
        $this->db->from('tblcoursebeforereminder');
        $query = $this->db->get();
        if ($query) {
            return $query;
        }
        return $query;
    }
    public function fetch_data($id = NULL)
	{
		if ($id) {
            $this->db->select('tr.CourseBeforeReminderId, tr.CourseId,tr.RemainderDay1,tr.RemainderDay2,tr.RemainderDay3,tc.CourseFullName,Reminder1SendTo,Reminder2SendTo,Reminder3SendTo');
            $this->db->join('tblcourse as tc', 'tr.CourseId=tc.CourseId');
            $this->db->where('CourseBeforeReminderId',$id);
            $this->db->from('tblcoursebeforereminder as tr');

            $query = $this->db->get();
            if ($query) {
                return $query;
            }
            return $query;
        }
	}
}
