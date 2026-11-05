<?php 
include_once('../../Controller/FrontController.php');
$areas = FrontController::getAllCities();
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> City Guide </title>
</head>
<body>

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Area Guide</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

<!-- Contact Star -->
<section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php if (empty($areas)) { ?>
                        <div class="col-md-12">
                            <h2>This Blog is Coming Soon..</h2>
                        </div>
                    <?php } else {
                        foreach ($areas as $area) { ?>
                            <div class="col-sm-12">
                                <h1> <?= $area['name'];  ?> </h1>
                            <div class="news-img-box mt-5">
                            <?php if (!$area['image']) { ?>
                                <img src="../assets/img/city/default.jpg" alt="city-image" class="img-b img-fluid" style="width:500px;">
                            <?php } else { ?>
                                <img src="<?= "../assets/img/".$area['image']; ?>" alt="city-image" class="img-b img-fluid" style="width:600px;">
                            <?php } ?>
                            </div>
                            </div>

                            <div class="col-md-12 mt-5">
                                <div class="post-content color-text-a">
                                    <p>
                                        <?= trim($area['description']); ?>
                                    </p>
                                </div>
                            </div>

                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact End -->
<?php include_once __DIR__ . '/footer.php'; ?>
  <!--/ Contact End /-->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
</body>
</html>
