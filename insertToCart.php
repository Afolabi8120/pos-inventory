<?php 
    require('core/init.php');

    if(isset($_SESSION['admin']) AND !empty($_SESSION['admin'])){
        $user_id = $_SESSION['admin'];
        $getAdmin = $admin->fetchSingle('tbluser','user_id',$user_id);
    }else{
        header('location: login');
    }

    # add to cart using product id
    if(isset($_POST['product_id'])){
        # product id
        $product_id = $_POST['product_id'];

        # getting the product details using its id
        $productDetails = $admin->fetchSingle('tblproduct','product_id',$product_id);

        # product quantity set to 1
        $quantity = 1;

        if($productDetails->quantity <= 0){
            $success = false;
            $message = ucwords($productDetails->product_name) . " is out of stock";
            return;
        }

        # pushing the product details into an array
        $itemArray = array($productDetails->product_id => array('product_name'=>$productDetails->product_name, 'product_id'=>$productDetails->product_id, 'quantity'=>$quantity, 'price'=>$productDetails->selling_price));

        if(!empty($_SESSION["cart_item"])) 
        {
            if(in_array($productDetails->product_id,array_keys($_SESSION["cart_item"]))) 
            {
                foreach($_SESSION["cart_item"] as $k => $v) 
                {
                    if($productDetails->product_id == $k) 
                    {
                        if(empty($_SESSION["cart_item"][$k]["quantity"])) 
                        {
                            $_SESSION["cart_item"][$k]["quantity"] = 0;
                        }
                        $_SESSION["cart_item"][$k]["quantity"] += $quantity;
                        $product->removeFromStock($productDetails->product_id,$quantity);
                    }
                }
            }
            else 
            {
                $product->removeFromStock($productDetails->product_id,$quantity);
                $_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
            }
        } 
        else 
        {
            $_SESSION["cart_item"] = $itemArray;
            $product->removeFromStock($productDetails->product_id,$quantity);
        }
    }

    # add to cart using barcode
    if(isset($_POST['barcode'])){
        # product id
        $barcode = $_POST['barcode'];

        # getting the product details using its id
        $productDetails = $admin->fetchSingle('tblproduct','barcode',$barcode);

        # product quantity set to 1
        $quantity = 1;

        if(!$productDetails){
            $success = false;
            $message = "Item not found";
            return;
        }

        if($productDetails->quantity <= 0){
            $success = false;
            $message = ucwords($productDetails->product_name) . " is out of stock";
            return;
        }

        # pushing the product details into an array
        $itemArray = array($productDetails->product_id => array('product_name'=>$productDetails->product_name, 'product_id'=>$productDetails->product_id, 'quantity'=>$quantity, 'price'=>$productDetails->selling_price));

        if(!empty($_SESSION["cart_item"])) 
        {
            if(in_array($productDetails->product_id,array_keys($_SESSION["cart_item"]))) 
            {
                foreach($_SESSION["cart_item"] as $k => $v) 
                {
                    if($productDetails->product_id == $k) 
                    {
                        if(empty($_SESSION["cart_item"][$k]["quantity"])) 
                        {
                            $_SESSION["cart_item"][$k]["quantity"] = 0;
                        }
                        $_SESSION["cart_item"][$k]["quantity"] += $quantity;
                        $product->removeFromStock($productDetails->product_id,$quantity);
                        $success = true;
                    }
                }
            }
            else 
            {
                $product->removeFromStock($productDetails->product_id,$quantity);
                $_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
                $success = true;
            }
        } 
        else 
        {
            $_SESSION["cart_item"] = $itemArray;
            $product->removeFromStock($productDetails->product_id,$quantity);
            $success = true;
        }
    }

    # remove from cart
    if(isset($_POST['r_product_id'])){
        # product id
        $productId = $_POST['r_product_id'];

        if(!empty($_SESSION["cart_item"]))
        {
            foreach($_SESSION["cart_item"] as $k => $v) 
            {
                if($productId == $v['product_id']){
                    unset($_SESSION["cart_item"][$k]);
                    $product->addToStock($productId,$v['quantity']);
                }
            }
        }
    }

    # remove all from cart
    if(isset($_POST['remove_all'])){

        if(!empty($_SESSION["cart_item"]))
        {
            foreach($_SESSION["cart_item"] as $k => $v) 
            {
                $product->addToStock($v['product_id'],$v['quantity']);
            }
        }

        $success = true;
        unset($_SESSION["cart_item"]);
    }

    # logout items
    if(isset($_POST['logout'])){
        if(isset($_SESSION['cart_item']) && count($_SESSION['cart_item']) > 0){

            foreach($_SESSION['cart_item'] as $k => $v) {
                $product->addToStock($v['product_id'],$v['quantity']);   
            }

            $success = true;
            $message = "Logout Successful";
            unset($_SESSION["cart_item"]);
        }
    }

    $response = [
        'success' => $success,
        'message' => $message,
    ];

    
    echo json_encode($response);
    exit();
    
?>

