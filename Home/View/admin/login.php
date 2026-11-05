<?php 
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Admin Login </title>
    <link href="../assets/css/admin.css" rel="stylesheet">
    <script src="../assets/js/main.js"></script>
    <script src="../assets/alerts/sweetalert2@11.js"></script>
    <link rel='stylesheet' href='../assets/alerts/sweetalert2.min.css'></link>  
</head>

<body id="authentication"> 
<?php if(isset($_SESSION['login_status']) && $_SESSION['login_status'] == 0){ ?> 
   <script>
        Swal.fire({
            icon: 'error',
            title: 'Invalid Credentials',
            text: 'Invalid Username or Password. Please try again.',
        })
    </script> 
<?php } unset($_SESSION['login_status']); ?> 
    
    <div class="wrapper">
        <h2>Admin Login</h2>
        <form action="../../Controller/Controller.php?admin" autocomplete="off" method="POST">
            <div class="input-box"> 
                <input type="text" placeholder="Enter User Name" required name="user_name" /> 
            </div>
            <div class="input-box"> 
                <input type="password" placeholder="Enter your password" required autocomplete="new-password" name="password" /> 
            </div>
            <div class="input-box button"> 
                <input type="Submit" value="Sign In" /> 
            </div> 
            <input type="hidden" value="admin_login" name="action">
            <div class="text">
                <h3> <a href="#" onClick="ShowForgetMessageAdmin()"> Forget Password ? </a></h3>
            </div>
        </form>
    </div>


</body>

</html>