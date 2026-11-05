<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['customer_id'])) {
  header("Location: login.php");
}
include_once('../../Controller/FrontController.php');
$seller = FrontController::getSellerByCustomerId();
if (empty ($seller)) {
  header("Location: account.php");
}
$properties = FrontController::getPropertiesBySeller($seller['id']);
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Seller Profile</title>
</head>
<body>
<?php if (isset($_SESSION['seller_update_status']) && $_SESSION['seller_update_status'] == 1) {  ?>
    <script>
        Swal.fire({
          title: "Account Updated!",
          text: "Your Seller Profile has been updated successfully!",
          icon: "success"
        });
    </script>

  <?php } else if (isset($_SESSION['seller_update_status']) && $_SESSION['seller_update_status'] == 1) {  ?>
    <script>
      Swal.fire({
        title: "Oops...",
        text: "Something went wrong!",
        footer: 'Please try again',
        icon: "error"
      });
  </script>

<?php } unset($_SESSION['seller_update_status']);?>

  <section class="intro-single"></section>
  <section class="agent-single">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
        <form auto_complete="off"  action="../../Controller/Controller.php" method="POST" enctype="multipart/form-data">
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
                        <textarea id="address" name="customer_address"  class="form-control" placeholder="Your Complete address *" name="address" cols="45" rows="3" required><?= $seller['address']; ?></textarea>
                      </p>
                      <p>
                        <strong> Social Links </strong>
                        <input type="url" name="facebook_profile_url" value="<?= $seller['facebook_profile_url']; ?>" class="form-control  form-control-a" id="phone" placeholder="Enter facebook profile url"> </br>
                        <input type="url" name="instagram_profile_url" value="<?= $seller['instagram_profile_url']; ?>" class="form-control  form-control-a" id="phone" placeholder="Enter Instagram profile url"> </br>
                        <input type="url" name="twitter_profile_url"  value="<?= $seller['twitter_profile_url']; ?>" class="form-control  form-control-a" id="phone" placeholder="Enter Twitter profile url"> </br>
                        <input type="url" name="linkedin_profile_url" value="<?= $seller['linkedin_profile_url']; ?>"  class="form-control  form-control-a" id="phone" placeholder="Enter Linked profile url">
                      </p>
                      <p>
                        <input type="checkbox" name="accept_terms" id="accept_terms" required>
                        <label for="accept_terms" >I accept the terms and conditions</label> <br>
                      </p>
                      <input type="hidden" value="update_seller" name="action">
                      <input type="hidden" value="<?= $seller['id'] ?>" name="seller_id">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-a"> Update Profile </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>

          <!-- My Propert Section  -->
          <div class="col-md-12 section-t8">
          <div class="title-box-d">
            <h3 class="title-d">My Properties  ( <?= count($properties) ?> ) </h3>
          </div>
        </div>

        <?php if (empty($properties)) { ?>
          <h3> Currently you don't have any properties to list.. </h3>
        <?php } else { ?>

        <div class="row property-grid grid">

          <?php foreach ($properties as $property) { ?>
            <div class="col-md-4">
              <div class="card-box-a card-shadow" style="min-height:500px;">
                <div class="img-box-a">
                <img src="<?php echo '../assets/img/' . $property['thumbnail']; ?>" alt="" class="img-a img-fluid" style="min-height:500px;">
                </div>
                <div class="card-overlay">
                  <div class="card-overlay-a-content">
                    <div class="card-header-a">
                      <h2 class="card-title-a">
                        <a href="propertyDetail.php?id=<?= base64_encode($property['id']); ?>"> <?=  $property['title']; ?> </a>
                      </h2>
                    </div>
                    <div class="card-body-a">
                      <div class="price-box d-flex">
                        <span class="price-a"> <?= $property['selling_type']; ?> | BD <?= $property['price'] ?> </span>
                      </div>
                      <a href="propertyDetail.php?id=<?= base64_encode($property['id']); ?>" class="link-a">Click here to view
                        <span class="ion-ios-arrow-forward"></span>
                      </a>
                    </div>
                    <div class="card-footer-a">
                      <ul class="card-info d-flex justify-content-around">
                        <li>
                          <h4 class="card-info-title">Area</h4>
                          <span> <?= $property['area']; ?>
                            <sup>2</sup>
                          </span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Beds</h4>
                          <span><?= $property['bedroom']; ?></span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Baths</h4>
                          <span><?= $property['bathroom']; ?></span>
                        </li>
                        <li>
                          <h4 class="card-info-title">Balcony</h4>
                          <span><?= $property['balcony']; ?></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
</body>
</html>
