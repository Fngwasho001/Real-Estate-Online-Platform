<?php
include_once __DIR__ . '/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> Log In </title>
</head>
<body>
<?php if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == 0) {  ?>
  <script>
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Invalid Email or Password Please Try again!",
    });
  </script>
<?php } if (isset($_SESSION['forget_password_status']) && $_SESSION['forget_password_status'] == 1) { ?>
<script>
    Swal.fire({
      title: "Account Updated!",
      text: "Your password has been updated successfully!",
      icon: "success"
    });
</script>

<?php } if (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 1) {  ?>
  <script>
    Swal.fire({
      title: "Account Created!",
      text: "Your Account has been created successfully.Please Login to your account.",
      icon: "success"
    });
</script>
<?php } if (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 3) {  ?>
<script>
  Swal.fire({
    title: "Request Submitted",
    text: "Your request is under process for approval from admin. Please Login to your account.",
    icon: "question"
  });
</script>

<?php } if (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 0) {  ?>
  <script>
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "We have got an issue,Please Try again!",
    });
  </script>
<?php }  unset($_SESSION['login_status']);unset($_SESSION['forget_password_status']);  unset($_SESSION['register_status']); ?>

  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Sign In</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="news-single nav-arrow-b">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
                <div class="form-comments">
                <form  auto_complete="off" action="../../Controller/Controller.php" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="inputEmail1">Enter email</label>
                                    <input type="email" class="form-control  form-control-a"
                                        id="inputEmail1" placeholder="Email *" name="customer_email" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="phone">Password</label>
                                    <input type="password" class="form-control  form-control-a"
                                        id="phone" placeholder="Password *" name="customer_password" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <a href="signup.php" >Don't have an account?</a>
                                <a href="forgetPassword.php" style="float: right;">Forget Password?</a>
                            </div>

                            <input type="hidden" value="customer_login" name="action">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-a">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <!-- Template Main Javascript File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>
