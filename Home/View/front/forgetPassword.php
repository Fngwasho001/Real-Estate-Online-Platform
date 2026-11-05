<?php 
include_once __DIR__ . '/header.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
<?php if (isset($_SESSION['forget_password_status']) && $_SESSION['forget_password_status'] == 2) {  ?>
  <script>
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Account with Email and answer combination does not exist.",
        });
    </script>
<?php } else if (isset($_SESSION['forget_password_status']) && $_SESSION['forget_password_status'] == 0) { ?>
  <script>
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
          footer: 'Please try again'
        });
    </script>
<?php }    unset($_SESSION['forget_password_status']); ?>
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"> Forget Password </h1>
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
                <form onsubmit="//return validatePassword();" auto_complete="off" action="../../Controller/Controller.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="inputEmail1">Enter email</label>
                                    <input type="email" class="form-control form-control-a"
                                        id="inputEmail1" name="customer_email" placeholder="Email *" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control  form-control-a"
                                        id="password"  name="customer_password" placeholder="Password *"  required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control  form-control-a"
                                        id="confirmPassword"  placeholder="Password *" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="inputEmail1">Secret Answer</label>
                                    <input type="text" class="form-control  form-control-a"
                                        id="inputEmail1"  name="customer_answer" placeholder="Name of your first Pet *" required>
                                </div>
                            </div>
                            <input type="hidden" value="customer_forget_password" name="action">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-a">Reset Password</button>
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

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/popper/popper.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/scrollreveal/scrollreveal.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>
  <script>
      function validatePassword() {
          var password = document.getElementById("password").value;
          var confirmPassword = document.getElementById("confirmPassword").value;

          // Check if passwords match
          if (password !== confirmPassword) {
              Swal.fire({
                  title: "Passwords Mismatch",
                  text: "Password and Confirm Password do not match.",
                  icon: "error"
              });
              return false; // Prevent form submission
          }

          // Check password pattern
          var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
          if (!pattern.test(password)) {
              Swal.fire({
                  title: "Invalid Password Combination",
                  text: "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character.",
                  icon: "error"
              });
              return false; // Prevent form submission
          }

          return true; // Allow form submission
      }
</script>
</body>
</html>
