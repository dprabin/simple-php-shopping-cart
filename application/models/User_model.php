<?php 
class User_model extends CI_Model{
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
			'last_logon_ip' => find_user_ip(),
			//'geolocation' => $this->input->post('geolocation'),
			'last_active' => date("Y-m-d H:i:s")
			);

		$insert = $this->db->insert('users',$data);
		return $insert;
	}

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

	//Update last active time and ip in users table on login
	public function update_last_active(){
		//$this->db->update('last_active',date("Y-m-d H:i:s"));
		//$this->db->where('id',$result->row(0)->id);
		return false;
	}

	//I think these should be in different model

	//Find ip address of User
	public function find_user_ip(){
		if ($_SERVER['HTTP_CLIENT_IP']){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if($_SERVER['HTTP_X_FORWARDED_FOR']){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if($_SERVER['HTTP_X_FORWARDED']){
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		} else if($_SERVER['HTTP_FORWARDED_FOR']){
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if($_SERVER['HTTP_FORWARDED']){
			$ip = $_SERVER['HTTP_FORWARDED'];
		} else if($_SERVER['REMOTE_ADDR']){
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

		return $ipInfo;
		}
}

?>