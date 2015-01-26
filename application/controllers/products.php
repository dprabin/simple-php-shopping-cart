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

    //Display the detail information of a product
    public function details($id){
    	//Get Product Details
    	$data['product'] = $this->Product_model->get_product_details($id);

    	//Define the main content as details view
        $data['main_content'] = 'details';
        //load product view
        $this->load->view('layouts/main',$data);
    }

    //Add a product to the system
    public function add(){
        //Get All Products
        $data['products'] = $this->Product_model->get_products();
        //Load View
        //Define the main content area as products view (product.php)
        $data['main_content'] = 'products';
        //load product view
        $this->load->view('layouts/main',$data);
    }

    //Display the detail information of a product
    public function edit($id){
        //If logged in as administrator, edit product 
        //otherwise redirect to details/id
        if ($this->session->userdata('previllege')=='admin'){
            $data['product'] = $this->Product_model->get_product_details($id);
            if($this->session->userdata('previllege')=='admin'){
                $data['main_content'] = 'edit';
                $this->load->view('layouts/main',$data);
            } else {
                redirect('products');
            }
        } else {
            $this->session->set_flashdata('action_successful','You do not have previllege to Edit products');
            redirect('products');
        }
    }

    //Category viewer
    public function category($id){
        //Get details
        $data['category_items'] = $this->Product_model->get_category_items($id);

        //Send data to view
        $data['main_content'] = 'category';
        $this->load->view('layouts/main',$data);
    }
}

?>