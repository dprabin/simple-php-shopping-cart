<?php
class Cart extends CI_Controller{
	
	public $paypal_data = '';
	public $tax;
	public $shipping;
	public $total =0;
	public $grand_total;

	/*function __construct() {
		//Get Tax and Shipping cost from config
		//$this->config->load('config');
		$this->tax = config_item('tax'); //$this->config->item('tax');
		$this->shipping = config_item('shipping'); //$this->config->item('shipping');
	}*/

	//Cart index
	public function index(){
		$data['user'] = $this->User_model->get_user_details($this->session->userdata('user_id'));
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
		//moved this to constructor
		$this->tax = $this->config->item('tax');
		$this->shipping = $this->config->item('shipping');

		if($_POST) {
			foreach ($this->input->post('item_name') as $key => $value) {
				$item_id = $this->input->post('item_code')[$key];
				$product = $this->Product_model->get_product_details($item_id);

				//Paypal data
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($product->title);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item_id);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($product->price);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($this->input->post('item_qty')[$key]);

				//Price x quantity
				$subtotal = ($product->price * $this->input->post('item_qty')[$key]);
				$this->total = $this->total + $subtotal;

				$paypal_product['items'][] = array(
					'itm_name' => $product->title,
					'itm_price' => $product->price,
					'itm_code' => $item_id,
					'itm_qty' => $this->input->post('item_qty')[$key]);
	
				//Order Data
				$order_data = array(
					'product_id' => $item_id,
					'user_id' => $this->session->userdata('user_id'),
					'transaction_id' => 0,
					'qty'      => $this->input->post('item_qty')[$key],
					'price'    => $subtotal,
					'address'  => $this->input->post('address'),
					'address2' => $this->input->post('address2'),
					'phone'    => $this->input->post('phone'),
					'city'     => $this->input->post('city'),
					'state'    => $this->input->post('state'));

				//Add order data to database 
				$this->Cart_model->add_order($order_data);
			}
			//update last_active
			$this->User_model->update_last_active();

			//Paypal checkout code here
		}
	}
}

?>