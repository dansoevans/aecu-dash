<?php 
ob_start();
session_start();
include('config/config.php');
check_login();
$user_id = $_SESSION['user_id'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
   

    <title>AECU | Loan Calculator </title>


  
    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

<body>
    <?=  $msg ?>
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
                           
                            <li class="sidebar-item active"><a class="sidebar-link" href="calculator.php">Loan Calculator</a></li>
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
                        <h1 class="header-title">
                           Loan Calculator
                        </h1>
        

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
                    </div>
                    
             
                    <div class="row">
                   
                        <div class="col-xl-12 col-xxl-5 d-flex">
                            <div class="w-100">
                               
                                  
                                      
                                    
                            <div class="">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Loan Calculator</h3>
                    </div>
                    <div class="card-body  mx-auto">
                      <div class="">
                        <div class="form-group">
                            <label>Loan Amount:</label>
                            <input type="number" id="loan-amount" class="form-control py-2" inputmode="numeric" placeholder="Loan Amount">
                        </div>
                        <div class="form-group mt-2">
                            <label>Interest Rate (%):</label>
                            <input type="number" id="interest-rate" class="form-control py-2" inputmode="numeric" placeholder="Interest Rate">
                        </div>
                        <div class="form-group mt-2">
                            <label>Loan Term (Years):</label>
                            <input type="number" id="loan-term" class="form-control py-2" inputmode="numeric" placeholder="Loan Term">
                        </div>
                        <button type="button" class="btn btn-primary form-control py-2 mt-2" onclick="calculateLoan()">Calculate</button>
                        </div>
                        <div class="mt-3 row">
                          <div class="col-md-4">
                            <h5>Total Interest:</h5>
                            <p id="total-interest">0</p>
                          </div>
                          <div class="col-md-4">
                            <h5>Monthly Payment:</h5>
                            <p id="monthly-payment">0</p>
                            </div>
                          <div class="col-md-4">
                            <h5>Total Payment:</h5>
                            <p id="total-payment">0</p>
                          </div>
                        </div>
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
        function calculateLoan() {
            // Get input values
            let loanAmount = parseFloat(document.getElementById('loan-amount').value);
            let interestRate = parseFloat(document.getElementById('interest-rate').value);
            let loanTerm = parseFloat(document.getElementById('loan-term').value);

            // Calculate monthly payment
            let monthlyInterestRate = (interestRate / 100) / 12;
            let numberOfPayments = loanTerm * 12;
            let monthlyPayment = (loanAmount * monthlyInterestRate) /
                                (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));

            // Calculate total payment and total interest
            let totalPayment = monthlyPayment * numberOfPayments;
            let totalInterest = totalPayment - loanAmount;

            // Update the results
            document.getElementById('monthly-payment').textContent = 'GH₵ ' + monthlyPayment.toFixed(2);
            document.getElementById('total-payment').textContent = 'GH₵ ' + totalPayment.toFixed(2);
            document.getElementById('total-interest').textContent = 'GH₵ ' + totalInterest.toFixed(2);
        }
    </script>

</body>

</html>

