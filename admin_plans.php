<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_plan'])){

   $planid = $_POST['planid'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $months = $_POST['months'];
   $price = $_POST['price'];
   

   $select_plan_name = mysqli_query($conn, "SELECT name FROM `plans` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_plan_name) > 0){
      $message[] = 'plan name already added';
   }else{
      $add_plan_query = mysqli_query($conn, "INSERT INTO `plans`(planid, name , months , price) VALUES($planid,'$name', '$months', '$price')") or die('query failed');

    
   }
}

if(isset($_GET['delete_plan'])){
   $delete_id = $_GET['delete_plan'];
   
   mysqli_query($conn, "DELETE FROM `plans` WHERE planid = '$delete_id'") or die('query failed');
   header('location:admin_plans.php');
}

if(isset($_POST['update_plan'])){

   
   $update_name = $_POST['update_name'];
   $update_months = $_POST['update_months'];
   $update_price = $_POST['update_price'];
  

   mysqli_query($conn, "UPDATE `plans` SET `name` = '$update_name', `months` ='$update_months', `price` = '$update_price' WHERE `planid` = `planid`") or die('query failed');

   

   
   

   header('location:admin_plans.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>plans</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">SHOP PLANS</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add plans</h3>
      <input type="number" name="planid" class="box" placeholder="enter plan id" required>
      <input type="text" name="name" class="box" placeholder="enter plan name" required>
      <input type="number" min="0" name="months" class="box" placeholder="enter duration of months" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter plan price" required>
      <input type="submit" value="add plans" name="add_plan" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_plans = mysqli_query($conn, "SELECT * FROM `plans`") or die('query failed');
         if(mysqli_num_rows($select_plans) > 0){
            while($fetch_plans = mysqli_fetch_assoc($select_plans)){
      ?>
      <div class="box">
         
         <div class="name"><?php echo $fetch_plans['name']; ?></div>
         <div class="price">Rs.<?php echo $fetch_plans['price']; ?>/-</div>
         <div class="months">available for months : <?php echo $fetch_plans['months']; ?>/-</div>
         <a href="admin_plans.php?update=<?php echo $fetch_plans['planid']; ?>" class="option-btn">update</a>
         <a href="admin_plans.php?delete_plan=<?php echo $fetch_plans['planid']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no plans added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-plan-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `plans` WHERE planid = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
       
      
      
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_months" value="<?php echo $fetch_update['months']; ?>" min="0" class="box" required placeholder="enter months duration">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      
      <input type="submit" value="update" name="update_plan" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-plan-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>