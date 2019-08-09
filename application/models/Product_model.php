<?php
class Product_model extends CI_Model
{
    public function addproduct($ProductName, $ProductDescription, $ProductPrice, $ProductQuantity)
    {
        $this->db->query("INSERT INTO product (name,description,price,quantity,status) 
                            VALUES ('".$ProductName."','".$ProductDescription."','".$ProductPrice."','".$ProductQuantity."',1)
                            ");
        return $this->db->insert_id();
    }
    public function updateproduct($data)
    {
        
            $this->db->where('id', intval($data['id']));
            $sql = $this->db->update('product',$data);
            
       
    }
    public function deleteproduct($ProductId)
    {
        $Product_updated = 0; 
       
        // $count = $this->checkForProductId($ProductId);
       
            $PDeleted = $this->db->query("DELETE FROM product WHERE id=".intval($ProductId));
                                            
            if($PDeleted == TRUE)
            {
                $Product_updated = 1; 
            }
        // }
        return $Product_updated;
    }
    public function checkForProductExist($ProductName)
    {
        $Product = $this->db->query("SELECT name FROM product WHERE Name='".trim($ProductName)."' ");
        return $Product->num_rows();    
    }
    public function getproduct($ProductId)
    {
        $Product= $this->db->query("SELECT * FROM product WHERE id =".intval($ProductId));
        $ProductData = $Product->row();
        if(!empty($ProductData))
        {
            $ProductData->id = intval($ProductData->id);
            $ProductData->name = ($ProductData->name);
            $ProductData->description = ($ProductData->description);
            $ProductData->price = ($ProductData->price);
            $ProductData->quantity = ($ProductData->quantity);
        }
        return $ProductData;
    }
    public function getallproduct()
    {
        $Product = $this->db->query("SELECT * FROM product");
        $ProductData = $Product->result_array();
        $ProductDataAry = array();
        if(!empty($ProductData))
        {
            foreach ($ProductData as $row)
            {
                $row["id"] = intval($row["id"]);
                $row["name"] = ($row["name"]);
                $row["description"] = ($row["description"]);
                $row["price"] = ($row["price"]);
                $row["quantity"] = ($row["quantity"]);
                $ProductDataAry[] = $row;
            }
        }
        return $ProductDataAry;
    }
    public function addtocart($ProductId)
    {
        $this->db->query("INSERT INTO cart (productid,price,quantity) VALUES ($ProductId,$Productprice, $ProductQuantity) ");
        return $this->db->insert_id();
    }

}
