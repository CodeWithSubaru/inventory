<?php
require_once 'control.php';
// if not set email

if (!isset($_SESSION['ses_Email'])) {
  header('location:index.php');
  exit();
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">
  <!-- title -->
  <title>Cart - Lazaro Delivery Gas</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- fav icon -->
  <link rel="fav icon" href="upload/fav.png">

</head>

<body>

  <?php include "menu.php";
  // if there is message
  if ($_SESSION['message'] == true) :
  ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: sticky;top:70px;left:38%;display: inline-block;text-align:center;">

      <?= $_SESSION['msg_type']; ?>

      <?php

      echo $_SESSION['message'];

      unset($_SESSION['message']);

      ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

        <span aria-hidden="true">&times;</span>

      </button>

    </div>

  <?php endif; ?>
  <!-- ends here -->

  <!-- starts here -->
  <div class="container">

    <div class="row justify-content-center">

      <table class="table table-bordered table-striped text-center">

        <h4 class="text-center text-info">
          Products in your Cart!
        </h4>

        <thead>

          <tr class="text-center">

            <th colspan="2">Product Code</th>

            <th colspan="2">Image</th>

            <th colspan="2">Name</th>

            <th colspan="2">Price</th>

            <th colspan="2">Quantity</th>

            <th colspan="4">Total Price</th>

            <?php

            $id = $_SESSION['ses_Id'];

            $x = 'c';
            // selecting id for deletion or removing item

            $sel = $conn->prepare('
                  SELECT uId,message FROM cart_order_delivered_tb 
                  WHERE uId = ? 
                  AND message = ?
                ');

            $sel->bind_param('is', $id, $x);

            $sel->execute();

            $result = $sel->get_result();

            $row = $result->fetch_assoc();

            $mes = $row['message'] ?? '';

            if (isset($mes)) { ?>

              <th colspan="2">
                <button type="button" class="btn btn-danger p-2" data-toggle="modal" data-target="#myModal1"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Clear All
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal1">

                  <div class="modal-dialog modal-sm">

                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">

                        <h4 class="modal-title">Clear All?</h4>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        Are you sure? You want to Clear All items?
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">

                        <a href="control.php?clear=<?= $_SESSION['ses_Id'] ?>" class="badge badge-danger p-3"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear All</a>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          <i class="fas fa-times-circle"></i>&nbsp;&nbsp;Cancel
                        </button>

                      </div>

                    </div>

                  </div>

                </div>

              </th>
            <?php } ?>
          </tr>
        </thead>
        <?php

        $id = $_SESSION['ses_Id'];
        $x = 'c';
        // selecting all message cart
        $stmt = $conn->prepare("
        SELECT * FROM cart_order_delivered_tb,producttb 
        WHERE cart_order_delivered_tb.uId = ? 
        AND cart_order_delivered_tb.message = ? 
        AND cart_order_delivered_tb.pId = producttb.pId
        ");

        $stmt->bind_param("is", $id, $x);

        $stmt->execute();

        $result = $stmt->get_result();

        $grand_total = 0;

        while ($row = $result->fetch_assoc()) :

        ?>

          <tbody>

            <tr>

              <td colspan="2"><?= $row['p_code'] ?></td>

              <input type="hidden" class="pId" value="<?= $row['c_o_d_Id'] ?>">


              <td colspan="2"><img src="<?= $row['Image'] ?>" width="75px;"></td>

              <td colspan="2"><?= $row['i_Name'] ?></td>

              <td colspan="2">₱<?= number_format($row['i_Amount'], 2) ?></td>

              <input type="hidden" class="p_amount" value="<?= $row['i_Amount'] ?>">

              <td colspan="2">

                <form id="forms">
                  <input type="text" value="<?= $row['qty'] ?>" size="1" readonly>
                  <br><br>
                  <select name="num" id="num">
                    <option value="">--Select--</option>
                    <?php
                    $i = 1;
                    for ($qty = 1; $qty <= $row['Mes']; $qty++) {

                      echo '<option value="' . $qty . '">' . $qty . '</option>';
                    }

                    ?>
                  </select>
                  <br>
                  <br>
                  <input type="submit" value="Save" class="add btn btn-sm btn-primary">
                </form>
              </td>

              <td colspan="4">₱ <?= number_format($row['total_price'], 2) ?></td>

              <td>

                <a href="control.php?rem=<?= $row['c_o_d_Id'] ?>" class="badge badge-danger p-3"><i class="fas fa-trash"></i>&nbsp;&nbsp;Remove</a>

              </td>

            </tr>

            <?php $grand_total += $row['total_price']; ?>

          <?php endwhile; ?>

          <tr>

            <td colspan="4">
              <a href="cart.php" class="btn btn-warning"><i class="fas fa-cart-plus">&nbsp;&nbsp;Continue Shopping</i></a>
            </td>

            <td colspan="6"><strong>Grand Total</strong></td>

            <td>₱<?= number_format($grand_total, 2) ?></td>

            <?php if ($grand_total > 0) : ?>

              <td colspan="4"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal6"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Place Order</button>

                <!-- The Modal -->
                <div class="modal fade" id="myModal6">

                  <div class="modal-dialog modal-sm">

                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">

                        <h4 class="modal-title">Place Order?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        Are you sure? You want to Place Order?
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">

                        <a href="plor.php?success=<?= $_SESSION['ses_Id'] ?>" class="btn btn-primary">

                          <i class="fas fa-check-circle"></i>&nbsp;&nbsp;Yes

                        </a>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i>&nbsp;&nbsp;Cancel</button>

                      </div>

                    </div>

                  </div>

                </div>

              </td>

            <?php endif ?>

          </tr>

          </tbody>

      </table>

    </div>

  </div>

  <script>
    // change qunatity price and grand total
    $(document).ready(function() {
      $(".add").on('click', function() {
        var $el = $(this).closest('tr');

        var pid = $el.find(".pId").val();
        var p_amount = $el.find(".p_amount").val();
        var qty = $el.find("#num").val();
        alert("You've Selected: " + qty);
        $.ajax({
          url: "control.php",
          method: 'post',
          cache: false,
          data: {
            qty: qty,
            pid: pid,
            p_amount: p_amount
          },
          success: function(response) {
            console.log(response);
            location.reload(true);
          }
        });
      });

      load_cart_item_number();

      function load_cart_item_number() {
        $.ajax({
          url: 'control.php',
          method: 'get',
          data: {
            cartItem: "cart_item"
          },
          success: function(response) {
            $("#cart-item").html(response);
          }
        });
      }
      load_fa_user_number();

      function load_fa_user_number() {
        $.ajax({
          url: 'control.php',
          method: 'get',
          data: {
            user: "fa_user"
          },
          success: function(response) {
            $("#fa").html(response);
          }
        });
      }
      load_notif_number();

      function load_notif_number() {
        $.ajax({
          url: 'control.php',
          method: 'get',
          data: {
            bell: "bell"
          },
          success: function(response) {
            $("#bell").html(response);
          }
        });
      }
    });
  </script>
</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>