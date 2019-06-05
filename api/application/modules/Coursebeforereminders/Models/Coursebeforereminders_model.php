<?php

class Coursebeforereminders_model extends CI_Model
{
    public function update($data)
	{
		if ($data) {
            $post_data = $data;
			$updatetdata1 = array(
                "ConfigurationId" => 17,
                "key" => "coursebeforereminder1",
                "value" => $post_data[0] ? trim($post_data[0]['day1']) : 0,
                "Description" => 
                ($post_data[0]['candidate'] ? $post_data[0]['candidate'] : '0')
                . ',' .
                ($post_data[0]['instructor'] ? $post_data[0]['instructor'] : '0')
            );
            $updatetdata2 = array(
                "ConfigurationId" => 18,
                "key" => "coursebeforereminder2",
                "value" => trim($post_data[1]['day2']),
                "Description" => 
                ($post_data[1]['candidate'] ? $post_data[1]['candidate'] : '0')
                . ',' .
                ($post_data[1]['instructor'] ? $post_data[1]['instructor'] : '0')
            );
            $updatetdata3 = array(
                "ConfigurationId" => 19,
                "key" => "coursebeforereminder3",
                "value" => trim($post_data[2]['day3']),
                "Description" => 
                ($post_data[2]['candidate'] ? $post_data[2]['candidate'] : '0')
                . ',' .
                ($post_data[2]['instructor'] ? $post_data[2]['instructor'] : '0')
            );
            print_r($updatetdata);
            $updatetdata = array($updatetdata1,$updatetdata2,$updatetdata3);
			$res = $this->db->update_batch('tblmstconfiguration', $updatetdata, 'ConfigurationId');
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