<?php 
   include_once('../../Controller/AdminController.php');
   $customerList = AdminController::getAllCustomers();
//    echo "<pre>"; print_r($sellerList); exit;

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
include 'header.php';

// if(isset($_SESSION['admin_id'])) {

//    if(isset($_GET['type']) && $_GET['type'] == "bestsale") {
//    } else if(isset($_GET['type']) && $_GET['type'] == "lowstock") {
//       $productsList = AdminController::getLowStockProducts();
//    }else {
//       $productsList = AdminController::getProductsList();
//    }
// } else {
//    header ("Location: login.php");
// }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    </link>
    <title> Manage Customers </title>
</head>

<body> 
<?php  if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 0) { ?> <script>
        Swal.fire(
            'Oops',
            'Please Try Again',
            'warning'
        );
    </script> <?php } else if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 1) { ?> <script>
        Swal.fire(
            'Customer Deleted',
            'Customer Account has been deleted Successfully',
            'success'
        );
    </script> <?php } unset($_SESSION['delete_status']); ?>  
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Manage Customers </span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST">
                        <table>
                            <tr>
                                <th> ID </th>
                                <th> Name  </th>
                                <th> Email </th>
                                <th> Phone </th>
                                <th> Action </th>
                            </tr> <?php 
                     
                     if (empty($customerList)) { ?> <tr>
                                <td colspan="5"> Customer List is empty </td>
                            </tr> <?php } else { foreach ($customerList as $customer) { ?> <tr>
                                <td> <?= $customer['id'] ?> </td>
                                <td> <?= $customer['name'] ?> </td>
                                <td> <?= $customer['email'] ?> </td>
                                <td> <?= $customer['phone'] ?> </td>
                                <td> 
                                <a href="viewCustomer.php?id=<?php echo $customer['id']; ?>&page=product" class="link-btn" style="background:#17a2b8;"> View </a> 
                                <a href="../../Controller/Controller.php?admin&action=delete_customer&id=<?= $customer['id']; ?>" class="link-btn"> Delete </a>
                                </td>
                            </tr> <?php }} ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>