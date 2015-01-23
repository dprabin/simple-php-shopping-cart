<?php
class Users extends CI_Controller{
	public function register(){
		//Validation Rules
		$this->form_validation->set_rules('first_name','First Name', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('last_name','Last Name', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('username','Username', 'trim|required|max_length[20]|min_length[3]');
		$this->form_validation->set_rules('password','Password', 'trim|required|max_length[50]|min_length[4]');
		$this->form_validation->set_rules('password2','Confirm Password', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE){
			$data['main_content'] = 'register';
			$this->load->view('layouts/main',$data);
		} else {
			if($this->User_model->register()){
				$this->session->set_flashdata('registered','You are now registered and can login');//flashdata in ci can be used in new view also
				redirect('products');
			}
		}
	}

	//Login user 
	public function login(){
		//Form Validation
		$this->form_validation->set_rules('username','Username', 'trim|required|max_length[20]|min_length[3]');
		$this->form_validation->set_rules('password','Password', 'trim|required|max_length[50]|min_length[4]');
	

		$username = $this->input->post('username'); //$_POST['username'];
		$password = md5($this->input->post('password'));

		$user_id = $this->User_model->login($username,$password);

		//Validate User
		if($user_id){
			//Create array of user data
			$data = array(
				'user_id' => $user_id,
				'username' => $username,
				'logged_in' => true );

			//Set session data
			$this->session->set_userdata($data);

			//Set Flash message, that is stored in sessions and can be used in another controller or view
			$this->session->set_flashdata('pass_login','You are logged in');
			redirect('products');
		} else {
			//set error
			$this->session->set_flashdata('fail_login', 'Sorry, the login information was not correct');
			redirect('products');
		}
	}


}
?>