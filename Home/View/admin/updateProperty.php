<?php 
include_once('../../Controller/AdminController.php');
include 'header.php';

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
   
$id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
$property = AdminController::getPropertyById($id);
// echo "<pre>"; print_r($property); exit;

// if(isset($_SESSION['admin_id'])) {
//    include 'header.php';
//    include_once('../../Controller/AdminController.php');
//    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
//    $category = AdminController::getCategoryById($id);
//    if(empty($category)) {
//       header ("Location: category.php?page=category");
//    }
// } else {
//    header ("Location: login.php");
// }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Dashboard </title>
</head>

<body> 
   
   <?php if(isset($_SESSION['property_update_status']) && $_SESSION['property_update_status'] == 0) { ?> <script>
        Swal.fire(
            'Oops',
            'Please Try again',
            'warning'
        );
    </script> <?php } else if(isset($_SESSION['property_update_status']) && $_SESSION['property_update_status'] == 1) { ?> <script>
        Swal.fire(
            'Property Updated',
            'Property has been updated successfully',
            'success'
        );
    </script> <?php } unset($_SESSION['property_update_status']); ?> 
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Dashboard</span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST" enctype="multipart/form-data">
                        <table>

                        <div class="title-box-d">
                         <center><hr> <h4> <?= $property['title']; ?> </h4><hr> </center>
                        </div>
                            <!-- Quick Summary section starts here -->
                            <div class="title-box-d">
                            <hr>    <h4> Quick Summary </h4>  <hr>
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
                                        <li class="d-flex justify-content-between">
                                            <strong>Beds:</strong>
                                            <span><?= $property['bedroom'] ?></span>
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
                            <!-- Quick Summary section ends here -->

                            <!-- Features section starts here -->
                            <div class="title-box-d">
                            <hr>     <h4> Amenities </h4>  <hr>
                                </div>

                            <div class="summary-list">
                            <?php $amenities = json_decode($property['amenities'], true);
                                if (!empty($amenities)) {
                            ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong> Parking: </strong>
                                        <h4>
                                            <?php if($amenities['parking'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong> Swimming Pool: </strong>
                                        <h4>
                                            <?php if($amenities['swimming_pool'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong> Ground: </strong>
                                        <h4>
                                            <?php if($amenities['ground'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                        <strong> Gym: </strong>
                                        <h4>
                                            <?php if($amenities['gym'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                        <strong> Security: </strong>
                                        <h4>
                                            <?php if($amenities['security'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong> Elevetor: </strong>
                                        <h4>
                                            <?php if($amenities['elevator'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                        
                                        <li class="d-flex justify-content-between">
                                        <strong> Garden: </strong>
                                        <h4>
                                            <?php if($amenities['garden'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong> CCTV: </strong>
                                        <h4>
                                            <?php if($amenities['cctv'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong> Water Supply: </strong>
                                        <h4>
                                            <?php if($amenities['watersupply'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong> Power Backup: </strong>
                                        <h4>
                                            <?php if($amenities['powerbackup'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                    </ul>
                                    </div>
                                </div>

                             </div>
                            <?php } ?>
                            <!-- Features section ends here -->

                            <!-- Faults / Damege section starts here -->
                            <div class="title-box-d">
                            <hr>     <h4> Faults / Damage </h4>  <hr>
                                </div>

                            <div class="summary-list">
                            <?php $faults = json_decode($property['faults'], true);
                                if (!empty($faults)) {
                            ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <ul class="list">
                                        <li class="d-flex justify-content-between">
                                        <strong>  Foundation Damage : </strong>
                                        <h4>
                                            <?php if($faults['foundation'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong>  Roof leaks or damage : </strong>
                                        <h4>
                                            <?php if($faults['roof'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong>  Electrical issues : </strong>
                                        <h4>
                                            <?php if($faults['electrical'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong>  Plumbing problems : </strong>
                                        <h4>
                                            <?php if($faults['plumbing'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong>  HVAC Inefficency : </strong>
                                        <h4>
                                            <?php if($faults['hvac'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>  Mold Pressence : </strong>
                                        <h4>
                                            <?php if($faults['mold'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>

                                        <li class="d-flex justify-content-between">
                                        <strong>  Pest Infestation : </strong>
                                        <h4>
                                            <?php if($faults['pest'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                        <strong>  Windows or Door Damage : </strong>
                                        <h4>
                                            <?php if($faults['windows'] == 1) {
                                                echo '<i class="fa fa-check" style="color: green;"></i>';
                                            } else {
                                                echo '<i class="fa fa-times-circle" style="color: red;"></i>';
                                            } ?>
                                        </h4>
                                    </li>
                                    </ul>
                                    </div>
                                </div>

                             </div>
                            <?php } ?>
                            <!-- Faults / Damage section ends here -->


                            <!-- Seller Info -->
                            <div class="title-box-d">
                            <hr>   <h4> Seller Info </h4>  <hr>
                                </div>

                            <div class="summary-list">
                                <div class="row">
                                <div class="col-md-12">
                                <ul class="list">
                                <li class="d-flex justify-content-between">
                                    <strong>Name:</strong>
                                    <span><?= $property['name'] ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Email:</strong>
                                    <span><?= $property['email'] ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Phone:</strong>
                                    <span><?= $property['phone'] ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Address:</strong>
                                    <span><?= $property['address'] ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Approval Status:</strong>
                                    <?php
                                    $approvalStatus = 'Pending';
                                    if ((int) $property['account_status'] == 1) {
                                        $approvalStatus = 'Approved';
                                     }else {
                                            $approvalStatus = "Pending";
                                    }
                                    ?>
                                    <span><?= $approvalStatus; ?></span>
                                    </li>
                                    </ul>
                                </div>
                             </div>
                            <!-- Seller Info Ends Here -->

                            <div class="title-box-d">
                                 <hr>   <h4> Images and Gallery </h4>  <hr>
                                </div>
                            <div class="summary-list">
                                <div class="row">
                                <div class="col-md-12">
                                <img src="<?php echo '../assets/img/' . $property['thumbnail']; ?>" alt="Thumbnail" width="500px" style="border: 1px solid black; padding:10px">
                                <img src="<?php echo '../assets/img/' . $property['image1']; ?>" alt="Image1" width="500px" style="border: 1px solid black;">
                                <img src="<?php echo '../assets/img/' . $property['image2']; ?>" alt="Image2" width="500px" style="border: 1px solid black;">
                                <img src="<?php echo '../assets/img/' . $property['image3']; ?>" alt="Image3" width="500px" style="border: 1px solid black;">
                                <img src="<?php echo '../assets/img/' . $property['image4']; ?>" alt="Image4" width="500px" style="border: 1px solid black;">
                                </div>
                             </div>
                            </table> 

                        <div class="title-box-d">
                            <hr> <h4> Visibility Status </h4>  <hr>
                        </div>

                            <div class="summary-list">
                                <div class="row">
                                <div class="col-md-6">
                                <select class="dropdown_custom" name="visibility_status">
                                    <option value="0" <?php if ($property['visibility'] == 0 ) {echo "selected";} ?> > Pending </option>
                                    <option value="1" <?php if ($property['visibility'] == 1 ) {echo "selected";} ?> > Approved </option>
                                </select>
                                </div>
                             </div>
                        <div class="title-box-d">
                            <hr> <h4> Comment </h4>  <hr>
                        </div>
                             <div class="summary-list">
                                <div class="row">
                                <div class="col-md-12">
                                    <textarea class="form-control" name = "comment" id="comment" rows="3"> <?= $property['comment']; ?></textarea>
                                </div>
                             </div>

                        </table> 
                        <input type="hidden" value="update_property" name="action"> 
                        <input type="hidden" value="<?= $id; ?>" name="property_id">
                        <input type="Submit" value="Update Property" class="admin-button"> 
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>