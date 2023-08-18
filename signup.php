<?php 
ob_start();
session_start();
require("config/config.php");
$acc = $_GET['acc'];
$name = $_GET['name'];
if(!isset( $_GET['acc']) && !isset( $_GET['name'])){
  header('location:login.php');
}
if (isset($_POST["submit"])) {
  $user_id = $_POST["user_id"];
  $fullname = $_POST['fullname'];
  $acc = $_POST['acc'];
  $email = ($_POST["email"]);
  $phone = ($_POST["phone"]);
  $dob = $_POST['dob'];
  $court = $_POST['court'];
  $password = sha1(mysqli_real_escape_string($mysqli,$_POST["password"]));
  $confirm_password = sha1(mysqli_real_escape_string($mysqli,$_POST["confirm_password"]));



  $errors = array();
  

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   array_push($errors, "Email is not valid");
  }
  if (strlen($password)<8) {
   array_push($errors,"Password must be at least 8 charactes long");
  }
  if ($password!==$confirm_password) {
   array_push($errors,"Password does not match");
  }
  
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($mysqli, $sql);
  $rowCount = mysqli_num_rows($result);
  if ($rowCount>0) {
   array_push($errors,"Email already registered!");
  }
 
  else{
    $sqlin  =mysqli_query($mysqli,"UPDATE users SET  user_id ='$user_id',dob ='$dob',password ='$password',email ='$email',phone ='$phone',court ='$court' WHERE acc = '$acc'");
    if($sqlin){
      $_SESSION['success'] = "Signed up Successfully!";
      header("location:login.php");
    }
  }

 if (count($errors)>0) {
  foreach ($errors as  $error) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     '.$error.'
    
   </div>';
 }
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
        .contain{
position: absolute;
bottom: -50%;
right: -50%;  
transform: translate(-50%,-50%); 
width: 500px; 
height: 100vh
}
.form-control{
    border: none;
    outline: none;
}
     @media (max-width:700px) {
      .contain{
position: absolute;
bottom: -45%;
right: -50%;  
transform: translate(-50%,-40%); 
width: 90%; 
height: 100%;
}
     } 
    </style>
</head>

               
  
<body>

   <div class="text-center py-2  h2" style='z-index:100; color:white; background-color:#153d77; position:relative'>AECU APP</div>
            <div class="contain card p-4 ">
              <h4 class='text-center py-3'>Your Account Number is <span class="text-success font-weight-bold"> <?= $acc?></span></h4>
              <form action="" method="post">
              <div class="row">
                <div class="form-group text-center ">
                  <h3 for="acc">Procceed to Sign up </h3>
               
                </div>

                                <div class="form-group my-2 ">
                  <label for="acc">Full Name</label>
                  <input type="text" name="fullname" class="form-control" required  value="<?= $name?>" placeholder="Enter First Name" id="">
                </div>
                </div>
                <input type="hidden" name="user_id" value="<?= $beta . $sid?>">
                <input type="hidden" name="acc" value="<?= $acc?>">
                <div class="form-group my-2">
                  <label for="acc">Email Address</label>
                  <input type="email" name="email" class="form-control" required  placeholder="Enter your email Adddress" id="">
                </div>
                <div class="form-group my-2">
                  <label for="acc">Phone Number</label>
                  <input type="text" name="phone" class="form-control" required inputmode="numeric" placeholder="Enter your phone number" id="">
                </div>
                <div class="row">
                <div class="form-group my-2  col-md-6">
                  <label for="acc">Date of Birth</label>
                  <input type="date" name="dob" class="form-control" required  id="">
                  </div>
                <div class="form-group my-2  col-md-6">
                  <label for="acc">Court/Council</label>
                  <input type="text" name="court" class="form-control" required placeholder="Enter Court/Council" id="">
                </div>
                
                </div>
                <div class="row">
                <div class="form-group my-2 col-md-6">
                  <label for="acc">Password</label>
                  <input type="password" name="password" class="form-control" required  placeholder="Create a Password" id="">
                </div>
                <div class="form-group my-2 col-md-6">
                  <label for="acc">Confirm Password</label>
                  <input type="password" name="confirm_password" class="form-control" required placeholder="Re-enter Password" id="">
                </div>
                </div>
                <button class="btn bg-success form-control text-light" name="submit" type="submit">Sign Up</button>
              </form>
              <p class="pt-2" >Already a user? <a href="login.php">Log In here</a></p>
         <small class='d-flex justify-content-between py-2'><span>Need Help? <a href="">Contact Support</a></span>  <a href="">Privacy & Policies</a></small>
            </div>
         
       

    <script src="js/app.js"></script>
    <script src="js/settings.js"></script>


</body>

</html>