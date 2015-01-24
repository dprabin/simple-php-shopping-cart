<?php
class Cart extends CI_Controller{
	
	public $paypal_data = '';
	public $tax;
	public $shippint;
	public $total = 0;
	public $grand_total;

	//Cart index
	public function index(){
		$data['user'] = $this->User_model->get_user_details($this->session->userdata('id'));
		//Load View
		$data['main_content'] = 'cart';
		$this->load->view('layouts/main', $data);
	}

	//Add to cart
	public function add(){
		//Items Data
		$data = array(
			'id'=> $this->input->post('item_number'),
			'qty' =>$this->input->post('qty'),
			'price'=> $this->input->post('price'),
			'name'=> $this->input->post('title'));

		//to support unicode title as suggested in stackoverflow
		$this->cart->product_name_rules = '\d\D';
		//Insert into cart
		$this->cart->insert($data);
		//print_r($data);
		redirect('products');
	}

	//Update cart
	public function update($in_cart=null){
		$data = $_POST;
		$this->cart->update($data);

		//Show cart page
		redirect('cart','refresh');
	}

	//Process a cart
	public function process(){
		//Items Data
		$data = array(
			'address'=> $this->input->post('address'),
			'address2' =>$this->input->post('address2'),
			'price'=> $this->input->post('price'),
			'phone'=> $this->input->post('phone'),
			'city'=> $this->input->post('city'),
			'state'=> $this->input->post('state'));

		//Insert into orders
		//$this->orders->insert($data);
		//print_r($data);
		redirect('products');
	}
}

?>