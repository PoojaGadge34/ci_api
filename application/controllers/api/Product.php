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
        try
        {
            $data = json_decode(file_get_contents('php://input'), TRUE);
    
           

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
        try
        {
            $data = json_decode(file_get_contents('php://input'), TRUE);

            $Product_Updated = $this->Product_model->updateproduct($data);
            if($Product_Updated)
            {
                $response = array(
                    "statuscode" => 1,
                    "message"  => "Doctor data updated successfully",
                    "data" => $data
                );
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else
            {
                $response = array(
                    "statuscode" => 0, 
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
    
}