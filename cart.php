<?php

require "control.php";
// if not set email
if (!isset($_SESSION['ses_Email'])) {

  header('location: index.php');

  exit();
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Cart</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <!-- fav icon -->
  <link rel="fav icon" href="upload/fav.png">

</head>

<body>
  <?php

  require "conn.php";

  include "menu.php";
  ?>

  <div style="position: sticky;top:70px;left:38%;display: inline-block;text-align:center;z-index: 1;" id="message"></div>

  <div class="container">

    <div class="alert alert-warning p-3 text-center text-danger" style="font-size: 1.2em;"><b>Products Available</b></div>

    <div class="row mt-2 pb-3">
      <?php
      // query all products  
      $stmt = $conn->prepare("SELECT * FROM producttb ORDER BY pId ASC");

      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) :
      ?>

        <div class="col-lg-6 col-md-4 col-sm-4">
          <div class="card-deck">
            <div class="card bg-light p-2 border-danger mb-2" style="border: 3px solid red;">
              <img src="<?= $row['Image'] ?>" class="card-img-top" style="background-position: center;background-size: cover; object-fit: contain;height: 250px;">
              <div class="card-body p-1">
                <div class="card-title text-center text-dark">

                  <div class="mt-2 font-weight-bold">
                    Name:<?php echo $row['i_Name']; ?>
                  </div>
                  <div class="mt-2">
                    Amount:₱<?= number_format($row['i_Amount'], 2) ?>
                  </div>
                  <div class="mt-2">
                    Size:<?= $row['Size'] ?>
                  </div>
                  <div class="mt-2">
                    Available Stock:<?= $row['Mes'] ?>
                  </div>
                  <div class="mt-2">
                    <form action="" class="form-submit" method="post">

                      <input type="hidden" class="pId" value="<?= $row['pId'] ?>">

                      <!-- if stocks is not set to 0 -->
                      <?php if ($row['Mes'] > 0) {

                        echo '<button class="btn btn-warning btn-block additemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to Cart</button>';
                      }

                      ?>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $(".additemBtn").click(function(e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var pId = $form.find(".pId").val();
        $.ajax({
          url: 'control.php',
          method: 'post',
          data: {
            pId: pId
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
</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>