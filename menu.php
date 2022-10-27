<?php

require_once 'control.php';
// if not set email
if (!isset($_SESSION['ses_Email'])) {
  header('location:index.php');
  exit();
}
if (isset($_SESSION['ses_Email'])) {
  $email = $_SESSION['ses_Email'];
  $password = $_SESSION['ses_Pass'];
  $sql = "SELECT * FROM userstb WHERE u_Email='$email' AND u_Pass='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $_SESSION['ses_Id'] = $row['uId'];
    $_SESSION['ses_First'] = $row['u_First'];
    $_SESSION['ses_Last'] = $row['u_Last'];
    $_SESSION['ses_Type'] = $row['u_Type'];
    $_SESSION['ses_Status'] = $row['status'];
    $_SESSION['ses_Email'] = $row['u_Email'];
    $_SESSION['ses_Add'] = $row['u_Add'];
    $_SESSION['ses_Num'] = $row['u_Num'];
    $_SESSION['ses_Reg'] = $row['u_Reg'];
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">

    <title>SideBar Menu</title>

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script>
      $(document).ready(function() {

        $(".hamburger .hamburger__inner").click(function() {

          $(".wrapper").toggleClass("active");

        });

        $(".top_navbar .fa-user").click(function() {

          $(".profile_dd").toggleClass("active");

        });

      })
    </script>

    <!-- fav icon -->
    <link rel="fav icon" href="upload/fav.png">

    <!-- custom style -->
    <link rel="stylesheet" href="css/stylee.css">

  </head>

  <body>
    <!-- starts here -->
    <div class="wrapper">

      <div class="top_navbar">

        <div class="hamburger">

          <div class="hamburger__inner">

            <div class="one"></div>

            <div class="two"></div>

            <div class="three"></div>

          </div>

        </div>

        <div class="menu">

          <div class="logo shadow rounded-sm">

            Lazaro Gas&nbsp;<i class="fas fa-motorcycle" id="motor"></i>

          </div>
          <div class="right_menu">

            <ul>
              <li> <?php
                    // notification
                    if ($_SESSION['ses_Type'] == 3) {

                      echo '
                  <div style="margin-top: -3px;">
                  <a href="notif.php" style="margin-right:5px;text-decoration: none;color: #004D40; font-size: 1.2em;"><i class="fas fa-bell"><span id="bell" class="badge badge-danger"></span></i></a></div>';
                    }
                    ?></li>
              <li><i class="fas fa-user"><span id="fa" class="badge badge-danger"></span></i>

                <div class="profile_dd">

                  <?php
                  // if member
                  if ($_SESSION['ses_Type'] == 3) {

                    echo '<div class="dd_item">
                  <a href="cart1.php"><i class="fas fa-shopping-cart"><span id="cart-item" class="badge badge-danger"></span></i>&nbsp;Cart</a></div>';
                  }


                  // if admin and member
                  if ($_SESSION['ses_Type'] == 9 || $_SESSION['ses_Type'] == 8 || $_SESSION['ses_Type'] == 3) {

                    echo '<div class="dd_item"><a href="updateprof.php"><i class="fas fa-user"></i>&nbsp;Update Profile</a></div>';

                    echo '<div class="dd_item"><a href="changepas.php"><i class="fas fa-key"></i>Change Password</a></div>';
                  }
                  ?>
                  <div class="dd_item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></div>

                </div>

              </li>

            </ul>

          </div>

        </div>

      </div>

      <div class="main_container">

        <div class="sidebar">

          <div class="sidebar__inner">

            <div class="profile">

              <div class="img">

                <img src="upload/user.png">

              </div>

              <div class="profile_info">

                <p>Welcome</p>

                <p class="profile_name"><?php echo $_SESSION['ses_First']; ?></p>

              </div>

            </div>

            <ul>

              <?php
              // if member need activation and  need activation
              if ($_SESSION['ses_Type'] < 9) {

                echo '<li>
                    <a href="index_1.php">
                      <span class="icon"><i class="fas fa-home"></i></i></span>
                      <span class="title">Home</span>
                    </a>
                  </li>';
              }
              // if owner
              if ($_SESSION['ses_Type'] == 8) {

                echo '<li>
                  <a href="orders.php">
                    <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                    <span class="title">Orders</span>
                  </a>
                </li>';
              }
              ?>
              <?php
              // if admin
              if ($_SESSION['ses_Type'] == 9) {

                echo '<li>
                  <a href="orders.php">
                    <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                    <span class="title">Orders</span>
                  </a>
                </li>';

                echo '<li>
                  <a href="products.php">
                    <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                    <span class="title">Your Products</span>
                  </a>
                </li>';

                echo '<li><a href="activationad.php">
                    <span class="icon"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="title">Confirmation</span>
                  </a>
                </li>';
              }
              ?>

            <?php
            // if member
            if ($_SESSION['ses_Type'] == 3) {

              echo '<li>
                  <a href="cart.php">
                    <span class="icon"><i class="fas fa-shopping-cart"></i></span><span class="title">Add to Cart</span></a>
                </li>';

              echo '<li><a href="plor2.php">
                    <span class="icon"><i class="fas fa-truck"></i></span>
                    <span class="title">Orders</span>
                  </a>
                </li>
                ';
            }
          }
          if ($_SESSION['ses_Type'] <= 9) {
            echo '<li>
                  <a href="review.php">
                    <span class="icon"><i class="fas fa-home"></i></i></span>
                    <span class="title">Reviews</span>
                  </a>
                </li>';
          }

            ?>
            </ul>
          </div>
        </div>
  </body>
  Q
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  <!-- ajax -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <!-- bootstraap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </html>