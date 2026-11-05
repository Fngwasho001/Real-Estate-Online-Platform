<?php 
include_once('../../Controller/FrontController.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
}
$sellerStatus = -1;
$user = FrontController::getUserById();
$seller = FrontController::getSellerByCustomerId();
if (!empty ($seller)) {
  $sellerStatus = $seller['account_status'];
}
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Account</title>
</head>
<body>
<?php  if (isset($_SESSION['account_update_status']) && $_SESSION['account_update_status'] == 2) { ?>
  <script>
      Swal.fire({
        title: "Email Not Available?",
        text: "An account with this email address already exists. Please select a different email.",
        icon: "question"
      });
  </script>
<?php }  else if (isset($_SESSION['account_update_status']) && $_SESSION['account_update_status'] == 0) {  ?>
    <script>
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
          footer: 'Please try again'
        });
    </script>

<?php } else if (isset($_SESSION['account_update_status']) && $_SESSION['account_update_status'] == 1) {  ?>
    <script>
        Swal.fire({
          title: "Account Updated!",
          text: "Your account has been updated successfully!",
          icon: "success"
        });
    </script>

<?php } else if (isset($_SESSION['seller_insert_status']) && $_SESSION['seller_insert_status'] == 1) {  ?>
    <script>
        Swal.fire({
          title: "Account Updated!",
          text: "Your Request to become a seller has been submitted successfully!",
          icon: "success"
        });
    </script>

  <?php } else if (isset($_SESSION['seller_insert_status']) && $_SESSION['seller_insert_status'] == 0) {  ?>
    <script>
      Swal.fire({
        title: "Oops...",
        text: "Something went wrong!",
        footer: 'Please try again',
        icon: "error"
      });
  </script>

<?php }  unset($_SESSION['account_update_status']); unset($_SESSION['seller_insert_status']);?>

  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?= $user['name']; ?></h1>
            <span class="color-text-a">Welcome to HomeFinder</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
              <?php if ($sellerStatus == -1) {?>
                <h3> <a href="sellerProfile.php" class="btn btn-a">  Become A Seller  </a> </h3>
              <?php } else { ?>
                <h3> <a href="#" class="btn btn-a" onClick="validateSeller(<?= $sellerStatus;?>)">  Seller Profile  </a> </h3>
              <?php } ?>

              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <section class="agent-single">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
        <form auto_complete="off" onsubmit="return validatePassword();" action="../../Controller/Controller.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-3">
              <div class="agent-avatar-box">
              <img src="<?= !empty($user['image_path']) ? '../assets/img/' . $user['image_path'] : 
              '../assets/img/customer/default.webp' ?>" alt="" class="agent-avatar img-fluid" id="output">
                <div class="form-group">
                    <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;">
                    <p> <label for="file" style="cursor: pointer; color:blue">Upload New Image</label> </p>
                </div>
              </div>
            </div>
            <div class="col-md-8 section-md-t3">
              <div class="agent-info-box">
                <div class="agent-title">
                  <div class="title-box-d">
                    <h3 class="title-d">Profile</h3>
                  </div>
                </div>
                <div class="agent-content mb-3">
                  <div class="info-agents color-a">
                    <p>
                      <strong>Name: </strong>
                      <input type="text" name="customer_name" value="<?= $user['name']; ?>" class="form-control  form-control-a color-text-a" id="inputName" placeholder="Name *" required autocomplete="off">
                    </p>
                    <p>
                      <strong>Email: </strong>
                      <input type="email" name="customer_email" value="<?= $user['email']; ?>" class="form-control  form-control-a" id="inputEmail1" placeholder="Email *" required autocomplete="off">
                    </p>
                    <p>
                      <strong>Phone: </strong>
                      <input type="text" name="customer_phone" value="<?= $user['phone']; ?>" class="form-control form-control-a" id="phone" placeholder="Phone No *" required autocomplete="off">
                    </p>
                    <p>
                      <strong> New Password: </strong>
                      <input type="password" name="customer_password" class="form-control  form-control-a" id="password" placeholder="Password" autocomplete="new-password">
                      <small id="emailHelp" class="form-text text-muted">Leave it blank to use existing password.</small>
                    </p>
                    <p>
                      <strong>Description: </strong>
                      <textarea id="description" name="customer_description" class="form-control" placeholder="Let us know who you are *" name="message" cols="45" rows="5"><?= $user['description']; ?></textarea>
                    </p>
                    <input type="hidden" value="customer_update" name="action">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-a">Update</button>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
  </section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <script>
      function validatePassword() {
        var password = document.getElementById("password").value;
        // Check if password is not empty or null
        if (password.trim() !== "") {
          var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
          if (!pattern.test(password)) {
            Swal.fire({
              title: "Invalid Password Combination",
              text: "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character",
              icon: "question"
            });
            return false; // Prevent form submission
          }
        }
        return true; // Allow form submission
      }

      function validateSeller(sellerStatus) {
        if (sellerStatus == 0) {
          Swal.fire({
              title: "Request Submitted",
              text: "Your request is under process for approval from admin.",
              icon: "question"
            });
        }

        else if (sellerStatus == 2) {
          Swal.fire({
              title: "Request Rejected",
              text: "Your request is rejected by admin",
              icon: "question"
            });
        }

        else if (sellerStatus == 1) {
          window.location.href = 'editSeller.php';

        }

      }      
</script>
</body>
</html>
