<?php
require('config/config.php');
session_start();
ob_start();

$err = "";
//login 
if (isset($_POST['login'])) {
  $acc = $_POST['acc'];
  $password = sha1(mysqli_real_escape_string($mysqli, $_POST['password']));
  $stmt = $mysqli->prepare("SELECT acc, password, user_id FROM   users WHERE (acc =? AND password =?)"); //sql to log in user
  $stmt->bind_param('ss', $acc, $password); //bind fetched parameters
  $stmt->execute(); //execute bind 
  $stmt->bind_result($acc, $password, $user_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['user_id'] = $user_id;


  if (!$rs) {

    $err = "Incorrect Authentication Credentials ";
  } else {
    header("location:index.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>AECU | Dashboard </title>



    <style>
      body {
        opacity: 0;
      }

      .contain {
        position: relative;
        bottom: -40%;
        right: -50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 100vh
      }

      .form-control {
        border: none;
        outline: none;
      }

      @media (max-width:700px) {
        .contain {
          width: 90%;
        }
      }
    </style>
  </head>

  <body>
  <?php 
  $q =   md5("QWERTYUIOPASDFGHJKLZXCVBNM1234567890!@#$%^&*()_?") . sha1('QWERTYUIOPASDFGHJKLZXCVBNM1234567890!@#$%^&*()_?') . rand(9999999,111111111);

if(isset($_GET['acc'])){
  $acc = $_GET['acc'];
$qq = "SELECT * FROM users WHERE acc = '$acc'";
$run = mysqli_query($mysqli,$qq);
if(mysqli_num_rows($run) > 0){
  foreach($run as $row){
echo  $row['fullname'];

  }
}else{
  echo 'You don\'t have an account number';
}
}
if(isset($row['fullname']) && isset($_GET['acc'])){
  header("location:signup.php?q={$q}&name={$row['fullname']}&acc={$_GET['acc']}");
}
?>
    <div class="text-center py-2  h2" style='z-index:100; color:white; background-color:#153d77'>
      <div class="align-items-center d-flex">
        <img src="img/logo.png" style="width:70px; border-radius: 50%;background-color:white" alt="">
        <img src="img/knight.png" style="width:110px; height: 80px; border-radius: 50%; background-color:; " alt="">

      </div>
    </div>
    <?php echo $err ?>
    <?php

    if (isset($_SESSION['success'])) {

      echo $_SESSION['success'];
unset($_SESSION['success']);
    }
    ?>
    <div class="contain card p-4 ">
      <h2 class='text-center py-3'>Welcome Back</h2>
      <form action="" method="post">
        <div class="form-group">
          <label for="acc">Account Number</label>
          <input type="text" name="acc" class="form-control py-2" inputmode="numeric" placeholder="Enter Account Number"
            id="">
        </div>
        <div class="form-group my-2">
          <label for="acc">Password</label>
          <input type="password" name="password" class="form-control py-2" placeholder="Enter Passwordd" id="">
        </div>
        <button class="btn bg-success form-control text-light py-2" name="login" type="submit">Login</button>
      </form>
      <p class="pt-2">New Here? <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
          aria-controls="offcanvasTop" href="">Create your account</a></p>
          <small class='d-flex justify-content-between py-2'><span>Need Help? <a href="tel: +2330240578810">Contact Support</a></span>  <a href="https://accraeastcreditunion.org/policy.html">Privacy & Policies</a></small>
    </div>



    <div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
      <div class="offcanvas-header">
        <h2 id="offcanvasTopLabel">Verify Account number </h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

      </div>
      <div style="border: 1px solid grey;width:100%"></div>

      <div class="offcanvas-body d-flex flex-column align-items-center justify-content-center h4">

        <div class="card w-100 py-2 ">



          <form action=""  method="get" >
          <div class="py-3">Account Number  <input type="text" placeholder="Enter your Account Number" style="height:40px" name='acc' class='form-control py-2' required value=""></div>
          <button type="submit"   class='form-control btn py-2  btn-success'>Verify</button>
        </form>
              <p class='p-2 ' >Help  <label  data-bs-toggle="tooltip" data-bs-placement="top" title="To fully sign up your account, kindly verify yourself by entering your account number, once your full name appears, it means you can proceed to create your account, else contact us." for="acc"><i style='font-size:25px' class='bi bi-question-circle-fill' ></i></label></p>



        </div>


      </div>
    </div>

    </div>

    <script src="js/app.js"></script>
    <script src="js/settings.js"></script>


  </body>

</html>