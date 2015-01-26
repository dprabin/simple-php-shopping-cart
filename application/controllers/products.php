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

    //Display the detail information of a product
    public function edit($id){
        //If logged in as administrator, edit product 
        //otherwise redirect to details/id
        if ($this->session->userdata('previllege')=='admin'){
            $data['product'] = $this->Product_model->get_product_details($id);
            if($data['product'] || $_POST){
                if($_POST){
                    //Validate data
                    $this->form_validation->set_rules('title','Username', 'trim|required|max_length[200]|min_length[3]');
                    $this->form_validation->set_rules('category_id','Category', 'trim|required');
                    $this->form_validation->set_rules('description','Product Description', 'trim|required|min_length[10]');
                    $this->form_validation->set_rules('nutritional_value','Nutritional Value', 'trim');
                    $this->form_validation->set_rules('image','Product Image', 'trim|required|max_length[200]|min_length[5]');
                    $this->form_validation->set_rules('price','Product Price', 'trim|required|max_length[7]|min_length[1]');
                    $this->form_validation->set_rules('unit','Unit of product', 'trim|required|max_length[25]|min_length[1]');
                    //Read the product details
                    $data['product'] = $this->Product_model->get_product_details($this->input->post('product_id'));
                    if($this->form_validation->run() == FALSE){
                        $data['main_content'] = 'edit';
                        $this->load->view('layouts/main',$data);
                    } else {
                        //Update product
                        if($this->Product_model->update()){
                            $this->session->set_flashdata('action_successful','The product '.$this->input->post('title').' is updated');
                            redirect('products');
                        } else {
                            $this->session->set_flashdata('action_unsuccessful','The product '.$this->input->post('title').' is not updated');
                            redirect('products');
                        }
                    }
                } else {
                    $data['main_content'] = 'edit';
                    $this->load->view('layouts/main',$data);
                }
            } else {
                $this->session->set_flashdata('action_unsuccessful','The product you are trying to edit does not exist');
                redirect('products');
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','You do not have previllege to Edit products');
            redirect('products');
        }
    }

    //Add a new product
    public function add(){
        if ($this->session->userdata('previllege')=='admin'){
            //Validate data
            $this->form_validation->set_rules('title','Username', 'trim|required|max_length[200]|min_length[3]');
            $this->form_validation->set_rules('category_id','Category', 'trim|required');
            $this->form_validation->set_rules('description','Product Description', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('nutritional_value','Nutritional Value', 'trim');
            $this->form_validation->set_rules('image','Product Image', 'trim|required|max_length[200]|min_length[5]');
            $this->form_validation->set_rules('price','Product Price', 'trim|required|max_length[7]|min_length[1]');
            $this->form_validation->set_rules('unit','Unit of product', 'trim|required|max_length[25]|min_length[1]');

            if($this->form_validation->run() == FALSE){
                $data['main_content'] = 'add';
                $this->load->view('layouts/main',$data);
            } else {
                //Add new product
                if($this->Product_model->add_product()){
                    $this->session->set_flashdata('action_successful','The product '.$this->input->post('title').' is updated');
                    redirect('products');
                } else {
                    $this->session->set_flashdata('action_unsuccessful','The product '.$this->input->post('title').' is not updated');
                    redirect('products');
                }
                redirect('users');
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','You do not have previllege to add new product');
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