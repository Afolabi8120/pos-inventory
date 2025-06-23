<?php 
    require('core/init.php');

    if(isset($_SESSION['admin']) AND !empty($_SESSION['admin'])){
        $user_id = $_SESSION['admin'];
        $getAdmin = $admin->fetchSingle('tbluser','user_id',$user_id);
    }else{
        header('location: login');
    }

    $message = "";
    $item_total = 0;

    if(isset($_POST['paytype']) && isset($_POST['amount_paid']) && isset($_POST['subtotal'])){

        $paytype = $_POST['paytype'];
        $amount_paid = $_POST['amount_paid'];
        $subtotal = $_POST['subtotal'];
        $change = $_POST['amount_paid'] - $_POST['subtotal'];

        if(empty($paytype) || empty($subtotal) || $subtotal == "0.00" || $amount_paid == "0.00"){
            $message = "Select payment method";
            return;
        }

        if($amount_paid < $subtotal) {
            $success = false;
            $message = "lease enter a valid amount.";
            return;
        }

        $invoiceno = $order->generateTransactionID();

        $allItemsAdded = true;

        foreach ($_SESSION["cart_item"] as $item) {

            $item_total += ($item["price"] * $item["quantity"]);

            if ($order->addToCart($invoiceno, $user_id, $item["product_id"], $item["quantity"], $item["price"])) {
                $allItemsAdded = true;
            }else if (!$order->addToCart($invoiceno, $user_id, $item["product_id"], $item["quantity"], $item["price"])) {
                $allItemsAdded = false;
                break;
            }
        }

        if ($allItemsAdded) {
            // Add payment info once
            if ($order->addPayment($invoiceno, $subtotal, $paytype, "1", $amount_paid, $change)) {
                // Commit transaction
                $message = "Order placed successfully";
                $success = true;
            } else {
                // Rollback transaction
                $message = "Failed to add order payment";
                $success = false;
            }
        } else {
            // Rollback transaction
            $message = "Failed to add items to cart";
            $success = false;
        }

    }

    // Unset session variables
    unset($_SESSION["cart_item"]);
    unset($_SESSION["total_price"]);

    $response = [
        'success' => $success,
        'message' => $message,
        'invoiceno' => $invoiceno
    ];

    echo json_encode($response);
    exit();
    
?>

