<?php

require_once "control.php";
// not set email
if (!isset($_SESSION['ses_Email'])) {
  header('location:index.php');
  exit();
}
// if set email
if (isset($_SESSION['ses_Email'])) {

  if ($_SESSION['ses_Type'] < 9) {

    if ($_SESSION['ses_Status'] == 0) {
      header('location: deleted.php');
      exit();
    } else {
      header('location: index_1.php');
      exit();
    }
  }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">
  <!-- title -->
  <title>Activation</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <!-- Fav icon -->
  <link rel="fav icon" href="upload/fav.png">

</head>

<body>
  <?php
  include "menu.php"; ?>
  <!-- ends here -->

  <!-- available accounts -->
  <div class="container">

    <?php

    // starts here if message is set
    if (isset($_SESSION['message'])) : ?>

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

    <div style="position: sticky;top:70px;left:38%;display: inline-block;text-align:center;" id="message"></div>

    <div class="row justify-content-center">

      <h3 class="badge badge-danger" style="font-size: 1.5em;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16),0 2px 10px 0 rgba(0, 0, 0, 0.32);">Available Accounts</h3>

      <table class="table table-striped">

        <thead>

          <tr class="text-center">

            <th>Id</th>

            <th colspan="2" id="m">Email</th>

            <th colspan="2">Date of Register</th>

            <th colspan="2">Action</th>

          </tr>

        </thead>

        <?php
        // query all members, activate now and need activation
        $result = $conn->query("SELECT uId,u_Email,u_Reg,u_Type,status FROM userstb WHERE u_Type < 4 AND status < 2 ;") or die($conn->error); ?>

        <?php while ($row = $result->fetch_assoc()) : ?>

          <tbody>

            <tr class="text-center">

              <td><?php echo $row["uId"]; ?></td>

              <td colspan="2"><?php echo $row["u_Email"]; ?></td>

              <td colspan="2"><?= date('F j, Y', strtotime($row['u_Reg'])); ?>
                <br>
                <?= date('g:i a', strtotime($row['u_Reg'])); ?>
              </td>

              <td>

                <a href="control.php?admin=<?php echo $row['uId']; ?>" class="btn btn-sm btn-outline-info">Admin</a>

                <!-- if deleted -->
                <?php if ($row['status'] < 1) { ?>

                  <a href="control.php?res=<?php echo $row['uId']; ?>" class="btn btn-sm btn-outline-info">Restore</a>

                <?php } else { ?>
                  <a href="control.php?del=<?= $row['uId'] ?>" class="btn btn-sm btn-outline-danger">Deactivate</a>

                <?php } ?>
              </td>

            </tr>

          </tbody>

        <?php endwhile; ?>

        <tr>
          <?php
          // count result
          $sql  =  "SELECT COUNT(uId) as total FROM userstb WHERE u_Type < 4 AND status < 2;";

          $result = $conn->query($sql);

          $val = $result->fetch_assoc();

          $num_rows = $val['total'];
          ?>

          <td class="text-center" colspan="6"><?php echo $num_rows . ' result(s)';   ?> </td>

        </tr>

      </table>

    </div>

  </div>

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script>
  </script>
</body>

</html>