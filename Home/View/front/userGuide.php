<?php 
include_once('../../Controller/FrontController.php');
$cms = FrontController::getCMSPageByIdentifier('user_guide');
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> About Us </title>
</head>
<body>

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">User Guide</h1>
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
                    <?php if (empty($cms)) { ?>
                        <div class="col-md-12">
                            <h2>This Blog is Coming Soon..</h2>
                        </div>
                    <?php } else { ?>
                            <div class="col-md-12">
                                <div class="post-content color-text-a">
                                    <p>
                                        <?=  html_entity_decode( $cms['content'] ); ?>
                                    </p>
                                </div>
                            </div>
                   <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact End -->
<?php include_once __DIR__ . '/footer.php';  ?>
  <!--/ Contact End /-->
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
</body>
</html>