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
    public function details($id=null){
        if(!empty($id)){
        	//Get Product Details
        	$data['product'] = $this->Product_model->get_product_details($id);
        	//Define the main content as details view
            $data['main_content'] = 'details';
            //load product view
            $this->load->view('layouts/main',$data);
        } else {
            $this->session->set_flashdata('action_unsuccessful','You didnt supply the product id');
            redirect('products');
        }
    }

    //Display the detail information of a product
    //it may be safer to move delete, add, and edit method to admin controller
    public function edit($id=null){
        if(!empty($id)){
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
        } else {
            $this->session->set_flashdata('action_unsuccessful','You cannot edit that item');
            redirect('products');
        }
    }

    //Add a new product
    //it may be safer to move delete, add, and edit method to admin controller
    public function add(){
        if ($this->session->userdata('previllege')=='admin'){
            //Validate data
            $this->form_validation->set_rules('title','Product Title', 'trim|required|max_length[200]|min_length[3]|is_unique[products.title]');
            $this->form_validation->set_rules('category_id','Product Category', 'trim|required');
            $this->form_validation->set_rules('description','Product Description', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('nutritional_value','Nutritional Value', 'trim');
            //$this->form_validation->set_rules('userfile','Product Image', 'trim|required|max_length[200]|min_length[5]|is_unique[products.image]');
            $this->form_validation->set_rules('price','Product Price', 'trim|required|max_length[7]|min_length[1]');
            $this->form_validation->set_rules('unit','Unit of product', 'trim|required|max_length[25]|min_length[1]');

            if($this->form_validation->run() == FALSE){
                $data['main_content'] = 'add';
                $this->load->view('layouts/main',$data);
            } else {
                    //First Upload the file and get filename
                    $config=array(
                        'upload_path' => dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/images/products/',
                        'upload_url' => base_url().'assets/images/products/',
                        'remove_spaces' => TRUE,
                        'allowed_types' => 'gif|jpg|png|jpeg',
                        'overwrite' => TRUE,
                        'max_size' => '2048',
                        'max_width'  => '1024',
                        'max_height'  => '768');
 
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload() && $this->Product_model->add_product()){
                        $this->session->set_flashdata('action_successful','The product '.$this->input->post('title').' is added');
                        redirect('products/details/'.$this->db->insert_id());
                    } else {
                            $this->session->set_flashdata('action_unsuccessful','The product '.$this->input->post('title').' is not added');
                            redirect('products');
                    }
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','You do not have previllege to add new product');
            redirect('products');
        }
    }

    //Remove Product form database
    //it may be safer to move delete, add, and edit method to admin controller
    public function delete($id=null){
        if(!empty($id)){
            if ($this->session->userdata('previllege')=='admin'){
                //Confirm before removing product in javascript
                $this->Product_model->delete_product($id);
                $this->session->set_flashdata('action_successful','The product is successfully deleted');
                redirect('admin/all_products');
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','Please supply the product id');
        }
        redirect('products');
    }

    //Category viewer
    public function category($id=null){
         if(!empty($id)){
            $data['category_items'] = $this->Product_model->get_category_items($id);
            $data['main_content'] = 'category';
            $this->load->view('layouts/main',$data);
        } else {
            $this->session->set_flashdata('action_unsuccessful','You didnt supply the category id');
            redirect('products');
        }
    }
}

?>