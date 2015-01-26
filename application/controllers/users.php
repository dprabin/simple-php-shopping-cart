<?php
class Users extends CI_Controller{

	//Users index
	public function index(){
		if ($this->session->userdata('logged_in')){
			//Load current user data
			$data['user'] = $this->User_model->get_user_details($this->session->userdata('user_id'));

			//Validation Rules
			$this->form_validation->set_rules('old_password','Current Password', 'trim|required');

			$password = md5($this->input->post('old_password'));
			$valid_password = $this->User_model->check_password($password);

			//If password confirm, then proceed other form validation
			if($valid_password){
				$this->form_validation->set_rules('password','New Password', 'trim|required|max_length[50]|min_length[4]');
				$this->form_validation->set_rules('password2','Confirm new Password', 'trim|required|matches[password]');

				$this->form_validation->set_rules('address','Address: Locality, Street, House number', 'trim|required|min_length[5]');
				$this->form_validation->set_rules('address2','Address2: Directions and Placemarks', 'trim|required|min_length[4]');
				$this->form_validation->set_rules('phone','Phone Number', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('city','Your City', 'trim|required|min_length[3]');
				$this->form_validation->set_rules('state','Your country or state', 'trim|required|min_length[4]');

				if($this->form_validation->run() == FALSE){
					$data['main_content'] = 'user';
					$this->load->view('layouts/main', $data);
				} else {
					if($this->User_model->update()){
						$this->session->set_flashdata('registered','Your record is updated');
						redirect('products');
					}
				}
			} else {
				//redirect with error message
				$this->session->set_flashdata('invalid_login','Your current password is invalid');
				$data['main_content'] = 'user';
				$this->load->view('layouts/main', $data);
			}
		} else {
			$this->session->set_flashdata('registered','You need to login');
			redirect('products');
		}

	}

	//Register New user
	public function register(){
		//Validation Rules
		$this->form_validation->set_rules('first_name','First Name', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('last_name','Last Name', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('username','Username', 'trim|required|max_length[20]|min_length[3]');
		$this->form_validation->set_rules('password','Password', 'trim|required|max_length[50]|min_length[4]');
		$this->form_validation->set_rules('password2','Confirm Password', 'trim|required|matches[password]');

		$this->form_validation->set_rules('address','Address: Locality, Street, House number', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('address2','Address2: Directions and Placemarks', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('phone','Phone Number', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('city','Your City', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('state','Your country or state', 'trim|required|min_length[4]');

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
				'previllege' => $this->User_model->get_user_details($user_id)->previllege,
				'username' => $username,
				'logged_in' => true );

			//Set session data
			$this->session->set_userdata($data);

			//Set Flash message, that is stored in sessions and can be used in another controller or view
			$this->session->set_flashdata('pass_login','You are logged in');

			//Update last active
			$this->User_model->update_last_active();

			redirect('products');
		} else {
			//set error
			$this->session->set_flashdata('fail_login', 'Sorry, the login information was not correct');
			redirect('products');
		}
	}

	public function logout(){
		//Unset user data in sessions
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();

		//Update last active
		$this->User_model->update_last_active();

		redirect('products');
	}

}
?>