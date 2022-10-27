<?php
require_once "control.php";

// if set email go back to landing
if (isset($_SESSION['ses_Email'])) {
    header('location: index_1.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Log In - Lazaro Gas Delivey</title>

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="HandheldFriendly" content="true">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- fav icon -->
    <link rel="fav icon" href="upload/fav.png">

    <!-- custom style -->
    <link rel="stylesheet" href="./css/style3.css">
</head>

<body>
    <!-- validation succesfully registered -->
    <?php if (isset($_SESSION['message'])) : ?>
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


    <!-- validation error message -->
    <div class="container">


        <?php if (count($errors) > 0) : ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                <?php foreach ($errors as $error) : ?>

                    <li><?php echo " $error "; ?></li>
                <?php endforeach; ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>
            </div>
        <?php endif; ?>

        <div class="row">


            <div class="img-container">

                <img src="upload/lpg.jpg" width="250px" height="250px">

            </div>

            <div class="form-div login">

                <form action="index.php" role="form" method="post" id="form-login">

                    <div id='back_Img'>

                        <h3 class="text-center">Login</h3>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label for="email">Email</label>
                        <?php if (isset($_POST['ema'])) { ?>
                            <input type="email" name="ema" value="<?= $_POST['ema'] ?>" class="form-control form-control-lg">
                        <?php } else { ?>

                            <input type="email" name="ema" class="form-control form-control-lg" required>
                        <?php } ?>

                    </div>

                    <div class="form-group">

                        <label for="password">Password</label>

                        <input type="password" name="pas" class="form-control form-control-lg" minlength="6">

                    </div>

                    <div class="form-group">

                        <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Login</button>

                        <button type="reset" name="reset-btn" class="btn btn-danger btn-block btn-lg">Cancel</button>

                    </div>

                    <hr>

                    <p class="text-center">Not yet Member? <a href="signup.php">Sign Up</a></p>

                </form>

            </div>

        </div>

    </div>

</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>