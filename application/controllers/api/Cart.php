<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Cart extends REST_Controller {
    
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Cart_model');
    }
    public function index_get()
	{
		echo "Product....";
	}
    public function addtocart_post()
    {
        echo "heelo";
        die();
    }
    Public function getallcart_get() 
    {
        try
        {
            $CartData = $this->Cart_model->getallcart();
            if(!empty($CartData))
            {
                $response = array("status" => 1,
                                    "message"  => "Cart data sent successfully",
                                    "data" => $CartData);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else 
            {
                $response = array("status"=>0,
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
    public function getcart_get()
    {
        try
        {
            $CartId = $this->input->get('id');
            $CartData = $this->Cart_model->getcart($CartId);
            if(!empty($CartData))
            {
                $response = array("status" => 1,
                                    "message"=>"Cart data sent successfully",
                                    "data"=>$CartData);
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
    public function deletecart_delete()
    {
        try
        {
            $CartId = $this->input->get('id');
            $Cart_Deleted = $this->Cart_model->deletecart($CartId);
            if(intval($Cart_Deleted) == 1) 
            {
                $response = array("status"=>1,
                                    "message"=>"Cart data deleted successfully",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else if(intval($Cart_Deleted) == 2)
            {
                $response = array("status"=>0,
                                    "message"=>"You can not delete Cart which is in use",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else 
            {
                $response = array("status"=>0, 
                                    "message"=>"Something went wrong while deleting Cart data",
                                    "data"=>null);
                $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        catch (Exception $e) 
        { 
            throw new Exception($e->getMessage());
        }
    }
}