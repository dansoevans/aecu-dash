<?php 
ob_start();
session_start();
include('config/config.php');
check_login();
$user_id = $_SESSION['user_id'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
                         <li class="sidebar-item active"><a class="sidebar-link" href="index.php">Dashboard</a></li>
                         <li class="sidebar-item"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"aria-controls="offcanvasTop"><a class="sidebar-link">Initiate Withdrawal</a></li>
                        
                         <li class="sidebar-item "><a class="sidebar-link" href="calculator.php">Loan Calculator</a></li>
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
<?php 
$qq = mysqli_query($mysqli,"SELECT * FROM users WHERE user_id = '$user_id'");

if(mysqli_num_rows($qq) > 0){
    while($row = mysqli_fetch_assoc($qq)){
$full_name = $row["fullname"];
$name_parts = explode(" ", $full_name);
$first_name = $name_parts[0];
 $acc = $row["acc"];
$savings = $row["savings"];
$loan = $row["loan"];
$shares = $row["shares"];
$court = $row["court"];
$invest = $row["invest"];
}
}
?>

                    <div class="header">
                        <h1 class=" m header-title">
                            Welcome back, <?= $first_name; ?>!
                        </h1>
                        <div class="d-flex justify-content-between">
                        <p class="header-subtitle">Account #: <?= $acc ?></p>
                        <p class="header-subtitle ">Court/Council: <?= $court ?></p>
                        </div>
                    </div>
                    
             
                    <div class="row">
                   
                        <div class="col-xl-12 col-xxl-5 d-flex">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Savings Balance</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i style="font-size:larger" class='bi bi-piggy-bank-fill'></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">GH₵ <?php if($savings == ''){echo 0;} else{echo $savings;} ?></h1>
                                              
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Shares</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i style="font-size:larger" class="bi bi-bank"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">GH₵ <?php if($shares == ''){echo 0;}else{echo $shares;} ?></h1>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Loan Balance</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i style="font-size:larger" class="bi bi-cash"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">GH₵ <?php if($loan == ''){echo 0;}else{echo $loan;} ?></h1>
                                               
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 style="font-size:larger" class="card-title">Accrued Investment</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <div class="avatar-title rounded-circle bg-primary-dark">
                                                                <i class="bi bi-wallet-fill" ></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="display-5 mt-1 mb-3">GH₵ <?php if($invest == ''){echo 0;}else{echo $invest;} ?></h1>
                                               
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


</body>

</html>

