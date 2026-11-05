<?php
  include_once('../../Controller/FrontController.php');
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = filter_var($page, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)));
  if ($page === false) {
      $page = 1;
  }

  $totalpoints = FrontController::getVisibleProperties();   
  $recordsPerPage = 6;
  $isInWishList = false;
  $wishlistPropertyIds = [];
  $isCustomerLoggedIn = false;
  if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != null) {
      $isCustomerLoggedIn = true;
      $wishlists = FrontController::getCustomerWishList();
      $wishlistPropertyIds = array_column($wishlists,'property_id');
  }
  $properties = FrontController::getPropertiesList($recordsPerPage, $page); 
  unset($_SESSION['property_ids']); 
  include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Property List </title>
</head>

<body> 

<?php if (isset($_SESSION['wishlist_status']) && $_SESSION['wishlist_status'] == 1) {?>
		<script>
			Swal.fire({
			title: "WishList Updated",
			text: "<?= $_SESSION['wishlist_message']; ?>",
			icon: "success"
			});
		</script>
<?php } unset($_SESSION['wishlist_status']);
unset($_SESSION['wishlist_message']);  ?>

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Our Amazing Properties</h1>
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
                <?php if ($isCustomerLoggedIn) { ?>
                <?php if (in_array($property['id'],$wishlistPropertyIds)) {
                    $action = 'delete_wishlist&property_id='.$property['id'];
                    $id = FrontController::getWishListByPropertyId($property['id']);
                    $text = "Remove from WishList";
                    $class = 'btn btn-danger';
                  } else {
                    $action = 'add_wishlist';
                    $wishlistId = $property['id'];
                    $id = $property['id'];
                    $text = "Add to WishList";
                    $class = 'btn btn-info';
                } ?>
                  <a href="../../Controller/Controller.php? is_listing=1&action=<?= $action;?>&id=<?=$id;?>&page=<?= $page ?>" 
                  class="<?= $class; ?>" style="float:right; margin-top:-10px; margin-bottom:50px;">
                  <?= $text; ?>
                  </a> 
              <?php } else { ?>
                  <a href="#"  onClick="showLoggedInAlert()" 
                  class="btn btn-info" style="float:right; margin-top:-10px; margin-bottom:10px;">
                  Add to wishlist
                </a>
              <?php } ?>

              </div>
        <?php } } ?>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <nav class="pagination-a">
            <ul class="pagination justify-content-end">
              <?php
                $totalPages = ceil($totalpoints / $recordsPerPage);
                for ($i = 1; $i <= $totalPages; $i++) {
                    // Append the search term to the pagination links
                    $paginationLink = "propertyList.php?page=$i";
                    if (!empty($searchTerm)) {
                        $paginationLink .= "&search=" . urlencode($searchTerm);
                    }
                    echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='$paginationLink'>$i</a></li>";
                }
                ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <!--/ Property Grid End /-->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
</body>
</html>
