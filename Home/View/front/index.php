<?php 
include_once __DIR__ . '/header.php';
include_once('../../Controller/FrontController.php');
$properties = FrontController::getPropertiesList(3,1); //get Records per page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
</head>
<body>
  <!--/ Carousel Star /-->
  <div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/slide-1.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <h1 class="intro-title mb-4">
                    Explore Finest Properties
                    <p class="intro-subtitle intro-price">
                      <a href="propertyList.php"><span class="price-a" onClick="redirectToListing()"> view more >> </span></a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/slide-2.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
        <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                <div class="intro-body">
                    <h1 class="intro-title mb-4">
                    Explore Finest Properties
                    <p class="intro-subtitle intro-price">
                      <a href="propertyList.php"><span class="price-a" onClick="redirectToListing()"> view more >> </span></a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(../assets/img/slide-3.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
        <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                <div class="intro-body">
                    <h1 class="intro-title mb-4">
                    Explore Finest Properties
                    <p class="intro-subtitle intro-price">
                      <a href="propertyList.php"><span class="price-a" onClick="redirectToListing()"> view more >> </span></a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Carousel end /-->
  <!--/ Property Star /-->
  <section class="section-property section-t8">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="title-wrap d-flex justify-content-between">
            <div class="title-box">
              <h2 class="title-a">Latest Properties</h2>
            </div>
            <div class="title-link">
              <a href="propertyList.php">All Property
                <span class="ion-ios-arrow-forward"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
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
            </div>
        <?php } } ?>
      </div>
    </div>
  </section>
  <!--/ Property End /-->

  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
    <!-- Template Main Javascript File -->
    <script src="../assets/js/main.js"></script>

</body>
</html>
