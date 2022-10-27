<?php

require_once 'control.php';
// if set Email
if (!isset($_SESSION['ses_Email'])) {
  header('location: index.php');
  exit();
}
// if status is deleted
if ($_SESSION['ses_Status'] == 0) {
  header("location:deleted.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- title -->
  <title>Homepage - Lazaro Delivery Gas </title>

  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!-- Latest compiled and minified CSS -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- Fav Icon -->
  <link rel="fav icon" href="upload/fav.png">

  <!-- My css -->
  <link rel="stylesheet" href="css/style_Box2.css">
</head>

<body>

  <?php include "menu.php";
  // message if success else not
  if ($_SESSION['message'] == true) : ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="width: 100%;text-align: auto;">

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
  <!-- Navigation Starts here -->
  <div class="container">

    <div class="nav">

      <ul>

        <a href="#home1">
          <li>Home</li>
        </a>

        <a href="#about">
          <li>About</li>
        </a>

        <a href="#contact">
          <li>Contact Us</li>
        </a>

      </ul>

    </div>

    <div class="box1">

      <div class="" style="max-width: 100%;margin:1% auto;">

        <img src="upload/motor.png" width="200px" style="margin: auto 30%;width: 20vw;">

        <div class="card-header bg-danger text-white"></div>

        <div class="" id="home">

          <h5 class="card-title"><strong>Dear Our Customer</strong></h5>

          <p class="card-text" style="font-size: 1.2em;"> <br>Welcome To Our Site. We're glad that you're here.Happy Shopping!</p>

        </div>

      </div>

    </div>
    <!--section page starts here-->
    <div class="section1" id="home1">

      <div class="box3">

        <div class="wrapper">

          <p id="Au">Authorized Retail Outlet</p>
          <div id="La">


            Lazaro Gas Delivery

          </div>

          <p id="ta1">Tapat sa Kalidad! Tapat sa Timbang!!!</p>

          <br>

          <p id="free">Free Delivery</p>
          <?php if ($_SESSION['ses_Type'] == 3) : ?>

            <a href="cart.php" id="shopnow" class="btn btn-light">Shop Now</a>
          <?php endif ?>

        </div>

      </div>
      <!-- About section -->
      <div class="section" id="about">

        <div class="box-content">

          <div class="box2">

            <div class="cover">

            </div>

            <div id="text">

              <h2>About us <center>&</center> Business</h2>

              <p>Lazaro Delivery Gas was came from the Last Name of Ms. Lea Lazaro. We started Business at 2013.We delivering gas to our customer to serve meals for their Love Ones.<br><br><br><br><br> <span id="left"> We are Open, Monday - Sunday @ 6:00 am - 7 : 30 pm.<br><i>Safety and Quality is our Business</i>.</span>

              </p>

            </div>

          </div>

        </div>

      </div>
      <!-- Contact start here -->
      <div class="footer">

        <div id="contact" class="content">

          <div class="content-inner">

            <div id="number">

              <h4>Contact Us @: </h4>


              <b id="p">Phone:</b> 8 281 2662

              <br><b id="t">Talk n Text:</b> 0946 428 8486

              <br><b id="g">Globe :</b> 0977 609 4668

            </div>

            <h4>Name of Owner:</h4>

            <p>Lea Lazaro</p>

            <h4>You can see us @:</h4>

            <p>Lawa, Obando, Bulacan</p>

            <sub>Copyrights &copy; 2020 All Rights Reserved by Lazaro Gas</sub>
          </div>

        </div>

      </div>

    </div>

  </div>

</body>
<script>
  $(document).ready(function() {
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