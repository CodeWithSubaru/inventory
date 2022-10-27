<?php

require "control.php";
 // if not set email
 if(!isset($_SESSION['ses_Email'])){
 
  header ('location: index.php');
 
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
        <?php
        $sql = $conn->prepare("SELECT * FROM producttb ORDER BY pId ASC");
        $sql->execute();
        $result = $sql->get_result();
        while($row = $result->fetch_assoc()){
         
         ?>

    <div style="position: sticky;top:70px;left:38%;display: inline-block;text-align:center;" id="message"></div>
    
      <div class="container">
        
        <div class="row text-center py-5">
          
          <div class="col-md-5 col-sm-2 my-3 my-md-2">
            
            <div class="shadow">
              
              <div>
            
                <img src="<?=$row['Image']?>" width="150px" class="img-fluid card-img-top">
            
              </div>

              <div class="card-body">
            <span class="card-title ml-4 d-inline-block"><b> Name of Product : </b><?= $row['i_Name']?></span>
              </div>
            <p class="card-text ml-4"><b>Price :</b> <?= $row['i_Amount'] ?></p>

            <p class="card-text ml-4"><b>Price :</b> <?= $row['Size'] ?></p>            
            <p class="card-text ml-4"><b>Price :</b> <?= $row['Mes'] ?></p>
            
            <form action="" class="form-submit">
            
            <input type="hidden" class="pId" value="<?= $row['pId'] ?>">

            <div>
              
               <?php  if ($row['Mes'] > 0 ) {
              
              echo '<button class="btn btn-warning btn-block additemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to Cart</button>';
            }?>

            </div>
            
            </form>

            </div>

          </div>
        
        </div>    
  
      </div>

    <?php }?>
<script>
  $(document).ready(function(){
    $(".additemBtn").click(function(e){
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pId = $form.find(".pId").val();

      $.ajax({
        url: 'control.php',
        method: 'post',
        data: {pId:pId},
        success:function(response){
          $("#message").html(response);
          load_cart_item_number();
          load_fa_user_number();
        }
      });
     });
    load_cart_item_number();
  
    function load_cart_item_number(){
    $.ajax({
      url: 'control.php',
      method: 'get',
      data: {cartItem:"cart_item"},
      success:function(response){
        $("#cart-item").html(response);
      }
    });
  }
  load_fa_user_number();
  function load_fa_user_number(){
    $.ajax({
      url: 'control.php',
      method: 'get',
      data: {user:"fa_user"},
      success:function(response){
        $("#fa").html(response);
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