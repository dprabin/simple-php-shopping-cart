<?php 
class User_model extends CI_Model{
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

	//Update last active in users table on login
	public function update_last_active(){
		//$this->db->update('last_active',date("Y-m-d H:i:s"));
		//$this->db->where('id',$result->row(0)->id);
		return false;
	}

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

	//Find user Geolocation
}

?>