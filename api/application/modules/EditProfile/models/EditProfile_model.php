<?php

class EditProfile_model extends CI_Model
{

	// list country //
	public function getlist_Country() {
		try{
		$this->db->select('CountryId,CountryName');
		$this->db->where('IsActive="1"');
		$this->db->order_by('CountryName','asc');
		$result = $this->db->get('tblmstcountry');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
		
	}

		// list state //
	public function getlist_State() {
		try{
		$this->db->select('StateId,StateName');
		$this->db->where('IsActive="1"');
		$this->db->order_by('StateName','asc');
		$result = $this->db->get('tblmststate');
		$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
		$res = array();
		if($result->result()) {
			$res = $result->result();
		}
		return $res;
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
		
	}

     // User for Company country //
	public function getStateList($cid = NULL) {
		try{
		if($cid) {
			
			$this->db->select('StateId,StateName');
			$this->db->order_by('StateName','asc');
			$this->db->where('IsActive="1"');
			$this->db->where('CountryId',$cid);
			$result = $this->db->get('tblmststate');				
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
			
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	// use for user country //
	public function getStateListadd($country_id = NULL) {
		try{
		if($country_id) {
			
			$this->db->select('StateId,StateName');
			$this->db->order_by('StateName','asc');
			$this->db->where('IsActive="1"');
			$this->db->where('CountryId',$country_id);
			$result = $this->db->get('tblmststate');				
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
			
		} else {
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}
	

	 // get user data //    
	public function get_userdata($user_id=Null)
	{
		try{
	    if($user_id)
	    {		  
			
			$this->db->select('us.UserId,us.InvitedByUserId,us.RoleId,us.CompanyId,us.FirstName,us.LastName,us.Title,us.EmailAddress,us.Password,us.PhoneNumber,us.PhoneNumber2,us.ProfileImage,us.SignatureId,us.Biography,us.IsStatus,us.IsActive,add2.AddressesId,add2.Address1,add2.Address2,add2.CountryId,add2.StateId,add2.City,add2.ZipCode,add2.IsActive,det.UserDetailId,det.EducationLevelId,edu.Education,det.Skills,det.Field,certi.CertificateId,certi.Certificate,rs.InstructorId as fid,rs.FilePath as Signature');
			$this->db->join('tblmstaddresses add2','add2.AddressesId = us.AddressesId', 'left');
			//$this->db->join('tblcompany com', 'com.CompanyId = us.CompanyId', 'left');
			//$this->db->join('tblmstindustry ind', 'ind.IndustryId = com.IndustryId', 'left');
			//$this->db->join('tblmstaddresses add','add.AddressesId = com.AddressesId', 'left');
			$this->db->join('tblresources rs','rs.ResourcesId = us.SignatureId', 'left');
			$this->db->join('tbluserdetail det','det.UserDetailId = us.UserDetailId', 'left');
			$this->db->join('tblmsteducationlevel edu','edu.EducationLevelId = det.EducationLevelId', 'left');
			$this->db->join('tblinstructorcertificate certi','certi.UserId = us.UserId', 'left');

			$this->db->where('us.UserId',$user_id);
			$result = $this->db->get('tbluser us');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$user_data= array();
			foreach($result->result() as $row)
			{
				$user_data=$row;				
			}
		 	return $user_data;		 
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	// get education detail data  //
	public function get_Educationdetail($user_id)
	{
		try{
	    if($user_id)
	    {		  
			$this->db->select('det.UserDetailId,det.EducationLevelId,det.Skills,det.Field,us.UserId,us.RoleId');
		  $this->db->join('tbluserdetail det','det.UserDetailId = us.UserDetailId', 'left');
			$this->db->where('UserId',$user_id);
			$result = $this->db->get('tbluser us');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$user_data= array();
			foreach($result->result() as $row)
			{
				$user_data=$row;				
			}
		 	return $user_data;		 
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}

	// get education detail data  //
	public function get_EducationCertificate($user_id)
	{
		try{
	    if($user_id)
	    {		  
			$this->db->select('tc.CertificateId,tc.Certificate');
			$this->db->where('UserId',$user_id);
			$result = $this->db->get('tblinstructorcertificate tc');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$certificate_data= array();
			if($result->result()) {
				$certificate_data = $result->result();
			}			
		 	return $certificate_data;		 
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}


	// list education //
	public function getlist_EducationLevel() {
		try{
				$this->db->select('edu.EducationLevelId,edu.Education,edu.IsActive');
				$this->db->order_by('edu.Education','asc');
				$result = $this->db->get('tblmsteducationlevel edu');
			//	$result = $this->db->query('call educationList()');
				$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
				$res = array();
				if($result->result()) {
					$res = $result->result();
				}
				return $res;
			}
			catch(Exception $e){
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
			
		}

		// get all skills //
	public function getSkillList() {
		try{
			$this->db->select('tud.Skills');
			$skill_list = $this->db->get('tbluserdetail tud');
			$db_error = $this->db->error();
			if (!empty($db_error) && !empty($db_error['code'])) { 
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				return false; // unreachable return statement !!!
			}

			$skill_data= array();
			foreach($skill_list->result() as $row)
		 	{				
				$skill_explode = explode(',', $row->Skills);
				foreach ($skill_explode as $skill) {
					if($skill!="" || $skill!=null){
						array_push($skill_data,$skill);
					}					
				}
		 	}
			return array_values(array_unique($skill_data));
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
			
		}

		// list industry //
		public function getlist_industrydata() {
			try{
			$this->db->select('IndustryId,IndustryName');
			$this->db->where('IsActive="1"');
			$this->db->order_by('IndustryName','asc');
			$result = $this->db->get('tblmstindustry');
			$db_error = $this->db->error();
					if (!empty($db_error) && !empty($db_error['code'])) { 
						throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
						return false; // unreachable return statement !!!
					}
			$res = array();
			if($result->result()) {
				$res = $result->result();
			}
			return $res;
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
			
		}


	
	 // get company id data //
	public function get_companydata($CompanyId=Null)
	{
		try{
	    if($CompanyId)
	    {		  
			$this->db->select('com.CompanyId,com.ParentId,com.IndustryId,com.Name,com.EmailAddress as EmailAddressCom,com.Website,com.AddressesId,com.PhoneNumber,com.IsActive,add.AddressesId as AddressesId2,add.Address1,add.Address2,add.CountryId,add.StateId,add.City,add.ZipCode,add.IsActive');
			$this->db->join('tblmstaddresses add','add.AddressesId = com.AddressesId', 'left');

			$this->db->where('com.CompanyId',$CompanyId);
			$result = $this->db->get('tblcompany com');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			$company_data= array();
			foreach($result->result() as $row)
			{
				$company_data=$row;				
			}
		 	return $company_data;		 
		}
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}


	// update user data //
	public function edit_profile($post_user) {
		try{
		if($post_user) 
		{	
			$this->db->select('EmailAddress');
		
			$this->db->where('EmailAddress',trim($post_user['EmailAddress']));
			//$this->db->where('InvitedByUserId',trim($post_user['InvitedByUserId']));
			$this->db->where('UserId!=',trim($post_user['UserId']));
			$this->db->limit(1);
			$query = $this->db->get('tbluser');
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if ($query->num_rows() == 1) {
				return false;
			} 
			
			// if($post_user['CompanyId']>0)
			// {
			
			// 	if(isset($post_user['Address1']) && !empty($post_user['Address1'])){
			// 		$Address1 = $post_user['Address1'];
			// 	}	else {
			// 		$Address1 = null;
			// 	}

			// 	if(isset($post_user['Address2']) && !empty($post_user['Address2'])){
			// 		$Address2 = $post_user['Address2'];
			// 	}	else {
			// 		$Address2 = null;
			// 	}

			// 	if(isset($post_user['CountryId']) && !empty($post_user['CountryId'])){
			// 		$CountryId = $post_user['CountryId'];
			// 	}	else {
			// 		$CountryId = null;
			// 	}

			// 	if(isset($post_user['StateId']) && !empty($post_user['StateId'])){
			// 		$StateId = $post_user['StateId'];
			// 	}	else {
			// 		$StateId = null;
			// 	}

			// 	if(isset($post_user['City']) && !empty($post_user['City'])){
			// 		$City = $post_user['City'];
			// 	}	else {
			// 		$City =null;
			// 	}

			// 	if(isset($post_user['ZipCode']) && !empty($post_user['ZipCode'])){
			// 		$ZipCode = $post_user['ZipCode'];
			// 	}	else {
			// 		$ZipCode =null;
			// 	}

			// 	$user1_data=array(
			// 		'AddressesId' => $post_user['AddressesId'],
			// 		'Address1' =>$Address1,
			// 		'Address2' =>$Address2,
			// 		'CountryId' => $CountryId,
			// 		'StateId' => $StateId,
			// 		'City' => $City,
			// 		'ZipCode' => $ZipCode,
			// 		'IsActive' =>1,
			// 		'UpdatedBy' => $post_user['UserId'],
			// 		'UpdatedOn' => date('y-m-d H:i:s')
			// 	);	
			// 	$this->db->where('AddressesId',trim($post_user['AddressesId']));
			// 	$res = $this->db->update('tblmstaddresses',$user1_data);
					
			// }
			// else 
			// {
			// 	$addressesId = $post_user['AddressesId']; 
			// }

			if(isset($post_user['Address1']) && !empty($post_user['Address1'])){
				$Address1 = $post_user['Address1'];
			}	else {
				$Address1 = null;
			}

			if(isset($post_user['Address2']) && !empty($post_user['Address2'])){
				$Address2 = $post_user['Address2'];
			}	else {
				$Address2 = null;
			}

			if(isset($post_user['CountryId']) && !empty($post_user['CountryId'])){
				$CountryId = $post_user['CountryId'];
			}	else {
				$CountryId = null;
			}

			if(isset($post_user['StateId']) && !empty($post_user['StateId'])){
				$StateId = $post_user['StateId'];
			}	else {
				$StateId = null;
			}

			if(isset($post_user['City']) && !empty($post_user['City'])){
				$City = $post_user['City'];
			}	else {
				$City =null;
			}

			if(isset($post_user['ZipCode']) && !empty($post_user['ZipCode'])){
				$ZipCode = $post_user['ZipCode'];
			}	else {
				$ZipCode =null;
			}


			$user1_data=array(
				'AddressesId' => $post_user['AddressesId'],
				'Address1' =>$Address1,
				'Address2' =>$Address2,
				'CountryId' => $CountryId,
				'StateId' => $StateId,
				'City' => $City,
				'ZipCode' => $ZipCode,
				'IsActive' =>1,
				'UpdatedBy' => $post_user['UserId'],
				'UpdatedOn' => date('y-m-d H:i:s')
			);	
			$this->db->where('AddressesId',trim($post_user['AddressesId']));
			$res = $this->db->update('tblmstaddresses',$user1_data);

			if(isset($post_user['Title']) && !empty($post_user['Title'])){
				$Title = $post_user['Title'];
			}	else {
				$Title = '';
			}
			
			if(isset($post_user['PhoneNumber2']) && !empty($post_user['PhoneNumber2'])){
				$PhoneNumber2 = $post_user['PhoneNumber2'];
			}	else {
				$PhoneNumber2 = '';
			}
			if(isset($post_user['Biography']) && !empty($post_user['Biography'])){
				$Biography = $post_user['Biography'];
			}	else {
				$Biography = '';
			}

			$user_data = array(
				"UserId"=>trim($post_user['UserId']),
				"FirstName"=>trim($post_user['FirstName']),
				"LastName"=>trim($post_user['LastName']),
				"EmailAddress"=>trim($post_user['EmailAddress']),
				"Title"=>$Title,
				"PhoneNumber"=>trim($post_user['PhoneNumber']),
				"PhoneNumber2"=>$PhoneNumber2,
				"AddressesId"=>trim($post_user['AddressesId']),
				"Biography"=>$Biography,
				"UpdatedBy" => $post_user['UserId'],
				"UpdatedOn" => date('y-m-d H:i:s'),
			);
			if(isset($post_user['Signature']) && !empty($post_user['Signature'])){
				$image_data = array(
					'InstructorId' => $post_user['UserId'],
					'FilePath' => $post_user['Signature'],
					'Dataurl' => $post_user['Dataurl'],
					'Keyword' => "Signature",
					'IsActive'=>1,
					'CreatedBy' => $post_user['UserId'],
					'CreatedOn' => date('y-m-d H:i:s')
						);
					$res1=$this->db->query('call addResources(?,?,?,?,?,?,?,@id)',$image_data);
					 $out_param_query = $this->db->query('select @id as out_param;');
					$id1=$out_param_query->result()[0]->out_param;
			}	else {
				// $id1 = '';
			}
	
			//function to push associative array

			function array_push_assoc($array, $key, $value){
				$array[$key] = $value;
				return $array;
			}

			if(isset($post_user['ProfileImage']) && !empty($post_user['ProfileImage'])){
				$user_data = array_push_assoc($user_data, 'ProfileImage', trim($post_user['ProfileImage']));
			}

			if(isset($id1) && !empty($id1)){
				$user_data = array_push_assoc($user_data, 'SignatureId', trim($id1));
			}
				
			$this->db->where('UserId',$post_user['UserId']);
			$res = $this->db->update('tbluser',$user_data);
			//$res= $this->db->query('call userAdminUpdate(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$user_data);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) 
			{
				return true;
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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}		
}


	 // update education detail //
	public function updateEducationDetails($post_user) {
		try{
		if($post_user) 
		{							
			$this->db->select('UserId,UserDetailId');
			$this->db->where('UserId',$post_user['UserId']);
			$result=$this->db->get('tbluser');
			$res1=array();
			if($result->result())
			{
				$res1=$result->result();
			}
			$UserDetailId=$res1[0]->UserDetailId;

			if($post_user['Certificate']!='')
			{
				foreach($post_user['Certificate'] as $certificate)
				{
							$user_data1=array(	
								"UserId" => $post_user['UserId'],
								"Certificate" =>  $certificate,
								"CreatedBy" =>trim($post_user['UserId']),
								"CreatedOn" =>date('y-m-d H:i:s')		
							);		
							$res=$this->db->insert('tblinstructorcertificate',$user_data1);
				}					
			}

			
			// if($post_user['Certificate']!='')
			// {
				
			// 				$user_data1=array(	
			// 					"UserId" => $post_user['UserId'],
			// 					"Certificate" =>$post_user['Certificate'],
			// 					"CreatedBy" =>trim($post_user['UserId']),
			// 					"CreatedOn" =>date('y-m-d H:i:s')		
			// 				);		
			// 				$res=$this->db->insert('tblinstructorcertificate',$user_data1);
								
			// }

				if($post_user['RoleId']==3){
					$user_data = array(
						"EducationLevelId"=>trim($post_user['EducationLevelId']),
						"Field"=>trim($post_user['Field']),
						"UpdatedBy" => $post_user['UserId'],
						'UpdatedOn' => date('y-m-d H:i:s')
					);

				} elseif($post_user['RoleId']==4){
					$user_data = array(
						"EducationLevelId"=>trim($post_user['EducationLevelId']),
						"Field"=>trim($post_user['Field']),
						"Skills"=>trim($post_user['Skills']),
						"UpdatedBy" => $post_user['UserId'],
						'UpdatedOn' => date('y-m-d H:i:s')
					);
				}		
		
			$this->db->where('UserDetailId',$UserDetailId);
			$res = $this->db->update('tbluserdetail',$user_data);

		


			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) 
			{
				return true;
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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}		
	}

	//delete user certificate
	public function deleteCertificate($post_Certificate) 
	{
	 try{
		if($post_Certificate) 
		{
			$id=$post_Certificate['id'];
			$this->db->where('CertificateId',$id);
			$res = $this->db->delete('tblinstructorcertificate');
			// $res=$this->db->query('call deleteCertificate(?)',$id);
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}
			if($res) {
				$log_data = array(
					'UserId' =>trim($post_Certificate['Userid']),
					'Module' => 'User Certificate',
					'Activity' =>'Delete'
	
				);
				$log = $this->db->insert('tblactivitylog',$log_data);
				return true;
			} else {
				return false;
			}	

		}else 
			{
			return false;
			}
		}
		catch(Exception $e){
			trigger_error($e->getMessage(), E_USER_ERROR);
			return false;
		}
	}

	 // update company detail //
	public function updateCompany($post_company)
	{
		try{
			if($post_company)
			{
								$user1_data=array(
									'AddressesId' => $post_company['AddressesId2'],
									'Address1' =>$post_company['Address12'],
									'Address2' =>$post_company['Address22'],
									'CountryId' => $post_company['cid'],
									'StateId' => $post_company['sid'],
									'City' => $post_company['City2'],
									'ZipCode' => $post_company['ZipCode2'],
									'IsActive' => 1,
									'UpdatedBy' => $post_company['UpdatedBy'],
									'UpdatedOn' => date('y-m-d H:i:s')
								);	
								$this->db->where('AddressesId',$post_company['AddressesId2']);
								$res1 = $this->db->update('tblmstaddresses',$user1_data);
					
								$company_data=array(
									'CompanyId' => $post_company['CompanyId'],
									'IndustryId' => $post_company['IndustryId'],
									'Name' => $post_company['Name'],
									'EmailAddress' => $post_company['EmailAddressCom'],
									'Website' => $post_company['Website'],
									'PhoneNumber' => $post_company['PhoneNumber'],
									'IsActive' => 1,
									'UpdatedBy' => $post_company['UpdatedBy'],
									'UpdatedOn' => date('y-m-d H:i:s')
								);	
								$this->db->where('CompanyId',trim($post_company['CompanyId']));
								$res = $this->db->update('tblcompany',$company_data);
								if($res){
									return true;
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
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}		
	}


	// chnage pass user //
	public function change_password($post_pass) 
	{	
		try{
		if($post_pass)
		{
			$this->db->select('UserId,Password,EmailAddress,FirstName');				
			$this->db->where('UserId',trim($post_pass['UserId']));
			$this->db->where('Password',md5(trim($post_pass['Password'])));
			$this->db->limit(1);
			$this->db->from('tbluser');
			$query = $this->db->get();
			$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}				
			if ($query->num_rows() == 1) 
			{
				$pass_data = array(
					'UserId'=>trim($post_pass['UserId']),
					'Password'=>md5($post_pass['nPassword']),
					'CreatedOn' => date('y-m-d H:i:s'),
					'UpdatedOn' => date('y-m-d H:i:s')
				);
		
				// $this->db->where('UserId',trim($post_pass['UserId']));
				// $res = $this->db->update('tbluser',$pass_data);
				$res= $this->db->query('call adminPasswordChange(?,?,?,?)',$pass_data);
				$db_error = $this->db->error();
				if (!empty($db_error) && !empty($db_error['code'])) { 
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
					return false; // unreachable return statement !!!
				}	
				if($res)
				{
					$pass = array();
					foreach($query->result() as $row) {
						$pass = $row;
					}
					return $pass;
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
		else
		{
			return false;
		}
	}
	catch(Exception $e){
		trigger_error($e->getMessage(), E_USER_ERROR);
		return false;
	}
	}
	
}