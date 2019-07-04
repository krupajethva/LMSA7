<?php

class Coursebeforereminderlist_model extends CI_Model
{
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

}
