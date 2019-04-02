<?php
    include 'Model.php';

    class ProductModel extends Model
    {
        function __construct()
        {
            parent::__construct();
        }

        function insetProduct($barcode, $name, $price, $cost = 0)
        {
            $sql = "INSERT INTO `product` (`barcode`, `name`, `price`, `cost`) 
                    VALUES ('{$barcode}', '{$name}', '{$price}', '{$cost}') ";

            if(mysqli_query($this->conn, $sql) == false)
            {
                return "false";
            }
            else
            {
                return "true";
            }
        }

        function searchBarcode($barcode)
        {
           $sql = "SELECT `name` FROM `product` WHERE `barcode` = $barcode";
           $result = mysqli_query($this->conn, $sql);
           if($result == false)
            {
                return "false";
            }
            else
            {
                if(mysqli_num_rows($result) > 0) {
                    return("have");
                } else {
                    return("no");
                }
                //return "true";
            }

        }

        
        // -- function สำหรับค้นหาข้อมูลสินค้า
        function searchProduct($barcode) 
        {
            $name;
            $price;
            $cost;

            $sql = "SELECT * FROM `product` WHERE `barcode` = $barcode";
            $result = mysqli_query($this->conn, $sql);

            // ถ้าไม่พบข้อมูล
            if($result == false)
            {
                return "null";
            }
            // ถ้าพบข้อมูล
            else {
                if(mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $name = $row['name'];
                        $price = $row['price'];
                        $cost = $row['cost'];
                    }

                    $arr = array("name" => $name, "price" => $price, "cost" => $cost);
                    return $arr;
                    
                } else 
                {
                    return "null";
                }
            }
        }

        //-- funciotn สำหรับ แก้ไขข้อมูลสินค้า
        function updateProduct($barcode, $name, $price, $cost) 
        {
            $sql = "UPDATE `product` 
                    SET `barcode` = '{$barcode}', `name` = '{$name}', `price` = '{$price}', `cost` = '{$cost}' 
                    WHERE `product`.`barcode` = '{$barcode}' ";
            
            $result = mysqli_query($this->conn, $sql);

            if($result)
            {
                return "true";
            }
            else
            {
                return "false";
            }
        }

        

   
   
    }

?>