<?php
   include 'header.php';
   include_once('../../Controller/AdminController.php');

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
$seller = AdminController::getSellerById($_GET['id']);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Update Seller </title>
</head>

<body> 
   
   <?php  if(isset($_SESSION['seller_account_status']) && $_SESSION['seller_account_status'] == 0) { ?> <script>
        Swal.fire(
            'Oops',
            'Please Try Again',
            'warning'
        );
    </script> <?php } else if(isset($_SESSION['seller_account_status']) && $_SESSION['seller_account_status'] == 1) { ?> <script>
        Swal.fire(
            'Status Updated',
            'Account Updated Successfully',
            'success'
        );
    </script> <?php } unset($_SESSION['seller_account_status']); ?> 
   
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard"> Update Seller </span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                        <table>
                            <tr>
                                <td> <b> Seller Name </b> </td>
                                <td><?= $seller['name']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Email </b> </td>
                                <td><?= $seller['email']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Address </b> </td>
                                <td><?= $seller['address']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Facebook Url </b> </td>
                                <td><?= $seller['facebook_profile_url']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Instagram Url </b> </td>
                                <td><?= $seller['instagram_profile_url']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Twitter Url </b> </td>
                                <td><?= $seller['twitter_profile_url']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> LinkedIn Url </b> </td>
                                <td><?= $seller['linkedin_profile_url']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Status</b></td>
                                <?php
                                    $status = $seller['account_status'];
                                    if ($status == 1) {
                                        echo '<td style="color: green; font-weight:bold;">Approved</td>';
                                    } else {
                                        echo '<td style="color: red;font-weight:bold;">Not Approved yet</td>';
                                    }
                                ?>
                              
                            </tr>
                        </table> 
                        <br>
                        <?php if ($status != 1) {?>
                            <a href="../../Controller/Controller.php?admin&action=approve_seller&id=<?= $seller['seller_id']; ?>" class="btn btn-primary align-right"> Approve Seller </a>
                        <?php } else { ?>
                            <a href="../../Controller/Controller.php?admin&action=disapprove_seller&id=<?= $seller['seller_id']; ?>" class="btn btn-danger align-right"> DisApprove Seller </a>
                        <?php } ?>
                        <a href="sellerList.php" class="btn btn-dark align-right"> Go Back </a>

                </div>
            </div>
        </div>
    </section>
</body>
</html>