<?php require_once "control.php"; ?>

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Place Order</title>

  <!-- Latest compiled and minified CSS -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- fav icon -->
  <link rel="fav icon" href="../upload/fav.png">

  <!-- custom style -->
  <link rel="stylesheet" href="css/style_Box3.css">

</head>

<body>

  <?php include 'menu.php';
  // if not set email
  if (!isset($_SESSION['ses_Email'])) {
    header('location:index.php');
    exit();
  }
  // if set email
  if (isset($_SESSION['ses_Email'])) {
    if ($_SESSION['ses_Type'] == 9) {
      header('location:activationad.php');
      exit();
    }
    if ($_SESSION['ses_Type'] < 8) {
      if ($_SESSION['ses_Status'] == 0) {
        header('location: deleted.php');
        exit();
      }
    }
  }
  ?>
  <!-- starts here -->
  <div class="container">

    <div class="wrapper">

      <div class="p-3 text-light shadow rounded-sm mt-n5" style="background-color: #ff4d4d">

        <p><b>Name of the Receiver :</b> <?= $_SESSION['ses_First'] ?> <?= $_SESSION['ses_Last'] ?></p>

        <p><b>Address of the Receiver : </b><?= $_SESSION['ses_Add'] ?></p>
      </div>
    </div>
  </div>

  <!-- pending -->
  <?php
  $id = $_SESSION['ses_Id'];
  $mes = 'p';
  $stmt = $conn->prepare("
        SELECT * FROM cart_order_delivered_tb,producttb
        WHERE cart_order_delivered_tb.message = ?
        AND cart_order_delivered_tb.pId = producttb.pId
        AND cart_order_delivered_tb.uId = ?
        ORDER BY cart_order_delivered_tb.c_o_d_date DESC
      ");

  $stmt->bind_param('si', $mes, $id);
  $stmt->execute();
  $result = $stmt->get_result();

  ?>

  <div class="container">
    <h1 class="rounded text-light shadow text-center pl-5 pr-5" style="margin-top: -40px;background: #ff4d4d;">Pending Order(s)</h1>
    <table class="table table-hover table-striped">

      <thead>

        <tr class="text-center">

          <th scope="col">Name</th>

          <th scope="col">Amount</th>

          <th scope="col">Quantity</th>

          <th scope="col">Total Price</th>

          <th scope="col">Date and Time</th>

          <th scope="col">Action</th>

        </tr>

      </thead>

      <tbody>
        <form action="" method="post">
          <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) : ?>

              <tr>
                <td><?= $row['i_Name'] ?></td>

                <td class="text-center">₱ <?= number_format($row['i_Amount'], 2) ?></td>

                <td class="text-center"><?= $row['qty'] ?></td>

                <td class="float-right">₱ <?= number_format($row['total_price'], 2) ?></td>

                <td class="text-center"><?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
                  <br>
                  <?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
                </td>

                <input type="hidden" name="qty" value="<?= $row['qty'] ?>">

                <?php
                $mes = $row['message'];
                $o = 'o';
                $p = 'p';
                if ($mes == $o) { ?>
                  <td>
                    <a href="control.php?de=<?= $row['pId'] ?>" class="btn btn-danger">Delivered</a>
                  </td>
                <?php }
                if ($mes == $p) {
                  echo "<td class='text-danger'>Pending Order</td>";
                } ?>
              </tr>
            <?php endwhile ?>


          <?php } else {
            echo "
      <td colspan='6' class='text-danger text-center'>No items Found!</td>

      ";
          }
          ?>
        </form>
      </tbody>
    </table>
  </div>

  <!-- confirm -->
  <?php
  $id = $_SESSION['ses_Id'];
  $mes = 'co';
  $stmt = $conn->prepare("
        SELECT * FROM cart_order_delivered_tb,producttb
        WHERE cart_order_delivered_tb.message = ?
        AND cart_order_delivered_tb.pId = producttb.pId
        AND cart_order_delivered_tb.uId = ?
        ORDER BY cart_order_delivered_tb.c_o_d_date DESC
      ");

  $stmt->bind_param('si', $mes, $id);
  $stmt->execute();
  $result = $stmt->get_result();

  ?>
  <div class="container">
    <h1 class="rounded text-light shadow text-center" style="margin-top: -40px;background: #ff4d4d;">Confirmed if Order Delivered</h1>
    <table class="table table-hover table-striped">

      <thead>

        <tr>

          <th scope="colspan">Name</th>

          <th scope="col">Amount</th>

          <th scope="col">Quantity</th>

          <th scope="col">Total Price</th>

          <th scope="col">Date and Time</th>

          <th scope="col">Action</th>

        </tr>

      </thead>

      <tbody>
        <form action="" method="post">
          <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) : ?>

              <tr>
                <td><?= $row['i_Name'] ?></td>

                <td class="text-center">₱ <?= number_format($row['i_Amount'], 2) ?></td>

                <td class="text-center"><?= $row['qty'] ?></td>

                <td class="float-right">₱ <?= number_format($row['total_price'], 2) ?></td>

                <td class="text-center"><?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
                  <br>
                  <?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
                </td>

                <input type="hidden" name="qty" value="<?= $row['qty'] ?>">

                <?php
                $mes = $row['message'];
                $co = 'co';
                $p = 'p';
                if ($mes == $co) { ?>
                  <td>
                    <a href="control.php?de=<?= $row['c_o_d_Id'] ?>" class="btn btn-outline-warning btn-sm">Delivered</a>
                    &nbsp;
                    &nbsp;
                    <a href="control.php?cancel2=<?= $row['c_o_d_Id'] ?>" class="btn btn-sm btn-outline-danger mt-sm-1 ml-sm-1 ml-md-0">Cancel</a>

                  </td>
                <?php }
                if ($mes == $p) {
                  echo "<td>Pending Order</td>";
                } ?>
              </tr>
            <?php endwhile ?>
        </form>
      </tbody>

    <?php } else {

            echo "
      <td colspan='6' class='text-danger text-center'>No items Found!</td>

      ";
          }
    ?>
    </table>
  </div>

  <div class="container">
    <?php
    $id = $_SESSION['ses_Id'];
    $mes = 'de';
    $stmt = $conn->prepare("
        SELECT * FROM cart_order_delivered_tb,producttb
        WHERE cart_order_delivered_tb.message = ?
        AND cart_order_delivered_tb.pId = producttb.pId
        And cart_order_delivered_tb.uId = ?
        ORDER BY cart_order_delivered_tb.c_o_d_date DESC
      ");

    $stmt->bind_param('si', $mes, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
    <h1 class="rounded text-light shadow text-center" style="margin-top: -40px;background: #ff4d4d;">Delivered Order </h1>
    <table class="table table-hover table-striped">

      <thead>

        <tr class="text-center">

          <th scope="col">Name</th>

          <th scope="col">Amount</th>

          <th scope="col">Quantity</th>

          <th scope="col">Total Price</th>

          <th scope="col">Date and Time</th>

          <th scope="col">Item Ordered</th>

        </tr>

      </thead>

      <tbody>
        <form action="" method="post">
          <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) : ?>

              <tr>
                <td><?= $row['i_Name'] ?></td>

                <td class="text-center">₱ <?= number_format($row['i_Amount'], 2) ?></td>

                <td class="text-center"><?= $row['qty'] ?></td>

                <td class="float-right">₱ <?= number_format($row['total_price'], 2) ?></td>

                <td class="text-center"><?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
                  <br>
                  <?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
                </td>

                <input type="hidden" name="qty" value="<?= $row['qty'] ?>">

                <?php
                $mes = $row['message'];
                $o = 'de';

                echo "<td class='text-danger'>Delivered</td>";
                ?>
              </tr>
            <?php endwhile ?>


          <?php } else {

            echo "
      <td colspan='6' class='text-danger text-center'>No items Found!</td>
  
      ";
          }
          ?>
        </form>
      </tbody>
    </table>
  </div>
</body>
<script>
  $(document).ready(function() {
    $(".additemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pimage = $form.find(".pimage").val();
      var pname = $form.find(".pname").val();
      var pamount = $form.find(".pamount").val();
      var psize = $form.find(".psize").val();
      var pcode = $form.find(".pcode").val();
      $.ajax({
        url: 'control.php',
        method: 'post',
        data: {
          pid: pid,
          pimage: pimage,
          pname: pname,
          pamount: pamount,
          psize: psize,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          load_cart_item_number();
          load_fa_user_number();
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
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>