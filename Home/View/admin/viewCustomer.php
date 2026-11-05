<?php
   include 'header.php';
   include_once('../../Controller/AdminController.php');

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
$customer = AdminController::getUserById($_GET['id']);
if (empty($customer)) {
       header ("Location: customerList.php");
}

// echo "<pre>"; print_r($customer); exit;

// if(isset($_SESSION['admin_id'])) {
//    include_once('../../Controller/AdminController.php');
//    $categoryList = AdminController::getCategoriesList();
//    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
//    $product = AdminController::getProductById($id);

// } else {
//    header ("Location: login.php");
// }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Customer Detail </title>
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
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard"> Customer Detail </span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                        <table>
                            <tr>
                                <td> <b>  Id </b> </td>
                                <td><?= $customer['id']; ?></td>
                            </tr>
                            <tr>
                                <td> <b>  Name </b> </td>
                                <td><?= $customer['name']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Email </b> </td>
                                <td><?= $customer['email']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Description </b> </td>
                                <td><?= $customer['description']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Phone </b> </td>
                                <td><?= $customer['phone']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Secret Answer  </b> </td>
                                <td><?= $customer['secret_answer']; ?></td>
                            </tr>
                            <tr>
                                <td> <b> Image  </b> </td>
                                <td> 
                                    <?php if ($customer['image_path'] != null)  { ?>
                                        <img src= "<?= '../assets/img/'.$customer['image_path']; ?>" alt="image" width="100px">
                                    <?php } else { ?>
                                        <img src= "../assets/img/customer/default.webp" alt="image" width="100px">

                                    <?php } ?>
                                </td>
                            </tr>
                            </tr>
                        </table> 
                        <br>
                        <a href="../../Controller/Controller.php?admin&action=delete_customer&id=<?= $customer['id']; ?>" class="btn btn-danger align-right"> Delete Customer </a>
                        <a href="customerList.php" class="btn btn-dark align-right"> Go Back </a>

                </div>
            </div>
        </div>
    </section>
</body>
</html>