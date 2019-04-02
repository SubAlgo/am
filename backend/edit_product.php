<?php

    //คล้ายเป็น controller
    include './model/ProductModel.php';
   
    //----- SET VAR -----
    //set var barcode
    if(isset($_GET['barcode']))
    {
        $barcode = $_GET['barcode'];
    }

    //set var name
    if(isset($_GET['name']))
    {
        $name = $_GET['name'];
    }

    //set var price
    if(isset($_GET['price']))
    {
        $price = $_GET['price'];
    }

    //set var cost
    if(isset($_GET['cost']))
    {
        $cost = $_GET['cost'];
    }

    //set var func
    if(isset($_GET['func']))
    {
        $func = $_GET['func'];
    }
     //----- END SET VAR -----

   
    $pm = new ProductModel();


    if($func == "searchProduct")
    {
        $myData = $pm->searchProduct($barcode);
        if($myData == "null") {
            echo("null");
        } else {
            header('Content-type: application/json');
            echo json_encode($pm->searchProduct($barcode));
        }   
    }

    if($func == "updateProduct")
    {
        $msg = $pm->updateProduct($barcode, $name, $price, $cost);
        echo($msg);
    }

    
   
   
?>