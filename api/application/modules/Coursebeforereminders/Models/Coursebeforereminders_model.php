<?php

class Coursebeforereminders_model extends CI_Model
{
    public function update($data)
	{
		if ($data) {
			$post_data = $data;

			$updatetdata1 = array(
                "key" => "coursebeforereminder1",
                "value" => trim($post_data['days1']),
                "Description" => trim($post_data['Candidate1'],$post_data['Instructor1'])
            );
            $updatetdata2 = array(
                "key" => "coursebeforereminder2",
                "value" => trim($post_data['days2']),
                "Description" => trim($post_data['Candidate2'],$post_data['Instructor2'])
            );
            $updatetdata3 = array(
                "key" => "coursebeforereminder3",
                "value" => trim($post_data['days3']),
                "Description" => trim($post_data['Candidate3'],$post_data['Instructor3'])
			);
            $this->db->where('ConfigurationId'=17,updatetdata1);
            $this->db->where('ConfigurationId'=18,updatetdata2);
            $this->db->where('ConfigurationId'=19,updatetdata3);

            $updatetdata = array($updatetdata1,$updatetdata2,$updatetdata3);
			$res = $this->db->update('tblmstconfiguration', $updatetdata);
			if ($res) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}