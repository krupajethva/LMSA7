<?php

class Coursebeforereminders_model extends CI_Model
{
    // public function update($data)
    // {
    // 	if ($data) {
    //         $post_data = $data;
    // 		$updatetdata1 = array(
    //             "ConfigurationId" => 17,
    //             "key" => "coursebeforereminder1",
    //             "value" => $post_data[0] ? trim($post_data[0]['day1']) : 0,
    //             "Description" => 
    //             ($post_data[0]['candidate'] ? $post_data[0]['candidate'] : '0')
    //             . ',' .
    //             ($post_data[0]['instructor'] ? $post_data[0]['instructor'] : '0')
    //         );
    //         $updatetdata2 = array(
    //             "ConfigurationId" => 18,
    //             "key" => "coursebeforereminder2",
    //             "value" => trim($post_data[1]['day2']),
    //             "Description" => 
    //             ($post_data[1]['candidate'] ? $post_data[1]['candidate'] : '0')
    //             . ',' .
    //             ($post_data[1]['instructor'] ? $post_data[1]['instructor'] : '0')
    //         );
    //         $updatetdata3 = array(
    //             "ConfigurationId" => 19,
    //             "key" => "coursebeforereminder3",
    //             "value" => trim($post_data[2]['day3']),
    //             "Description" => 
    //             ($post_data[2]['candidate'] ? $post_data[2]['candidate'] : '0')
    //             . ',' .
    //             ($post_data[2]['instructor'] ? $post_data[2]['instructor'] : '0')
    //         );
    //        // print_r($updatetdata);
    //         $updatetdata = array($updatetdata1,$updatetdata2,$updatetdata3);
    // 		$res = $this->db->update_batch('tblmstconfiguration', $updatetdata, 'ConfigurationId');
    // 		if ($res) {
    // 			return true;
    // 		} else {
    // 			return false;
    // 		}
    // 	} else {
    // 		return false;
    // 	}
    // }

    public function insert($data)
    {
        if ($data) {
            $post_data = $data;
            $insertdata = array(
                "CourseId" => trim($post_data['CourseId']),
                "RemainderDay1" => trim($post_data['day1']),
                "RemainderDay2" => trim($post_data['day2']),
                "RemainderDay3" => trim($post_data['day3']),
                "Reminder1SendTo" => trim(($post_data['candidate1'] ? $post_data['candidate1'] : '0')
                    . ',' . ($post_data['instructor1'] ? $post_data['instructor1'] : '0')),
                "Reminder2SendTo" => trim(($post_data['candidate2'] ? $post_data['candidate2'] : '0')
                    . ',' . ($post_data['instructor2'] ? $post_data['instructor2'] : '0')),
                "Reminder3SendTo" => trim(($post_data['candidate3'] ? $post_data['candidate3'] : '0')
                    . ',' . ($post_data['instructor3'] ? $post_data['instructor3'] : '0')),
            );
            $res = $this->db->insert('tblcoursebeforereminder', $insertdata);
            if ($res) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function course_list()
    {
        $this->db->select('CourseId,CourseFullName');
        $this->db->from('tblcourse');
        $this->db->where('IsActive', 1);
        $query = $this->db->get();
        if ($query) {
            return $query;
        }
        return $query;
    }

    public function getAllDetails(){
        $this->db->select('tr.CourseId,tr.RemainderDay1,tr.RemainderDay2,tr.RemainderDay3,tc.CourseFullName');
        $this->db->join('tblcourse as tc','tr.CourseId=tc.CourseId');
        $this->db->from('tblcoursebeforereminder as tr');
       
        $query = $this->db->get();
        if ($query) {
            return $query;
        }
        return $query;
    }
}
