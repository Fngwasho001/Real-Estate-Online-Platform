<?php 
   include_once('../../Controller/AdminController.php');
   $propertyList = AdminController::getAllProperties();

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
    <title> Manage Properties </title>
</head>

<body> 
<?php  
if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 0) { ?> 
    <script>
        Swal.fire(
            'Oops',
            'Please Try Again',
            'warning'
        );
    </script> 
    
    <?php } else if(isset($_SESSION['delete_status']) && $_SESSION['delete_status'] == 1) { ?>
     <script>
        Swal.fire(
            'Property Deleted',
            'Property has been deleted Successfully.',
            'success'
        );
    </script> 
<?php } unset($_SESSION['delete_status']); ?>  
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Manage Properties</span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST">
                        <table>
                            <tr>
                                <th> ID </th>
                                <th> Title  </th>
                                <th> Seller  </th>
                                <th> Visibility Status  </th>
                                <th> Action </th>
                            </tr> 
                        <?php if (empty($propertyList)) { ?> <tr>
                                <td colspan="5"> City List is empty </td>
                            </tr> <?php } else { foreach ($propertyList as $property) { ?> <tr>
                                <td> <?= $property['property_id'] ?> </td>
                                <td> <?= $property['title'] ?> </td>
                                <td> <?= $property['name'] ?> </td>
                                <td> 
                                    <?php if ($property['visibility'] == 1) { ?>
                                        <span style="color:green;"> Approved </span>
                                    <?php } else { ?>
                                        <span style="color:red;"> Pending </span>
                                    <?php } ?>
                                </td>
                                <td>
                                <a href="updateProperty.php?id=<?php echo $property['property_id']; ?>&page=product" class="btn btn-info"> View </a> 
                                <a href="../../Controller/Controller.php?admin&action=delete_property&id=<?= $property['property_id']; ?>" class="btn btn-danger"> Delete </a>
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