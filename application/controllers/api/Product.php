<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Product extends REST_Controller {
    
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Product_model');
    }
    public function index_get()
	{
		echo "Product";
	}
    public function addproduct_post()
    {
        // echo "heelo";
        // die();
        try
        {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            // print_r($data);
            // die();
           

            if(trim($data['name']) != "")
            {
                $Product_Exist = $this->Product_model->checkForProductExist(0,$data['name']);
                if(intval($Product_Exist)>0)
                {
                    $responce = array("status" => 2,
                                        "message"=>"Product Exist",
                                        "data"=>null);
                    $this->response($responce,REST_Controller::HTTP_OK);
                }
                else
                {
                    $ProductId=$this->Product_model->addproduct($data['name'],$data['description'],$data['price'],$data['quantity']);
                    if(intval($ProductId) > 0)
                    {
                        $response = [
                            "status" => 1, 
                            "message"=>"Product data inserted successfully",
                            "data"=>$ProductId
                        ];
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $response = array("status" => 0,
                                            "message"=>"Error",
                                            "data"=>null);
                        $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
            else
            {
                $response = array("status" => 0,
                                    "message"=>"Product name required",
                                    "data"=>null);
                $this->response($response,REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
    }


    public function updateproduct_put()
    {
        // echo "heelo";
        // die();
        try
        {
            $data = json_decode(file_get_contents('php://input'), TRUE);

            $Product_Updated = $this->Product_model->updateproduct($data);
            if($Product_Updated)
            {
                $response = array(
                    "statuscode" => 1, //Success
                    "message"  => "Doctor data updated successfully",
                    "data" => $data
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else
            {
                $response = array(
                    "statuscode" => 0, //Failed
                    "message"  => "Something went wrong while updating doctor data",
                    "data" => $data
                );
                $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
            }          
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
        
    }
   
    public function deleteproduct_delete()
    {
        try
        {
            $ProductId = $this->input->get('id');
            $Product_Deleted = $this->Product_model->deleteproduct($ProductId);
            if(intval($Product_Deleted) == 1) 
            {
                $response = array("status"=>1,
                                    "message"=>"Product data deleted successfully",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else if(intval($Product_Deleted) == 2)
            {
                $response = array("status"=>0,
                                    "message"=>"You can not delete product which is in use",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else 
            {
                $response = array("status"=>0, 
                                    "message"=>"Something went wrong while deleting product data",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
    }
    public function getproduct_get()
    {
        try
        {
            $ProductId = $this->input->get('id');
            $ProductData = $this->Product_model->getproduct($ProductId);
            if(!empty($ProductData))
            {
                $response = array("status" => 1,
                                    "message"=>"Product data sent successfully",
                                    "data"=>$ProductData);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else 
            {
                $response = array("status"=>0,
                                    "message"=>"No data available",
                                    "data"=>null);
                $this->response($response,REST_Controller::HTTP_OK);
            }
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
    }
    Public function getallproduct_get() 
    {
        try
        {
            $ProductData = $this->Product_model->getallproduct();
            if(!empty($ProductData))
            {
                $response = array("statuscode" => 1,
                                    "message"  => "Product data sent successfully",
                                    "data" => $ProductData);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else 
            {
                $response = array("statuscode" => 0,
                                    "message"  => "No data available",
                                    "data" => null);
                $this->response($response,REST_Controller::HTTP_OK);
            }
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
    }
    public function addtocart_get()
    {
        // try
        // {
        //     $ProductId = $this->input->get('id');
        //     $ProductName = $this->input->get('name'); 
        //     $ProductDescription = $this->input->get('description'); 
        //     $Productprice = $this->input->get('price'); 
        //     $ProductQuantity = $this->input->get('quantity'); 

        //     $ProductData = $this->Product_model->addtocart($ProductId,$Productprice,$ProductQuantity);            

        //     if(!empty($ProductData))
        //     {
        //         $response = array("status" => 1,
        //                             "message"=>"Product data sent intpo cart successfully",
        //                             "data"=>$ProductData);
        //         $this->response($response, REST_Controller::HTTP_OK);
        //     }
        //     else 
        //     {
        //         $response = array("status"=>0,
        //                             "message"=>"No data available",
        //                             "data"=>null);
        //         $this->response($response,REST_Controller::HTTP_OK);
        //     }
        // }
        // catch (Exception $e) 
        // { 
        //     throw new Exception($e->getMessage());
        // }

        $product = $this->product->getrows('id');

        $data = array('id'=>$product['id'],
                      'quantity'=>1,
                      'price'=>$product['price'],
                       'name'=>$product['name']);

        $this->cart->insert($data);
        redirect('/controller/Cart');
    }
}