<?php 
class Products extends CI_Controller{
    public function index(){
    	//Get All Products
    	$data['products'] = $this->Product_model->get_products();


    	//Load View
        //Define the main content area as products view (product.php)
        $data['main_content'] = 'products';
        //load product view
        $this->load->view('layouts/main',$data);
    }

    public function details($id){
    	//Get Product Details
    	$data['product'] = $this->Product_model->get_product_details($id);

    	//Define the main content as details view
        $data['main_content'] = 'details';
        //load product view
        $this->load->view('layouts/main',$data);
    }
}

?>