<?php 

$pageTitle = "Point of Sale";
require('core/validate/order.php');
include('includes/head.php'); 

if(isset($_SESSION['admin']) AND !empty($_SESSION['admin'])){
  $user_id = $_SESSION['admin'];
  $getAdmin = $admin->fetchSingle('tbluser','user_id',$user_id);
  $getStoreData = $admin->fetch('tblsettings');

  if(!$getAdmin->usertype == 'u') {
    header('location: login');
  }
}else{
  header('location: login');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./assets/css/pos.css">
  <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <title><= $pageTitle; ?></title>
  </head>
  <body>
    <div class="pos-container">
      <!-- Products Section -->
      <div class="products-section">
        <div class="search-bar">
          <a href="receipt?receiptno=<?= $order->getLastTransactionID(); ?>" title="Last Transaction" type="button" class="btn btn-info rounded-circle ml-2"><i class="fa fa-receipt"></i></a>
          <a href="dashboard" type="button" class="btn btn-warning rounded-circle ml-2" data-toggle="modal" data-target="#salesModal" title="Sales History"><i class="fa fa-folder-open"></i> </a>
          <a href="dashboard" type="button" class="btn btn-info rounded-circle ml-2" title="Profile" data-toggle="modal" data-target="#profileModal"><i class="fa fa-user"></i></a>
          <a href="dashboard" type="button" class="btn btn-success rounded-circle ml-2 mr-2" title="Change Password" data-toggle="modal" data-target="#changepasswordModal"><i class="fa fa-lock"></i></a>

          <input type="text" id="barcode" placeholder="Search products using barcode" minlength="13" maxlength="13">
          <!-- <a href="dashboard" type="button" class="btn btn-primary ml-2" onclick="removeAllItems()"><i class="fa fa-home"></i> Home</a> -->

          <a href="logout" type="button" class="btn btn-danger rounded-circle ml-2" title="Logout" onclick="removeAllItems()"><i class="fa fa-sign-out-alt"></i></a>
        </div>

        <div class="category-tabs">
          <div class="category-tab" onclick="fetchProduct('all')">All Items</div>
          <?php foreach ($admin->selectAll('tblcategory') as $fetchCategory): ?> 
            <div class="category-tab" onclick="fetchProduct(<?= $fetchCategory->cat_id; ?>)" id="category_id"><?= ucwords($fetchCategory->name); ?> <span class="badge badge-danger text-white"><?= $category->groupCategory($fetchCategory->cat_id) ?></span></div>
          <?php endforeach; ?>
        </div>

        <div class="product-grid fetch_product">

        </div>
      </div>

      <!-- Cart Section -->
      <div class="cart-section">
        <div class="cart-header">
          <div class="cart-title">Current Order</div>
          <div class="cart-number"><strong>User: <?= ucwords($getAdmin->username); ?></strong></div>
        </div>

        <!-- Cart Items Section -->
        <div class="cart-items" style="height: fit-content;scroll-behavior: auto;">
          <ul class="list-group mb-3 fetch_cart">

          </ul>
        </div>

        <!-- Cart Summary Section -->
        <div class="cart-summary">
          <div class="summary-row">
            <span>Subtotal:</span>
            <span id="subtotal">00.00</span>
          </div>
          <div class="summary-row total-row">
            <span>Total:</span>
            <span id="total">00.00</span>
          </div>

          <button class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal">Make Payment</button>
        </div>
      </div>

      <!-- Payment Modal -->
      <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Order Summary</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <!-- Cart Items Section -->
                        <!-- <div class="cart-items" style="height: fit-content;scroll-behavior: auto;">
                            <ul class="list-group mb-3 fetch_cart">
                                    
                            </ul>
                        </div> -->
                      </div>

                      <div class="col-md-12">
                        <!-- Cart Summary Section -->
                        <div class="cart-summary">
                          <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal_summary">00.00</span>
                          </div>
                          <div class="summary-row">
                            <span>Change:</span>
                            <span id="change">00.00</span>
                          </div>
                          <div class="summary-row total-row">
                            <span>Total:</span>
                            <span id="total_summary">00.00</span>
                          </div>
                          <div class="summary-row">
                            <span>Pay Type:</span>
                            <select name="paytype" id="paytype" class="form-control form-control-sm">
                              <option value="cash">Cash</option>
                              <option value="card">Card</option>
                            </select>
                          </div>
                          <div class="summary-row">
                            <span>Amount Paid:</span>
                            <input type="number" class="form-control form-control-sm" placeholder="00.00" id="amount_paid" required>
                          </div>

                          <div class="action-buttons">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer bg-whitesmoke br">
                <!-- <button class="btn btn-danger">Void Item</button>
                <button class="btn btn-primary">Hold</button>  -->
                <button class="btn btn-success" name="btnPlaceOrder" id="btnPlaceOrder">Pay Now</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="profileModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Username</label>
                          <input type="hidden" class="form-control" name="user_id" value="<?= ucwords($getAdmin->user_id); ?>" placeholder="ElonX" readonly>
                          <input type="text" class="form-control" name="username" value="<?= ucwords($getAdmin->username); ?>" placeholder="ElonX" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Full Name</label>
                          <input type="text" class="form-control" name="fullname" value="<?= ucwords($getAdmin->fullname); ?>" placeholder="Elon Musk">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" value="<?= $getAdmin->email; ?>" placeholder="elon.musk@spacex.org" readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Phone</label>
                          <input type="tel" class="form-control" name="phone" value="<?= $getAdmin->phone; ?>" placeholder="08090949669" maxlength="11">
                        </div>
                        <div class="col-12">
                          <input type="submit" class="btn btn-primary mb-2" name="btnUpdateProfile" value="Edit Changes">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Change Password Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="changepasswordModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <form method="POST">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label>Old Password</label>
                          <input type="hidden" class="form-control" name="user_id" value="<?= ucwords($getAdmin->user_id); ?>" placeholder="ElonX" readonly>
                          <input type="password" class="form-control" name="old_password" placeholder="***********">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Password</label>
                          <input type="password" class="form-control" name="password" placeholder="***********">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" name="cpassword" placeholder="***********">
                        </div>
                        <div class="col-12">
                          <input type="submit" class="btn btn-primary" name="btnChangeProfilePassword" value="Change Password">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Sales Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="salesModal">
          <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Transaction History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <span class="text-info">Items sold by you</span>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-striped" id="table-1">
                            <thead>          
                              <th class="text-center">
                                #
                              </th>
                              <th>Invoice No</th>
                              <th>Payment Mode</th>
                              <th>Total</th>
                              <th>Payment Status</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody> 
                            <?php
                            $i = 1;
                            foreach ($order->getCashierSales($getAdmin->user_id) as $getCashierSales):
                              ?>

                              <tr>
                                <td>
                                  <?= $i++; ?>
                                </td>
                                <td class="font-weight-bold" data-toggle="modal" data-target="#salesdetailsModal"><a href="#"><?= $getCashierSales->invoiceno; ?></a></td>
                                <td>
                                  <span class="badge badge-secondary"><?= ucwords($getCashierSales->paytype); ?></span>
                                </td>
                                <td>
                                  <?= number_format($getCashierSales->total, 00); ?>
                                </td>
                                <td class="font-weight-bold">
                                  <?= $order->printOrderStatusBadge($getCashierSales->invoiceno); ?>   
                                </td>
                                <td>
                                  <?= $getCashierSales->date_paid; ?>
                                </td>
                                <td>
                                  <a href="receipt?receiptno=<?= $getCashierSales->invoiceno; ?>" class="btn btn-sm btn-warning" title="Print Receipt"><i class="fa fa-print"></i></a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <script src="assets/modules/jquery.min.js"></script>
      <script src="assets/js/sweetalert.js"></script>
      <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>

      <script src="assets/modules/datatables/datatables.min.js"></script>
      <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
      <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
      <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>

      <!-- Page Specific JS File -->
      <script src="assets/js/page/modules-datatables.js"></script>

      <script>

        $('#amount_paid').on('input', function() {
          let totalAmount = parseFloat($('#total_summary').text());
          let amountPaid = parseFloat($('#amount_paid').val());

        // Check if amount paid is valid
          if (isNaN(amountPaid) || amountPaid < 1 || totalAmount < 1) {
            showMessage("Invalid Amount", "Cannot proceed with this transaction", "error");
            return;
          }

        // Calculate change
          let change = parseFloat(amountPaid) - parseFloat(totalAmount);

        // Display change
          if (amountPaid < totalAmount) {
            $('#change').text("Insufficient amount paid");
          }else {
            $('#change').text(change.toFixed(2)); // Format change to two decimal places
            $('#btnPlaceOrder').prop('disable', false);
          }
        });

        $('#barcode').keyup(function(e) {

          let barcode = $('#barcode').val();

          if(barcode.length < 13) {
            $('#barcode').val('');
            showMessage("Empty Fields", "Barcode length should be up to 13 digits", "error");
            return;
          }

            $('#barcode').val('');

            let audio = new Audio('./sound/beep.mp3');
            audio.play();

            $.ajax({
              url:'insertToCart.php',
              type: 'POST',
              dataType: 'json',
              data:{
                barcode: barcode
              },
              success:function(response) {
                if(response.success) {
                  console.log(response.message);
                  showMessage("Added to Cart", response.message, "success");
                }else {
                  showMessage("Add to cart Failed", response.message, "error");
                }
                $('#barcode').focus();
                $('#barcode').val('');
              },
              error: function(xhr, status, error) {
                if(status === "parsererror"){
                  console.error("Error: ", xhr.responseText); 
                }      
              }
            });
          
        });

        $('#btnPlaceOrder').on('click', function() {

          let paytype = $('#paytype').val();
          let subtotal = $('#subtotal').text();
          let total = $('#subtotal_summary').text();
          let change = $('#change').text();
          let amount_paid = $('#amount_paid').val();

          amount_paid = parseFloat(amount_paid);

          if (change < 0) {
            showMessage("Invalid Amount", "Cannot proceed with this transaction", "error");
            return;
          } 

          if(!amount_paid) {
            showMessage("Invalid Amount", "Enter a valid amount to pay", "error");
            return;
          }

          if (isNaN(amount_paid) || amount_paid < 1 || total < 1) {
            showMessage("Invalid Amount", "Cannot proceed with this transaction", "error");
            return;
          }

          if (amount_paid < total) {
            showMessage("Invalid Amount", "Cannot proceed with this transaction", "error");
            return;
          }

          $('#btnPlaceOrder').prop('disable', true);
          $('#btnPlaceOrder').text('Processing...');

          $.ajax({
            url:'makePayment.php',
            type: 'POST',
            dataType: 'json',
            data:{
              paytype: paytype,
              subtotal: subtotal,
              amount_paid: amount_paid
            },
            success:function(response) {
              if(response.success) {
                console.log(response.message);
                showMessage("Order Placed", response.message, "success");
                $('#change').text('00.00');
                $('#amount_paid').val('');
                $('#btnPlaceOrder').prop('disable', true);
                $('#btnPlaceOrder').text('Pay Now');
                $('#barcode').val('');
                window.location.href = 'receipt?receiptno=' + response.invoiceno;
              }else {
                showMessage("Order Failed", response.message, "error");
                $('#btnPlaceOrder').prop('disable', true);
                $('#btnPlaceOrder').text('Pay Now');
              }

            },
            error: function(xhr, status, error) {
              if(status === "parsererror"){
                console.error("Error: ", xhr.responseText); 
              }

            }
          });
        });

        const addToCart= (value) => {

          let product_id = value;

          let audio = new Audio('./sound/beep.mp3');
          audio.play();

          $.ajax({
            url:'insertToCart.php',
            type: 'POST',
            dataType: 'json',
            data:{
              product_id: product_id
            },
            function(data, status){
              
              console.log("Data: " + data + "\nStatus: " + status);
            }
          });

        }

        const removeFromCart = (value) => {

          let r_product_id = value;

          let audio = new Audio('./sound/button.mp3');
          audio.play();

          $.ajax({
            url:'insertToCart.php',
            type: 'POST',
            data:{
              r_product_id: r_product_id
            },
            function(data, status){
              alert("Data: " + data + "\nStatus: " + status);
            }
          });
        }

        const removeAllItems = () => {

          let remove_all = "remove_all";

          $.ajax({
            url:'insertToCart.php',
            dataType: 'json',
            type: 'POST',
            data:{
              remove_all: remove_all
            },
            success:function(response) {
              if(response.success) {
                console.log("Remove All Item Response:", response.success); 
                $('#subtotal').text('00.00');
                $('#amount_paid').val('');
                $('#barcode').val('');
                return confirm('Are you sure you want to log out?');
              }
            }
          });
        }

        const fetchCart = () => {
          $.ajax({
            url: 'fetchCart.php',
            type: 'POST', 
        dataType: 'json', 
        success: function(response) {
          if (response) {
            console.log(response.html);
            $('.fetch_cart').html(response.html); 
            $('#subtotal').text(response.total_price.toFixed(2));
            $('#subtotal_summary').text(response.total_price.toFixed(2));
            $('#total_summary').text(response.total_price.toFixed(2));
            $('#total').text("NGN " + response.total_price.toFixed(2));
            console.log("Total Price:", response.total_price); 
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error: " + textStatus, errorThrown); 
        }
      });
        }

        const fetchProduct = (value) => {

          let category_id = value;

          $.ajax({
            url: 'fetchProduct.php',
            type: 'POST', 
            dataType: 'json', 
            data:{
              category_id: category_id
            },
            success: function(response) {
              if (response) {
                $('.fetch_product').html(response.html);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error("Error: " + textStatus, errorThrown); 
            }
          });
        }

        function showMessage(title, text, icon) {
          swal({
            title: title,
            text: text,
            icon: icon,
            button: 'OK',
          })
        }

        fetchCart();
        fetchProduct();

        setInterval(() => {
          fetchCart();
      //fetchProduct();
        }, 1000);

      </script>

    </body>
    </html>


    <?php
    if(isset($_SESSION['messageTitle']) AND !empty($_SESSION['messageTitle'])){
      ?>
      <script>
        swal({
          title: '<?= $_SESSION['messageTitle']; ?>',
          text: '<?= $_SESSION['messageText']; ?>',
          icon: '<?= $_SESSION['messageIcon']; ?>',
          button: 'OK',
        })
      </script>
      <?php
      unset($_SESSION['messageTitle']);
      unset($_SESSION['messageText']);
      unset($_SESSION['messageIcon']);
    }

    ?>

