<?php 
class User_model extends CI_Model{
	public function register(){
		$data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
			);
		$insert = $this->db->insert('users',$data);
		return $insert;
	}
}

?>