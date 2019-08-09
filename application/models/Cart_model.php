<?php
class Cart_model extends CI_Model
{
    public function getallcart()
    {
        $Cart = $this->db->query("SELECT * FROM cart");
        $CartData = $Cart->result_array();
        $CartDataAry = array();
        if(!empty($CartData))
        {
            foreach ($CartData as $row)
            {
                $row["id"] = intval($row["id"]);
                $row["productid"] = intval($row["productid"]);
                $row["price"] = ($row["price"]);
                $row["quantity"] = ($row["quantity"]);
                $row["sub_total"] = ($row["sub_total"]);
                $CartDataAry[] = $row;
            }
        }
        return $CartDataAry;
    }
    public function getcart($CartId)
    {
        $Cart= $this->db->query("SELECT * FROM cart WHERE id =".intval($CartId));
        $CartData = $Cart->row();
        if(!empty($CartData))
        {
            $CartData->id = intval($CartData->id);
            $CartData->productid = ($CartData->productid);
            $CartData->price = ($CartData->price);
            $CartData->quantity = ($CartData->quantity);
            $CartData->sub_total = ($CartData->sub_total);
        }
        return $CartData;
    }
    public function deleteCart($CartId)
    {
        $Cart_updated = 0; 
       
        // $count = $this->checkForCartId($CartId);
        // if(intval($count) > 0)
        // {
            $CDeleted = $this->db->query("DELETE FROM cart WHERE id=".intval($CartId));
                                            
            if($CDeleted == TRUE)
            {
                $Cart_updated = 1; 
            }
        // }
        return $Cart_updated;
    }
}
