<?php
session_start();
unset($_SESSION['secret_code']);
session_destroy();
header("Location:login.php");
exit();
