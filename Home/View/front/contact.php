<?php 
include_once __DIR__ . '/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Contact Us </title>
</head>
<body>

<?php if (isset($_SESSION['contact_us_status']) && $_SESSION['contact_us_status'] == 1) { ?>
  <script>
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Your Query has been submitted successfully. We will Try to contact you shortly",
      showConfirmButton: false,
      timer: 2500
    });
  </script>
  <?php } else if (isset($_SESSION['contact_us_status']) && $_SESSION['contact_us_status'] == 0) {  ?>
    <script>
      Swal.fire({
        title: "Oops...",
        text: "Something went wrong!",
        footer: 'Please try again',
        icon: "error"
      });
  </script>

<?php }  unset($_SESSION['contact_us_status']);?>


  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="title-single-box">
            <h1 class="title-single">Contact US</h1>
            <span class="color-text-a">
            At Home Finder, we're committed to providing exceptional service and support to our valued customers. Whether you have questions about
             our properties, need assistance with your account, or have feedback to share, we're here to help.
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Contact Star /-->
  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-12">
              <form class="form-a contactForm" method="POST" role="form" action="../../Controller/Controller.php">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input type="text" name="name" class="form-control form-control-lg form-control-a" placeholder="Your Name" required>
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input name="email" type="email" class="form-control form-control-lg form-control-a" placeholder="Your Email" required>
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="form-group">
                      <input type="text" name="subject" class="form-control form-control-lg form-control-a" placeholder="Subject" required>
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="form-group">
                      <textarea name="message" class="form-control" name="message" cols="45" rows="8" required></textarea>
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                  <input type="hidden" name="action" value="contact_us">
                    <button type="submit" class="btn btn-a">Send Message</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Contact End /-->

  <?php include_once __DIR__ . '/footer.php';  ?>

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

</body>
</html>
