<?php
include_once('../../Controller/FrontController.php');
include_once('searchArea.php');
$sellerStatus = -1;
$seller = FrontController::getSellerByCustomerId();
if (!empty($seller)) {
    $sellerStatus = $seller['account_status'];
}
$current_page = basename($_SERVER['PHP_SELF']);
$propertiesPages = ['property.php', 'propertyList.php','editProperty.php', 'propertyDetail.php', 'searchResult.php', 'seller_properties.php'];
$accountPages = ['account.php','sellerProfile.php','wishlist.php','forgetPassword.php','editSeller.php'];
$helpPages = ['faqs.php','userGuide.php','privacyPolicy.php','cityGuide.php'];
?>
<!DOCTYPE html>
<html lang="en">
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
    <!-- Libraries CSS Files -->
    <link href="../assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link rel='stylesheet' href='../assets/alerts/sweetalert2.min.css'></link>
    <!-- Main Stylesheet File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<!--/ Nav Star /-->
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
                aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <a class="navbar-brand text-brand" href="index.php">Home<span class="color-b">Finder</span></a>
        <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none"
                data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page=='index.php') {echo "active";} ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page=='aboutUs.php') {echo "active";} ?>"" href="aboutUs.php">About</a>
                </li>
                <li class="nav-item">
                <li class="nav-item dropdown <?php if (in_array($current_page,$helpPages )) {echo "active";} ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" role="button" data-toggle="dropdown">Help</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownAccount">
                        <a class="dropdown-item" href="userGuide.php"> <i class="fa fa-question-circle-o" aria-hidden="true"></i> How To Use  </a>
                        <a class="dropdown-item" href="cityGuide.php"> <i class="fa fa-map-marker" aria-hidden="true"></i> City Guides  </a>
                        <a class="dropdown-item" href="privacyPolicy.php"> <i class="fa fa-briefcase" aria-hidden="true"></i> Privacy & Policy  </a>
                        <a class="dropdown-item" href="faqs.php"> <i class="fa fa-question-circle" aria-hidden="true"></i> FAQs  </a>
                    </div>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($current_page=='contact.php') {echo "active";} ?>"" href="contact.php">Contact</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle 
                    <?php if (in_array($current_page,$propertiesPages )) {echo "active";} ?>"
                       href="#"
                       id="navbarDropdownProperty"
                       role="button"
                       data-toggle="dropdown">
                        Property
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownProperty">
                        <a class="dropdown-item" href="propertyList.php"> <i class="fa fa-list" aria-hidden="true"></i> Property List  </a>
                        <a class="dropdown-item <?php if($sellerStatus != 1){echo"disabled";}?>" href="<?php if($sellerStatus != 1){echo"#";}else{echo"property.php";} ?>">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Property
                        </a>
                        <a class="dropdown-item <?php if($sellerStatus != 1){echo"disabled";}?>"
                           href="<?php if($sellerStatus != 1){echo"#";}else{echo"seller_properties.php";} ?>"> <i class="fa fa-home"></i> My Properties  </a>
                    </div>
                </li>
                <li class="nav-item">
                    <?php if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != null){?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownAccount">
                        <a class="dropdown-item" href="account.php"> My Profile <i class="fa fa-user"></i> </a>
                        <a class="dropdown-item" href="wishlist.php"> My WishList <i class="fa fa-heart" aria-hidden="true"></i> </a>
                        <a class="dropdown-item" href="../admin/index.php" target="_blank"> Login as Admin <i class="fa fa-user"></i> </a>
                        <a class="dropdown-item" href="../../Controller/Controller.php?action=logout" > Log Out <i class="fa fa-sign-out" aria-hidden="true"></i> </a>
                    </div>
                </li>
                <?php } else { ?>
                    <a class="nav-link <?php if($current_page=='login.php') {echo "active";} ?>" href="login.php"> Login <i class="fa fa-user"></i> </a>
                <?php } ?>
                </li>
            </ul>
        </div>
        <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block"
                data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
    </div>
</nav>
<!--/ Nav End /-->
<script src="../assets/lib/jquery/jquery.min.js"></script>
<script src="../assets/lib/jquery/jquery-migrate.min.js"></script>
<script src="../assets/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/lib/easing/easing.min.js"></script>
<script src="../assets/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../assets/lib/scrollreveal/scrollreveal.min.js"></script>
<script src="../assets/alerts/sweetalert2@11.js"></script>
<!-- Template Main Javascript File -->
<script src="../assets/js/main.js"></script>
<?php include_once __DIR__ . '/searchArea.php'; ?>
</body>
</html>
