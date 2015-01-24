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
}

?>