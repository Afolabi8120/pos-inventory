<?php
    include('core/init.php');

    if(isset($_POST['btnPlaceOrder']) && !empty($_POST['btnPlaceOrder'])){

        $user_id = $_SESSION['admin'];
        $item_total = 0;
        
        $paytype = $_POST['paytype'];
        $subtotal = $_POST['subtotal'];
        $total = $_POST['total'];
        $amount_paid = $_POST['amount_paid'];
        $change = $_POST['change'];

        if(empty($paytype) || empty($subtotal) || empty($total) || empty($amount_paid) || empty($change) || $subtotal == "0.00" || $total == "0.00"){
            return;
        }

        $invoiceno = $order->generateTransactionID();

        foreach ($_SESSION["cart_item"] as $item)
        {
            $item_total += ($item["price"]*$item["quantity"]);
            if($order->addToCart($invoiceno,$user_id,$item["product_id"],$item["quantity"],$item["price"]) === true){
                if($order->addPayment($invoiceno,$subtotal,$paytype,"1",$amount_paid,$change) === true){
                    $_SESSION['messageTitle'] = "Success";
                    $_SESSION['messageText'] = "Order placed successfully";
                    $_SESSION['messageIcon'] = "success";
                    $message = "Order placed successfully";
                    //header("refresh:1;url=receipt?receiptno=$invoiceno");
                }else{
                    $_SESSION['messageTitle'] = "Alert";
                    $_SESSION['messageText'] = "Failed to add order payment";
                    $_SESSION['messageIcon'] = "error";
                    $message = "Failed to add order payment";
                }
            }else{
                $_SESSION['messageTitle'] = "Alert";
                $_SESSION['messageText'] = "Failed to add items to cart";
                $_SESSION['messageIcon'] = "error";
            }

            unset($_SESSION["cart_item"]);
            unset($_SESSION["total_price"]);
            unset($item["product_id"]);
            unset($item["quantity"]);
            unset($item["price"]);
        }

    }

    # change user password
    if(isset($_POST['btnChangeProfilePassword']) && !empty($_POST['btnChangeProfilePassword'])){ 

        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $old_password = $_POST['old_password'];

        // Form Validation 
        if(empty($user_id) || empty($password) || empty($cpassword) || empty($old_password)){
            $_SESSION['messageTitle'] = "Empty Field";
            $_SESSION['messageText'] = "All input fields are required";
            $_SESSION['messageIcon'] = "error";
        }elseif(strlen($password) < 5){
            $_SESSION['messageTitle'] = "Empty Field";
            $_SESSION['messageText'] = "Password length must be up to or more than 5 characters";
            $_SESSION['messageIcon'] = "error";
        }elseif ($password !== $cpassword){
            $_SESSION['messageTitle'] = "Alert";
            $_SESSION['messageText'] = "Both password do not match";
            $_SESSION['messageIcon'] = "error";
        }else{

            $getAdmin = $admin->fetchSingle('tbluser','user_id',$user_id);

            $user_id = $getAdmin->user_id;
            $password = $admin->validateInput($password);
            $cpassword = $admin->validateInput($cpassword);
            $old_password = $admin->validateInput($old_password);

            if(password_verify($old_password, $getAdmin->password)){

                // Hashing the password provided by the user word
                $newpassword = password_hash($password, PASSWORD_DEFAULT);
                
                if($user->changeUserPassword($user_id,$newpassword) === true){
                    $_SESSION['messageTitle'] =  "Success";
                    $_SESSION['messageText'] = "Password changed Successfully";
                    $_SESSION['messageIcon'] = "success";
                }else{
                    $_SESSION['messageTitle'] =  "Update Failed";
                    $_SESSION['messageText'] = "Unable to change your password";
                    $_SESSION['messageIcon'] = "danger";
                }

            }else{
                $_SESSION['messageTitle'] =  "Failed";
                $_SESSION['messageText'] = "Old password provided is not correct";
                $_SESSION['messageIcon'] = "warning";
            }
        }

    }

    # update profile info
    if(isset($_POST['btnUpdateProfile']) && !empty($_POST['btnUpdateProfile'])){ 

        $user_id = strtolower($admin->validateInput($_POST['user_id']));
        $username = strtolower($admin->validateInput($_POST['username']));
        $fullname = strtolower($admin->validateInput($_POST['fullname']));
        $email = strtolower($admin->validateInput($_POST['email']));
        $phone = $admin->validateInput($_POST['phone']);

        // Form Validation 
        if(empty($user_id) || empty($username) || empty($fullname) || empty($email) || empty($phone)){
            $_SESSION['messageTitle'] = "Empty Field";
            $_SESSION['messageText'] = "All input fields are required";
            $_SESSION['messageIcon'] = "error";
        }elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $_SESSION['messageTitle'] = "Alert";
            $_SESSION['messageText'] = "Only alphabet and numbers allowed for username";
            $_SESSION['messageIcon'] = "error";
        }else{

            $getAdmin = $admin->fetchSingle('tbluser','user_id',$user_id);

            $user_id = $getAdmin->user_id;

            if($user->editUser($user_id,$username,$fullname,$email,$phone,$getAdmin->usertype) === true){
                $_SESSION['messageTitle'] = "Success";
                $_SESSION['messageText'] = "User account updated successfully";
                $_SESSION['messageIcon'] = "success";
            }else{
                $_SESSION['messageTitle'] = "Alert";
                $_SESSION['messageText'] = "Failed to update user account";
                $_SESSION['messageIcon'] = "error";
            }
        }

    }

?>