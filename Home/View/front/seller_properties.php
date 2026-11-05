<?php
  include_once('../../Controller/FrontController.php');
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
  }

  $seller = FrontController::getSellerByCustomerId();
  if (empty ($seller)) {
    header("Location: account.php");
  }

  $properties = FrontController::getPropertiesBySeller($seller['id']);
  if (!empty($properties)) {
    $totalProperties = count($properties);
  } else {
    $totalProperties = 0;
  }
  include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Property List </title>
</head>

<body>
<?php if (isset($_SESSION['property_add_status']) && $_SESSION['property_add_status'] == 1) { ?>
		<script>
			Swal.fire({
			title: "Property Added !",
			text: "Your Property has been added successfully for admin approval.",
			icon: "success"
			});
		</script>
	<?php }  unset($_SESSION['property_add_status']);?>
<?php if (isset($_SESSION['wishlist_status']) && $_SESSION['wishlist_status'] == 0) {  ?>
		<script>
			Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "Please Try again",
			});
		</script>
		<?php } if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 0) { ?> 
    <script>
        Swal.fire(
            'Oops',
            'Please Try Again',
            'warning'
        );
    </script> 
    
    <?php } else if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 1) { ?>
     <script>
        Swal.fire(
            'Property Deleted',
            'Property has been deleted Successfully.',
            'success'
        );
    </script> 
<?php } unset($_SESSION['delete_status']); unset($_SESSION['property_add_status']);?>  

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"> My Properties List (<?= $totalProperties; ?>) </h1>
            <span class="color-text-a">Grid Properties</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Properties Grid
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Grid Star /-->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <?php if (empty($properties)) { ?>
          <h3> No Properties Available </h3>
        <?php } else { 
          foreach ($properties as $property) {  ?>
              <div class="col-md-4">
              <a href="#" class="btn btn-danger" 
              onclick="showConfirmation(<?php echo htmlspecialchars(json_encode($property), ENT_QUOTES, 'UTF-8'); ?>)">Delete</a>
                <div class="card-box-a card-shadow" style="min-height:500px;">

                  <?php if ($property['visibility'] == 1) { ?>
                    <a href="" class="wishlist-link" style="color:green; font-size:20px; background:white; border:1px solid green:">
                      Approved
                    </a> 
                <?php } else { ?>
                    <a href="#" onClick="" class="wishlist-link" style="color:orange; font-size:20px;background:white; border:1px solid orange:"> 
                      Pending
                    </a> 
                <?php } ?>

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
                <a href="#" class="btn btn-info" style="float:right; margin-top:-30px !important" onClick="showComment('<?=trim($property['comment']);?>')">
                View Comment
                </a>
              </div>
        <?php } } ?>
      </div>
    </div>
  </section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <!--/ Property Grid End /-->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <script>
      function showConfirmation(property) {
          Swal.fire({
              title: "Are you sure?",
              text: "Please confirm if you want to delete property titled '" + property.title + "'",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
          }).then((result) => {
              if (result.isConfirmed) {
                  // Perform the redirection
                  window.location.href = "../../Controller/Controller.php?action=delete_property&id="+property.id;
              }
          });
      }

      function showComment(comment) {
        if (comment == '') {
          comment = "You don't have any comment yet from admin.";
        }
        Swal.fire({
          title: "Property Comment",
          text: ""+comment,
          icon: "question"
        });
      }

  </script>
</body>
</html>
