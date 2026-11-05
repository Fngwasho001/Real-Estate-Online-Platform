<?php
include_once __DIR__ . '/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> SignUp </title>
</head>
<body>
  <?php if (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 2) { ?>
    <script>
      Swal.fire({
        title: "Email Not Available?",
        text: "An account with this email address already exists. Please select a different email.",
        icon: "question"
      });
    </script>
  <?php } elseif (isset($_SESSION['register_status']) && $_SESSION['register_status'] == 0) { ?>
    <script>
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
          footer: 'Please try again'
        });
    </script>
  <?php } unset($_SESSION['register_status']) ?>
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Sign Up</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="news-single nav-arrow-b">
    <div class="container">
      <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
          <div class="form-comments">
          <form onsubmit="return validateForm();" auto_complete="off" action="../../Controller/Controller.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <div class="form-group">
                          <label for="inputName">Enter name</label>
                          <input type="text" name="customer_name" class="form-control form-control-a" id="inputName" placeholder="Name *" required autocomplete="off">
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="phone">Phone No</label>
                        <input type="text" name="customer_phone" class="form-control form-control-a" id="phone" placeholder="Phone No *" required autocomplete="off" >
                        <small> e.g. +123-4567-7890 </small>
                      </div>
                </div>
                  <div class="col-md-6 mb-3">
                      <div class="form-group">
                          <label for="inputEmail1">Enter email</label>
                          <input type="email" name="customer_email" class="form-control  form-control-a" id="inputEmail1" placeholder="Email *" required autocomplete="off">
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <div class="form-group">
                          <label for="phone">Password</label>
                          <input type="password" id="password" name="customer_password" class="form-control  form-control-a" id="phone" placeholder="Password *" required autocomplete="off">
                          <small> Password should Contain at leaset one Capital, one Small Letter, one Digit and one special Character and must be 8 characters Long. </small>
                        </div>
                  </div>
                  <div class="col-md-12 mb-3">
                      <div class="form-group">
                          <label for="secretQuestion">Secret Question</label>
                          <input type="text" name="customer_answer" class="form-control form-control-a" id="secretQuestion" placeholder="Name of your first Pet *" required autocomplete="off">
                      </div>
                  </div>
                  <div class="col-md-12 mb-3">
                      <div class="form-group">
                          <label for="registered_as">Registered As</label>
                          <select id="registered_as" class="form-select form-control form-control-a" name="registered_as" onchange="toggleSellerFields()">
                              <option value="buyer">Buyer</option>
                              <option value="seller">Seller</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-12 mb-3 sellerFields">
                      <div class="form-group">
                          <label for="customer_address"> Address: </label>
                          <textarea id="address" name="customer_address" class="form-control" placeholder="Your Complete address *" name="address" cols="45" rows="3"></textarea>
                      </div>
                  </div>
                  <div class="col-md-12 mb-3 sellerFields">
                      <div class="form-group">
                        <label for="social_links"> Social Links: (optional) </label>
                          <input type="url" name="facebook_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter facebook profile url"> </br>
                          <input type="url" name="instagram_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Instagram profile url"> </br>
                          <input type="url" name="twitter_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Twitter profile url"> </br>
                          <input type="url" name="linkedin_profile_url"  class="form-control form-control-lg form-control-a" id="phone" placeholder="Enter Linked profile url">                      
                      </div>
                  </div>

                  <div class="col-md-12 mb-3">
                      <div class="form-group">
                          <label for="description" >Description</label>
                          <textarea id="description" name="customer_description" class="form-control" placeholder="Let us know who you are *" name="message" cols="45" rows="5"></textarea>
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <div class="form-group">
                          <label for="profile_image">Profile Image</label>
                          <div class="input-group">
                              <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" class="form-control" style="display: none;">
                              <label for="file" class="input-group-text" style="cursor: pointer;">Choose File</label>
                          </div>
                          <small class="text-muted">Upload a clear image of yourself.</small>
                          <div class="mt-2">
                              <img id="output" width="200" class="img-fluid rounded" alt="Preview Image">
                          </div>
                      </div>
                  </div>
                  <input type="hidden" value="customer_signup" name="action">
                  <div class="col-md-12">
                      <button type="submit" class="btn btn-a">Sign Up</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include_once __DIR__ . '/footer.php'; ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <script>

  function validateForm() {
      var password = document.getElementById("password").value;
      var phone = document.getElementById("phone").value;
      var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
      var phonePattern = /^(\+?(\d{1,3})[-.●\s]?|\(\d{1,3}\)[-.\s]?)(\d{1,3})[-.●\s]?(\d{4})[-.●\s]?(\d{4})$/;
      
      if (!pattern.test(password)) {
          Swal.fire({
              title: "Invalid Password Combination",
              text: "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character'",
              icon: "question"
          });
          return false; 
      } 
      else if (!phonePattern.test(phone)) {
          Swal.fire({
              title: "Invalid Phone No",
              text: "Please Provide a valid phone no",
              icon: "question"
          });
          return false;
      }
      
      return true; 
  }

  function toggleSellerFields() {
        var registeredAs = document.getElementById("registered_as").value;
        var sellerFields = document.querySelectorAll(".sellerFields");

        if (registeredAs === "seller") {
            sellerFields.forEach(function(field) {
                field.style.display = "block";
            });
        } else {
            sellerFields.forEach(function(field) {
                field.style.display = "none";
            });
        }
    }
    toggleSellerFields();
</script>

</body>
</html>
