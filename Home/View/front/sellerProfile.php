<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
}
include_once('../../Controller/FrontController.php');
$user = FrontController::getUserById();
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Seller Profile</title>
</head>
<body>
  <section class="intro-single"></section>
  <section class="agent-single">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
        <form auto_complete="off"  action="../../Controller/Controller.php" method="POST">
            <div class="row">
              <div class="col-md-12 section-md-t3">
                <div class="agent-info-box">
                  <div class="agent-title">
                    <div class="title-box-d">
                      <h3 class="title-d">Seller Profile</h3>
                    </div>
                  </div>
                  <div class="agent-content mb-3">
                    <div class="info-agents color-a">
                      <p>
                        <strong>Address: </strong>
                        <textarea id="address" name="customer_address" class="form-control" placeholder="Your Complete address *" name="address" cols="45" rows="3" required></textarea>
                      </p>
                      <p>
                        <strong> Social Links </strong>
                        <input type="url" name="facebook_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter facebook profile url"> </br>
                        <input type="url" name="instagram_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Instagram profile url"> </br>
                        <input type="url" name="twitter_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Twitter profile url"> </br>
                        <input type="url" name="linkedin_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Linked profile url">
                      </p>
                      <p>
                        <input type="checkbox" name="accept_terms" id="accept_terms" required>
                        <label for="accept_terms" >I accept the terms and conditions</label> <br>
                      </p>
                      <input type="hidden" value="insert_seller" name="action">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-a">Submit Request</button>
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
</body>
</html>
