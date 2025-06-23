<?php
require('core/init.php');

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('location: login');
    exit();
}

$user_id = $_SESSION['admin'];
$getAdmin = $admin->fetchSingle('tbluser', 'user_id', $user_id);

$output = "";
$item_total = 0;
$i = 1;

if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $output .= '
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="badge badge-dark">'. $i++ .'</span>'

            . ucwords($item["product_name"]) . ' x ' . $item["quantity"] . '
                <span>' . $item["price"] . '</span>
                <a href="javascript:;"  title="Remove this Item" onclick="removeFromCart(' . $item["product_id"] . ')"><i class="fas fa-trash text-danger"></i></a>
            </li>
        ';
        $item_total += ($item["price"] * $item["quantity"]);
    }
} else {
    unset($_SESSION["cart_item"]);

    $output .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Nothing in Cart</span>
                </li>';
    $item_total = 0; 
}

$response = [
    'html' => $output,
    'total_price' => $item_total   
];

echo json_encode($response);
exit();

?>