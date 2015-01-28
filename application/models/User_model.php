<?php 
class User_model extends CI_Model{
	//Get list of all users in system
	public function get_users(){
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}

	//Get users by field
	public function get_users_by($fieldname,$value){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($fieldname,$value);
		$query = $this->db->get();
		return $query->result();
	}

	//Get User details
	public function get_user_details($id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//Register New User
	public function register(){
		$userip=$this->find_user_ip();
		$data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'address' => $this->input->post('address'),
			'address2' => $this->input->post('address2'),
			'phone' => $this->input->post('phone'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'last_logon_ip' => $userip,
			'geolocation' => $this->geoCheckIP($userip),//use this only in live site
			'last_active' => date("Y-m-d H:i:s")
			);

		$insert = $this->db->insert('users',$data);
		return $insert;
	}

	//Update User
	public function edit_user($id){
		$userip=$this->find_user_ip();
		$data = array(
			'address' => $this->input->post('address'),
			'address2' => $this->input->post('address2'),
			'phone' => $this->input->post('phone'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'previllege' => $this->input->post('previllege'),
			'email' => $this->input->post('email'));

		if($this->session->userdata('user_id')==$id){ //if it is edited by user
			$data['last_logon_ip'] = $userip;
			//$data['geolocation'] = $this->geoCheckIP($userip);//use this only on live site
			$data['last_active'] = date("Y-m-d H:i:s");
		}

		if($this->input->post('password')!=''){ //update password only if it is supplied
			$data['password'] = md5($this->input->post('password'));
		}

		$this->db->where('id',$id);
		$update = $this->db->update('users',$data);
		return $update;
	}

	//Get list of distinct previlleges //May be not necessary //or create another table for previllege
	public function get_user_previlleges(){
		$this->db->distinct();
		$this->db->select('previllege');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}

	//update  last_active in users table 
	public function update_last_active(){
		//$data = array('last_active'=> 'DATE_ADD(NOW(), INTERVAL 1 MINUTE)');
		//$this->db->where('id',$this->session->userdata('user_id'));
		//$this->db->update('users',$data);
		if ($this->session->userdata('logged_in')){
			$ip=$this->find_user_ip();
			$q = "UPDATE users SET last_active = DATE_ADD(NOW(), INTERVAL 1 MINUTE), geolocation = '".$this->geoCheckIP($ip)."', last_logon_ip = '".$ip."' WHERE id = '".$this->session->userdata('user_id')."'";
			$this->db->query($q);
			return true;
		} else {
			return false;
		}
	}

	//Returns user_id if username and password matches
	public function login($username,$password){
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		$result = $this->db->get('users');
		if($result->num_rows() == 1){
			return $result->row(0)->id;
		} else {
			return false;
		}
	}

	//Returns true if supplied password matches with current password of current user
	public function check_password($password,$id){
		$this->db->where('id',$id);
		$this->db->where('password',$password);
		$result = $this->db->get('users');
		if($result->num_rows() == 1){
			return true;
		} else {
			return false;
		}
	}

	//I think these should be in different model

	//Find ip address of User
	public function find_user_ip(){
		/*if ($_SERVER['HTTP_CLIENT_IP']){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if($_SERVER['HTTP_X_FORWARDED_FOR']){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if($_SERVER['HTTP_X_FORWARDED']){
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		} else if($_SERVER['HTTP_FORWARDED_FOR']){
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if($_SERVER['HTTP_FORWARDED']){
			$ip = $_SERVER['HTTP_FORWARDED'];
		} else */if($_SERVER['REMOTE_ADDR']){
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = 'UNKNOWN';
		}
		return $ip;
	}

	//Find user Geolocation from ip address
	public function geoCheckIP($ip){
		//check, if the provided ip is valid
		if(!filter_var($ip, FILTER_VALIDATE_IP)){
			throw new InvalidArgumentException("IP is not valid");
		}

		//contact ip-server
		$response=@file_get_contents('http://www.netip.de/search?query='.$ip);
		if (empty($response)){
			throw new InvalidArgumentException("Error contacting Geo-IP-Server");
		}

		//Array containing all regex-patterns necessary to extract ip-geoinfo from page
		$patterns=array();
		//$patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
		$patterns["country"] = '#Country: (.*?)&nbsp;#i';
		$patterns["state"] = '#State/Region: (.*?)<br#i';
		$patterns["town"] = '#City: (.*?)<br#i';

		//Array where results will be stored
		$ipInfo=array();

		//check response from ipserver for above patterns
		foreach ($patterns as $key => $pattern){
			//store the result in array
			$ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
		}
		return http_build_query($ipInfo, '', ', ');//gives key1=value1, key2=another+value //replaces space with +
		//return implode(", ",$ipInfo);
		//return $ipInfo;
		}
}

?>