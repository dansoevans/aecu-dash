<?php 
ob_start();
session_start();
include('config/config.php');
check_login();
$user_id = $_SESSION['user_id'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['submit'])){
 
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    $phone = $_POST['phone'];
    $avatars = md5($_FILES['avatars']['name']) . '.jpg';
move_uploaded_file($_FILES["avatars"]["tmp_name"], "img/avatars/" . md5($_FILES["avatars"]["name"]) . '.jpg');
  
    $postQuery = "UPDATE users SET  dob =?, email =?, fullname =?, phone = ?, avatars = ? WHERE user_id = '$user_id'";
    $postStmt = $mysqli->prepare($postQuery);
    //bind 
    $rc = $postStmt->bind_param('sssss', $dob, $email, $fullname,  $phone, $avatars);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
     echo "Success";
    } else {
      echo "Please Try Again Or Try Later";
    }
  }
 
  ?>
       <?php
                             if (isset($_POST['change'])) {

                                //Change Password
                                $error = 0;
                                if (isset($_POST['password']) && !empty($_POST['password'])) {
                                  $password =sha1($_POST['password']);
                                } else {
                                  $error = 1;
                                echo "Old Password Cannot Be Empty";
                                }
                                if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
                                  $new_password =sha1($_POST['new_password']);
                                } else {
                                  $error = 1;
                                echo "New Password Cannot Be Empty";
                                }
                                if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
                                  $confirm_password = sha1($_POST['confirm_password']);
                                } else {
                                  $error = 1;
                                echo "Confirmation Password Cannot Be Empty";
                                }
                              
                                if (!$error) {
                                 
                                  $sql = "SELECT * FROM users   WHERE user_id = '$user_id'";
                                  $res = mysqli_query($mysqli, $sql);
                                  if (mysqli_num_rows($res) > 0) {
                                    $row = mysqli_fetch_assoc($res);
                                    if ($password != $row['password']) {
                                    echo  "Please Enter Correct Old Password";
                                    } elseif ($new_password != $confirm_password) {
                                    echo "Confirmation Password Does Not Match";
                                    } else {
                              
                                      $new_password  = sha1($_POST['new_password']);
                                      //Insert Captured information to a database table
                                      $query = "UPDATE users SET  password =? WHERE user_id =?";
                                      $stmt = $mysqli->prepare($query);
                                      //bind paramaters
                                      $rc = $stmt->bind_param('ss', $new_password, $user_id);
                                      $stmt->execute();
                              
                                      //declare a varible which will be passed to alert function
                                      if ($stmt) {
                                        echo "Password Changed";
                                      } else {
                                        echo "Please Try Again Or Try Later";
                                      }
                                    }
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
    <title>AECU | Loan Calculator </title>


  
    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

<body>
<?php 


$msg ='';
// if the Enter button is clicked
if(isset($_POST['sub'])){

    $amount = mysqli_escape_string($mysqli, $_POST['amount']);
    $phone = mysqli_escape_string($mysqli, $_POST['phone']);
    $ref = mysqli_escape_string($mysqli, $_POST['ref']);
    
    $qq = mysqli_query($mysqli, "SELECT * FROM users WHERE user_id = '$user_id'");
if(mysqli_num_rows($qq) >  0){
    while($row = mysqli_fetch_assoc($qq)){
        $name = $row['fullname'];
        $acc = $row['acc'];
    }
}

require 'vendor/autoload.php';
$mail = new PHPMailer(true);

try {
                     
    $mail->isSMTP();        
    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );
      $mail->SMTPSecure = "ssl";                                   
      $mail->Host       = "smtp.titan.email";                     
      $mail->SMTPAuth   = true;                                   
      $mail->Username   = "victor@app-aecu.com";
      $mail->Password   = "Enter2net$";                           
      $mail->Port       = 465;


    //Recipients
    $mail->setFrom('victor@app-aecu.com', 'AECU');
    $mail->addAddress("evansadjnr04@gmail.com", "Evans");     
            
    $mail->addReplyTo('victor@app-aecu.com', 'no-reply');

 

    //Content
    $mail->isHTML(true);                                 
    $mail->Subject = 'AECU Customer Message';
    $mail->Body = "Hi Admin, <br><br> {$name} with Account number {$acc} has requested to withdraw an amount of GH₵ {$amount}. <br> Contact <a href='tel:+233{$phone}'>{$phone}</a>  to confirm request. REFERENCE: {$ref}";
    

    $mail->send();
    if($mail->send()){
    $msg = '<div class="alert alert-primary">Your Requested has been sent!</div>';
    
  }else {
    # code...
    $msg = '<div class="alert alert-danger">Something Went Wrong</div>';
  }
} catch (Exception $e) {
    echo "<div class='alert-danger alert' >
    Something Went wrong.
    </div>";
}
    //  $success = "Registered Successfully!" && header("refresh:1; url=business.php?business_auth00=$business_id");
   } 
?>
<?php  if(isset($msg)){echo $msg ;} ?>

<div class="offcanvas offcanvas-top h-100" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
      <div class="offcanvas-header">
        <h2 id="offcanvasTopLabel">Request Withdrawal </h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

      </div>
      <div style="border: 1px solid grey;width:100%"></div>

      <div class="offcanvas-body d-flex flex-column align-items-center justify-content-center h4">

        <div class="card w-100 py-2 ">
          <form action=""  method="post" >
          <div class="py-3">Amount <span class="text-danger" >*</span>  <input type="text"  placeholder="How much do you want to withdraw?" style="height:40px" name='amount' class='form-control py-2' required value=""></div>
          <div class="py-3">Phone number <span class="text-danger" >*</span>  <input type="text"  placeholder="Enter active phone number" style="height:40px" name='phone' class='form-control py-2' required value=""></div>
          <div class="py-3">Reference  <input type="text" placeholder="What is the purpose of this withdrawal?" style="height:40px" name='ref' class='form-control py-2' required value=""></div>
          <button type="submit"  name='sub'  class='form-control btn py-2  btn-success'>Request</button>
        </form>
        </div>


      </div>
    </div>
    <div class="splash active">
        <div class="splash-icon"></div>
    </div>

    <div class="wrapper">
        <nav id="sidebar" class="sidebar">
            <div class="nav-main">
            <div class="align-items-center d-flex">
  <img src="img/logo.png" style="width:70px; border-radius: 50%;background-color:white" alt="">
  <img src="img/knight.png" style="width:110px; height: 80px; border-radius: 50%; background-color:; "  alt="">
       
          </div>
            <div class="sidebar-content">
            

                <ul class="sidebar-nav">
                   
                <li class="sidebar-item active my-4">
                     
                     <ul id="dashboards" class="list-unstyled collapse show" >
                         <li class="sidebar-item"><a class="sidebar-link" href="index.php">Dashboard</a></li>
                         <li class="sidebar-item"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"aria-controls="offcanvasTop"><a class="sidebar-link">Initiate Withdrawal</a></li>
                        
                         <li class="sidebar-item"><a class="sidebar-link" href="calculator.php">Loan Calculator</a></li>
                         <li class="sidebar-item"><a class="sidebar-link" href="logout.php">Sign Out</a></li>
                     </ul>
                 </li>

                </ul>
            </div>
        </div>
        </nav>
        <div class="main">
            <nav class="navbar navbar-expand navbar-theme">
                <a class="sidebar-toggle d-flex me-2">
					<i class="hamburger align-self-center"></i>
				</a>

                <form class="d-none d-sm-inline-block">
                    <input class="form-control form-control-lite" type="text" placeholder="Search...">
                </form>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                     
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-bs-toggle="dropdown">
								<i class="align-middle fas fa-cog"></i>
							</a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php"><i class="align-middle me-1 fas fa-fw fa-user"></i> View Profile</a>
                         
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content">
                <div class="container-fluid">


                    <div class="header">
                        <h1 class=" m header-title">
                       My Profile
                        </h1>
                        
                    </div>
                    
             
                    <div class="row">
                   
                        <div class="col-xl-12 col-xxl-5 d-flex">
                            <div class="w-100">
                               
                                  
                            <?php 
$qq = mysqli_query($mysqli,"SELECT * FROM users WHERE user_id = '$user_id'");

if(mysqli_num_rows($qq) > 0){
    while($row = mysqli_fetch_assoc($qq)){
$fullname = $row["fullname"];

$acc = $row["acc"];
$avatars = $row["avatars"];
$dob = $row["dob"];
$email = $row["email"];
$phone = $row["phone"];
$court = $row["court"];
$current = date('Y-m-d');
$diff = date_diff(date_create($dob), date_create($current));
$age = $diff->y;
}
}
?>    
                                    
                            <div class="card align-items-center p-4">
                              <div class="position-relative">
                              <img src="img/avatars/<?php if(isset($avatars)){echo $avatars;}else{echo 'noprofile.png'; } ?>" width="100" style="border-radius:50%" alt="">
                                                             </div>
                                  <h3><?php echo $fullname. ',' . $age ?></h3>
                                  <p class='h5'><?php echo $acc ?></p>
                              </div>
                              <div class="row">
                                  <h2>Settings</h2>
                                  <div class="col-md-8 mx-auto">
                     
                
                      <ul class="sidebar-nav">
                   
                   <li class="sidebar-item active my-4">
                       <ul id="dashboards" class="list-unstyled collapse show" >
                           <li class="sidebar-item h4"><a class="sidebar-link" href="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">Personal Information</a></li>
                          
                           <li class="sidebar-item h4"><a class="sidebar-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample1" aria-controls="offcanvasExample1" href="">Password Settings</a></li>

                           <li class="sidebar-item h4"><a class="sidebar-link" href="logout.php">Sign Out</a></li>
                       </ul>
                   </li>
           

               </ul>
                      <div>
                      <div class="offcanvas offcanvas-bottom h-100" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                          <h5 class="offcanvas-title h2" id="offcanvasExampleLabel">Personal Information</h5>
                          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div style="border: 1px solid grey;width:100%" ></div>
                        <div class="offcanvas-body  h4">
                          <div class="card w-100 py-2 ">
                          <div class="position-relative text-center ">
                              <img src="img/avatars/<?php if(isset($avatars)){echo $avatars;}else{echo 'noprofile.png'; } ?>"   id="imgprev" width="120" height="120" style="border-radius:50%" alt="">
                              <label style="" value="" for="file">  <i class="bi bi-pencil-fill position-absolute bottom-0" >  </i>
                            </label>
                        </div>
                        <div class="">
                        <form action="" id="myForm" method="post" enctype="multipart/form-data">
    <input style="opacity:0" class="form-control img-input"  type="file" oninput="enableSubmitButton()" accept="image/*" name="avatars" id="file" value="" onchange="prev(event)">                           
    <div class="py-2">Account # <i class="bi bi-lock-fill text-warning"></i> <input type="text" disabled style="height:40px" class='form-control' value="<?= $acc ?>"></div>
    <div class="py-2">Court/Council <i class="bi bi-lock-fill text-warning"></i> <input style="height:40px" disabled class='form-control' type="text" value="<?= $court ?>"></div>
    <div class="py-2">Full Name <input type="text" name="fullname" style="height:40px" class='form-control' value="<?= $fullname ?>" oninput="enableSubmitButton()"></div>
  
    <div class="py-2">Email
         <input type="text" name="email" style="height:40px" class='form-control' value="<?= $email ?>" oninput="enableSubmitButton()">
</div>
    <div class="py-2">Phone <input type="text" style="height:40px" name="phone" class='form-control' value="<?= $phone ?>" oninput="enableSubmitButton()"></div>
    <div class="py-2">DOB <input class='form-control' style="height:40px" type="date" name="dob" value="<?= $dob ?>" oninput="enableSubmitButton()"></div>

    <button type="submit" name='submit' id="submitButton" disabled class='form-control btn pb-2 btn-success'>Update</button>
</form>



                                        </div>
                                        
                        
                      </div>
                        </div>
                        </div>

                      <div class="offcanvas offcanvas-bottom h-100" tabindex="-1" id="offcanvasExample1" aria-labelledby="offcanvasExampleLabel1">
                        <div class="offcanvas-header">
                          <h5 class="offcanvas-title h2" id="offcanvasExampleLabel1">Password Settings</h5>
                          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div style="border: 1px solid grey;width:100%" ></div>
                        <div class="offcanvas-body  h4">
                          <div class="card w-100 py-2 ">
                          
                        <div class="">
                     
                        <form action="" method="post">
                        
   
    <div class="py-2">Current Password 
        <input required type="password" name="password" style="height:40px" class='form-control' value="" >
    </div>
    <div class="py-2">New Password <input required type="password" name="new_password" style="height:40px" class='form-control' value="" ></div>
    <div class="py-2">Verify Password <input required type="password" name="confirm_password" style="height:40px" class='form-control' value="" ></div>

    <button type="submit" name='change'  class='form-control btn pb-2 btn-success'>Change</button>
</form>



                                        </div>
                                        
                        
                      </div>
                        </div>
                                  </div>
                              </div>
                          </div>
                        </div>

                    </div>
                   
 

                </div>
                
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-4 text-start">
                            <ul class="list-inline">
                              
                                <li class="list-inline-item">
                                    <a class="text-muted" target="_blank" href="https://accraeastcreditunion.org/policy.html">Policies</a>
                                </li>
                             
                                <li class="list-inline-item">
                                    <a class="text-muted" href="tel: +2330240578810">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-8 text-end">
                            <p class="mb-0">
                                &copy; 2023 Powered By - <a href ='mailto:onesolutiongh@gmail.com' class="text-muted"> Onesolutiongh</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="js/app.js"></script>
    <script src="js/settings.js"></script>


                    <script>
                        function enableSubmitButton() {
                            var submitButton = document.getElementById('submitButton');
                            submitButton.disabled = false;
                        }
                        function prev(){
  var img = URL.createObjectURL(event.target.files[0]);
  var  preim = document.getElementById('imgprev');
  preim.src =img;
}
                    </script>

</body>

</html>

