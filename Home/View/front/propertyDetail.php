<?php
include_once('../../Controller/FrontController.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
    header("Location: propertyList.php");
}

$propertyId = base64_decode($_GET['id']);
$property = FrontController::getPropertyById($propertyId);
if (empty($property)) {
  header("Location: propertyList.php");
}

$isInWishList = false;
$wishlistId = 0;
$isCustomerLoggedIn = false;
if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != null) {
    $isCustomerLoggedIn = true;
    $wishlists = FrontController::getCustomerWishList();
    foreach ($wishlists as $wishlist) {
        if ($wishlist['property_id'] == $propertyId  && $wishlist['customer_id'] == $_SESSION['customer_id']) {
            $wishlistId = $wishlist['wishlist_id'];
            $isInWishList = true;
            break;
        }
    }
}

include_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Property Detail </title>

</head>

<body>

<?php if (isset($_SESSION['wishlist_status']) && $_SESSION['wishlist_status'] == 0) {  ?>
		<script>
			Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "Please Try again",
			});
		</script>
		<?php } if (isset($_SESSION['wishlist_status']) && $_SESSION['wishlist_status'] == 1) {?>
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
            <h1 class="title-single"> <?= $property['title']; ?></h1>
            <span class="color-b" style="text-transform: capitalize; font-size:24px; font-style:bold;"><?= $property['city']; ?></span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="property-grid.html">Properties</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
              <?= $property['title']; ?>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <?php
            $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null; //show edit access to only author
            if ($property['customer_id'] == $customer_id) { ?>
            <a href="editProperty.php?id=<?= $_GET['id']; ?>" class="btn btn-a">Edit Property</a> <br> <br><br>
        <?php } ?>
              <?php if ($isCustomerLoggedIn) { ?>
            <?php if ($isInWishList) {
                $action = 'delete_wishlist&property_id='.$propertyId;
                $heart = '<i class="fa fa-heart fa-lg" style="color: red;" aria-hidden="true"></i>';
              } else {
                $action = 'add_wishlist';
                $wishlistId = $propertyId;
                $heart = '<i class="fa fa-heart-o fa-lg" aria-hidden="true"></i>';

            } ?>
              <a href="../../Controller/Controller.php?action=<?= $action;  ?>&id=<?= $wishlistId; ?>" style="float:right;">
              <?= $heart; ?>
              </a> <br> <br><br>
          <?php } else { ?>
              <a href="#" onClick="showLoggedInAlert()" style="float:right;"> 
              <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i>
              </a> <br> <br><br>
          <?php } ?>
        </div>
      </div>
    </div>

  <!--/ Property Single Star /-->
  <section class="property-single nav-arrow-b">
    <div class="container">
      <div class="row">
        <!-- Property Gallery Section  -->

        <div class="col-sm-12">
          <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
          <div class="carousel-item-b" >
              <img src="<?php echo '../assets/img/' . $property['thumbnail']; ?>" alt="" >
            </div>
            <div class="carousel-item-b">
              <img src="<?php echo '../assets/img/' . $property['image1']; ?>" alt="">
            </div>
            <?php if ($property['image2'] != null) { ?> 
            <div class="carousel-item-b">
              <img src="<?php echo '../assets/img/' . $property['image2']; ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($property['image3'] != null) { ?> 
            <div class="carousel-item-b">
              <img src="<?php echo '../assets/img/' . $property['image3']; ?>" alt="">
            </div>
            <?php } ?>
            <?php if ($property['image4'] != null) { ?> 
            <div class="carousel-item-b">
              <img src="<?php echo '../assets/img/' . $property['image4']; ?>" alt="">
            </div>
            <?php } ?>
          </div>
          <!-- Property Quick Summary Section  -->
        <div class="col-md-12">
          <div class="row section-t3">
            <div class="col-sm-12">
              <div class="title-box-d">
                <h3 class="title-d">Quick Summary </h3>
              </div>
              <div class="summary-list">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list">
                            <li class="d-flex justify-content-between">
                                <strong>Price:</strong>
                                <span><?= $property['price'].' BHD' ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>City:</strong>
                                <span><?= $property['city'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Property Type:</strong>
                                <span><?= $property['property_type'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span><?= $property['status'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Area:</strong>
                                <span><?= $property['area'] ?><sup>2</sup></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list">
                            <li class="d-flex justify-content-between">
                                <strong>Baths:</strong>
                                <span><?= $property['bathroom'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Kitchen:</strong>
                                <span><?= $property['kitchen'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Beds:</strong>
                                <span><?= $property['bedroom'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Balcony:</strong>
                                <span><?= $property['balcony'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Location:</strong>
                                <span><?= $property['location'] ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                              <strong>Approval Status:</strong>
                              <?php
                              $approvalStatus = 'Pending';
                                if ((int) $property['visibility'] == 1) {
                                    $approvalStatus = 'Approved';
                                } elseif ((int) $property['visibility'] == 1) {
                                    $approvalStatus = 'Processing';
                                } else {
                                    $approvalStatus = "Pending";
                                }
                                ?>
                              <span><?= $approvalStatus; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-sm-12">
              <div class="title-box-d">
                <h3 class="title-d"> Description </h3>
              </div>
              <div class="property-description">
                <p class="description color-text-a"> <?= html_entity_decode($property['content']); ?></p>
              </div>
            </div>


          <!-- Property Ameneties  Section  -->
          <div class="col-md-12">
          <div class="row section-t3">
            <div class="col-sm-12">
              <div class="title-box-d">
                <h3 class="title-d"> Amenities </h3>
              </div>
              <div class="summary-list">
                <div class="row">
                  <div class="col-md-6">
                    <ul class="list">
                        <?php $amenities = json_decode($property['amenities'], true);?>
                        <li class="d-flex justify-content-between">
                          <strong> 
                            <?php if($amenities['parking'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                            } else {
                              echo '❌ &nbsp;&nbsp;';
                            } ?>
                            Parking
                          </strong>
                        </li>
                        <li class="d-flex justify-content-between">
                          <strong> 
                            <?php if($amenities['swimming_pool'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                            } ?>
                            Swimming Pool
                          </strong>
                        </li>

                        <li class="d-flex justify-content-between">
                          <strong>  
                            <?php if($amenities['ground'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Ground
                          </strong>
                        </li>
                        <li class="d-flex justify-content-between">
                          <strong> 
                            <?php if($amenities['gym'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Gym
                          </strong>
                        </li>
                        <li class="d-flex justify-content-between">
                          <strong>  
                            <?php if($amenities['security'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                          Security
                          </strong>
                        </li> 
                      </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list">
                        <li class="d-flex justify-content-between">
                          <strong>  
                              <?php if($amenities['elevator'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Elevetor
                          </strong>
                          </li>
                          <li class="d-flex justify-content-between">
                            <strong> 
                              <?php if($amenities['garden'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                            Garden </strong>
                          </li>
                          <li class="d-flex justify-content-between">
                            <strong>  
                              <?php if($amenities['cctv'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              CCTV
                            </strong>
                          </li>
                          <li class="d-flex justify-content-between">
                            <strong> 
                              <?php if($amenities['watersupply'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Water Supply
                          </strong>
                          </li>
                          <li class="d-flex justify-content-between">
                            <strong> 
                              <?php if($amenities['powerbackup'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Power Backup 
                              </strong>
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
          </div>

          <!-- Property Faults  Section  -->
          <div class="col-md-12">
          <div class="row section-t3">
            <div class="col-sm-12">
              <div class="title-box-d">
                <h3 class="title-d"> Property Faults </h3>
              </div>
              <div class="summary-list">
                <div class="row">
                  <div class="col-md-6">
                    <ul class="list">
                    <?php $faults = json_decode($property['faults'], true); ?>
                        <li class="d-flex justify-content-between">
                            <strong>  
                            
                              <?php if($faults['foundation'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                          Foundation Damage  </strong>
                          </li>

                          <li class="d-flex justify-content-between">
                            <strong> 
                            
                              <?php if($faults['roof'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                            Roof leaks or damage  </strong>
                          </li>

                          <li class="d-flex justify-content-between">
                            <strong>  
                          
                              <?php if($faults['electrical'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Electrical issues  </strong>
                          </li>

                          <li class="d-flex justify-content-between">
                            <strong>  
                              <?php if($faults['plumbing'] == 1) {
                                echo '✅ &nbsp;&nbsp;';
                              } else {
                                echo '❌ &nbsp;&nbsp;';
                              } ?>
                              Plumbing problems </strong>
                          </li>
                      </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list">
                        <li class="d-flex justify-content-between">
                            <strong> 
                            <?php if($faults['hvac'] == 1) {
                              echo '✅ &nbsp;&nbsp;';
                            } else {
                              echo '❌ &nbsp;&nbsp;';
                            } ?>
                            HVAC Inefficency 
                            </strong>
                        </li>

                        <li class="d-flex justify-content-between">
                          <strong>  
                            <?php if($faults['mold'] == 1) {
                              echo '✅ &nbsp;&nbsp;';
                            } else {
                              echo '❌ &nbsp;&nbsp;';
                            } ?>
                            Mold Pressence 
                            </strong>
                        </li>

                        <li class="d-flex justify-content-between">
                          <strong>   
                            <?php if($faults['pest'] == 1) {
                              echo '✅ &nbsp;&nbsp;';
                            } else {
                              echo '❌ &nbsp;&nbsp;';
                            } ?>
                          Pest Infestation
                          </strong>
                        </li>
                        <li class="d-flex justify-content-between">
                          <strong>  
                            <?php if($faults['windows'] == 1) {
                              echo '✅ &nbsp;&nbsp;';
                            } else {
                              echo '❌ &nbsp;&nbsp;';
                            } ?>
                            Windows or Door Damage
                          </strong>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
          </div>

        <!-- Contact Agent Section -->
        <div class="col-md-12">
          <div class="row section-t3">
            <div class="col-sm-12">
              <div class="title-box-d">
                <h3 class="title-d">Contact Seller</h3>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-lg-4">
            <img src="<?= !empty($property['image_path']) ? '../assets/img/' . $property['image_path'] :
              '../assets/img/customer/default.webp' ?>" alt="" class="agent-avatar img-fluid" id="output">              
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="property-agent">
                <h4 class="title-agent"><?= $property['name']; ?></h4>
                <p class="color-text-a">
                <?= $property['description']; ?>
                </p>
                <ul class="list-unstyled">
                  <li class="d-flex justify-content-between">
                    <strong>Phone:</strong>
                    <span class="color-text-a"><?= $property['phone']; ?></span>
                  </li>
                  <li class="d-flex justify-content-between">
                    <strong>Email:</strong>
                    <span class="color-text-a"><?= $property['email']; ?></span>
                  </li>
                </ul>
                <div class="socials-a">
                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <a href="<?= $property['facebook_profile_url']; ?>">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="<?= $property['twitter_profile_url']; ?>">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="<?= $property['instagram_profile_url']; ?>">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="<?= $property['linkedin_profile_url']; ?>">
                      <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Property Single End /-->
  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <script> 	/*--/ Property owl owl /--*/
	$('#property-single-carousel').owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		navText: ['<i class="ion-ios-arrow-back" aria-hidden="true"></i>', '<i class="ion-ios-arrow-forward" aria-hidden="true"></i>'],
		responsive: {
			0: {
				items: 1,
			}
		}
	});
  </script>
</body>
</html>
