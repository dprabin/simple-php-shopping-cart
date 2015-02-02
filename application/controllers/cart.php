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
					'transaction_id' => 0, //later on change to paypal transaction id or auto increment or some code with time
					'qty'      => $this->input->post('item_qty')[$key],
					'price'    => $subtotal,
					'address'  => $this->input->post('address'),
					'address2' => $this->input->post('address2'),
					'phone'    => $this->input->post('phone'),
					'city'     => $this->input->post('city'),
					'state'    => $this->input->post('state'));// also add geolocation and user ip in this table

				//Add order data to database 
				if ($this->Cart_model->add_order($order_data)){
					//Remove ordered item from cart
					//$data=array($key=>$value);
					//$this->cart->update($data);
				}

			}

			//Get grand total
			$this->grand_total = $this->total + $this->tax + $this->shipping;

			//Paypal checkout code here
			//Create array of costs
			$paypal_product['assets'] = array(
				'tax_total' 	=> $this->tax,
				'shipping_cost'	=> $this->shipping,
				'grand_total' 	=> $this->total );

			//Session array for later
			$_SESSION['paypal_products'] = $paypal_product;

			//Send params to paypal
			$padata = '&METHOD=SetExpressCheckout'.
					'&RETURNURL='.urlencode($this->config->item('paypal_return_url')).
					'&CANCELURL='.urlencode($this->config->item('paypal_cancel_url')).
					'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
					$this->paypal_data.
					'&NOSHIPPING=0'.
					'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this->total).
					'&PAYMENTREQUEST_0_TAXAMT='.urlencode($this->tax).
					'&PAYMENTREQUEST_0_SHIPPINGAMP='.urlencode($this->shipping).
					'&PAYMENTREQUEST_0_AMT='.urlencode($this->grand_total).
					'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->config->item('paypal_currency_code')).
					'&LOCALECODE=GB'.//match paypal site language with the website language
					//'&LOGOIMG=http://sastoramro.com.np/logo.png'.//custom logo
					'&CARTBORDERCOLOR=FFFFFF'.
					'&ALLOWNOTE=1';

				//SetExpressCheckout
				$httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout',$pdata,$this->config->item('paypal_api_username'),$this->config->item('paypal_api_password'),$this->config->item('paypal_api_signature'),$this->config->item('paypal_api_endpoint'))
				if("SUCCESS" == strtoupper($httpParsedResponseAr['ACK']) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
					//Redirect user to paypal to store with token received
					$paypal_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='$httpParsedResponseAr;
					header('Location: '.$paypal_url);
				} else {
					//show error message
					print_r($httpParsedResponseAr);
					die(urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]));
				}


			//update last_active
			$this->User_model->update_last_active();

			//Redirect to products at last with message
			$this->session->set_flashdata('action_successful','You have successfully ordered items in cart. We will contact you soon');
			redirect('products');
		}
	}
}

?>