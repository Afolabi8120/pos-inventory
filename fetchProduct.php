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

    # get all products
    if(!isset($_POST['category_id']) || $_POST['category_id'] == "all"){

        foreach ($product->fetchAllProduct() as $fetchProduct): 
            if($fetchProduct->quantity < 1) {
                $output .= '
                <div class="product-card fetch_product" style="pointer-events: none;opacity: 0.6;cursor: not-allowed;" onclick="addToCart(' . $fetchProduct->product_id . ')" id="cat_id" style="cursor: pointer;">
                    <img src="assets/product_image/' . $fetchProduct->product_image . '" alt="' .ucwords($fetchProduct->product_name) . '" class="product-image">
                    <div class="product-name">' . ucwords($fetchProduct->product_name) . '</div>
                    <div class="product-price">NGN' . number_format($fetchProduct->selling_price, 2) . '</div>
                    <span style="color: maroon;text-align:center;">Out of stock</span>
                </div>';
            }else{
                $output .= '
                <div class="product-card fetch_product" onclick="addToCart(' . $fetchProduct->product_id . ')" id="cat_id" style="cursor: pointer;">
                    <img src="assets/product_image/' . $fetchProduct->product_image . '" alt="' .ucwords($fetchProduct->product_name) . '" class="product-image">
                    <div class="product-name">' . ucwords($fetchProduct->product_name) . '</div>
                    <div class="product-price">NGN' . number_format($fetchProduct->selling_price, 2) . '</div>
                    <span class="badge bg-success mt-1">In stock: '. $fetchProduct->quantity .'</span>
                </div>';
            }

        endforeach;
    }elseif(isset($_POST['category_id'])) {
        $category_id = $_POST['category_id']; 
        foreach ($product->fetchAllProductUsingCatID($category_id) as $fetchProduct): 

            if($fetchProduct->quantity < 1) {
                $output .= '
                <div class="product-card fetch_product" style="pointer-events: none;opacity: 0.6;cursor: not-allowed;" onclick="addToCart(' . $fetchProduct->product_id . ')" id="cat_id" style="cursor: pointer;">
                    <img src="assets/product_image/' . $fetchProduct->product_image . '" alt="' .ucwords($fetchProduct->product_name) . '" class="product-image">
                    <div class="product-name">' . ucwords($fetchProduct->product_name) . '</div>
                    <div class="product-price">NGN' . number_format($fetchProduct->selling_price, 2) . '</div>
                    <span style="color: maroon;font-weight:bold;text-align:center;">Out of stock</span>
                </div>';
            }else{
                $output .= '
                <div class="product-card fetch_product" onclick="addToCart(' . $fetchProduct->product_id . ')" id="cat_id" style="cursor: pointer;">
                    <img src="assets/product_image/' . $fetchProduct->product_image . '" alt="' .ucwords($fetchProduct->product_name) . '" class="product-image">
                    <div class="product-name">' . ucwords($fetchProduct->product_name) . '</div>
                    <div class="product-price">NGN' . number_format($fetchProduct->selling_price, 2) . '</div>
                    <span class="badge bg-success mt-1">In stock: '. $fetchProduct->quantity .'</span>
                </div>';
            }
        endforeach;

        if(!$product->fetchAllProductUsingCatID($category_id)) {
            $output .= '
            <div class="col-md-12 fetch_product">
                <div class="row">
                    <div class="col-md-12">
                        <p style="text-align: center;font-size: 18px;">No items found for the selected category!</p>
                    </div>
                </div>
            </div>';
        }
    }

    $response = [
        'html' => $output   
    ];

    echo json_encode($response);
    exit();

?>