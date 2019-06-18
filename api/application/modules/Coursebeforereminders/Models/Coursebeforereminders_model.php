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
                return true;
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

    public function deletereminder($CourseBeforeReminderId)
    {
        $this->db->where('CourseBeforeReminderId', $CourseBeforeReminderId);
        $this->db->delete('tblcoursebeforereminder');
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
}
