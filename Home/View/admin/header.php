<?php

if (session_status() === PHP_SESSION_NONE) {
   session_start();
 }
 
 if (!isset($_SESSION['admin_id'])) {
   header("Location: login.php");
 }

$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
   <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Bootstrap CSS File -->
    <link href="../assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel='stylesheet' href='../assets/alerts/sweetalert2.min.css'></link>  
    <link href="../assets/css/admin.css" rel="stylesheet">
   </head>
   <body>
<div class="sidebar">
         <div class="logo-details">
           <a href="index.php"> <i class="fa fa-home" aria-hidden="true"></i><span class="logo_name">HomeFinder</span></i></a>
         </div>
         <ul class="nav-links" class="sidebar_active">
            <li>
               <a href="index.php" <?php if ($current_page == "index.php") { ?> class="active" <?php } ?>>
               <i class="fa fa-home" aria-hidden="true"></i>
               <span class="links_name">Dashboard</span>
               </a>
            </li>
            <li>
               <a href="customerList.php" 
               <?php if (in_array($current_page,['customerList.php','updateCustomer.php'])) { ?> class="active" <?php } ?>>
               <i class="fa fa-user-circle-o"></i>
                  <span class="links_name"> Manage Users </span>
               </a>
            </li>
            <li>
            <a href="sellerList.php" 
            <?php if (in_array($current_page,['sellerList.php','updateSeller.php'])) { ?> class="active" <?php } ?>>
            <i class="fa fa-address-book" aria-hidden="true"></i>
                  <span class="links_name">Manage Sellers</span>
               </a>
            </li>
            <li>
               <a href="propertyList.php"
               <?php if (in_array($current_page,['propertyList.php','updateProperty.php'])) { ?> class="active" <?php } ?>>
               <i class="fa fa-building" aria-hidden="true"></i>
                  <span class="links_name"> Manage Properties </span>
               </a>
            </li>
            <li>
               <a href="cityList.php"
               <?php if (in_array($current_page,['cityList.php','updateCity.php','addCity.php'])) { ?> class="active" <?php } ?>>
               <i class="fa fa-map-marker" aria-hidden="true"></i>
                  <span class="links_name"> Manage City Guides </span>
               </a>
            </li>
            <li>
               <a href="cmsPages.php"
               <?php if (in_array($current_page,['cmsPages.php','updateCmsPage.php','addCmsPage.php'])) { ?> class="active" <?php } ?>>
               <i class="fa fa-file" aria-hidden="true"></i>
                  <span class="links_name"> Manage CMS </span>
               </a>
            </li>    
            <li>
               <a href="contactList.php"
               <?php if (in_array($current_page,['contactList.php','viewContact.php'])) { ?> class="active" <?php } ?>>
               <i class="fa fa-envelope-open" aria-hidden="true"></i>
                  <span class="links_name"> Manage Feedbacks </span>
               </a>
            </li> 
            
            <li class="log_out">
            <a href="../../Controller/Controller.php?action=logout&admin">
               <i class="fa fa-sign-out"></i>
               <span class="links_name">Log out</span>
               </a>
            </li>
         </ul>
      </div>

    <!-- JavaScript Libraries -->
    <script src="../assets/lib/jquery/jquery.min.js"></script>
    <script src="../assets/lib/jquery/jquery-migrate.min.js"></script>
    <script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/lib/easing/easing.min.js"></script>
    <script src="../assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../assets/lib/scrollreveal/scrollreveal.min.js"></script>
    <script src="../assets/alerts/sweetalert2@11.js"></script>
    <script src="../assets/plugins/tinymce/tinymce.min.js"></script>
    <script src="../assets/plugins/tinymce/init-tinymce.min.js"></script>
    <!-- Template Main Javascript File -->
    <script src="../assets/js/main.js"></script>
      </body>
</html>