<?php 
   include_once('../../Controller/AdminController.php');
   $cityList = AdminController::getAllCities();
//    echo "<pre>"; print_r($cityList); exit;

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
    <title> Manage City </title>
</head>

<body> 
<?php  if(isset($_SESSION['status']) && $_SESSION['status'] == 1) { ?> 
    <script>
        Swal.fire(
            'success',
            'City Added Successfully',
            'success'
        );
    </script> 
<?php } else if(isset($_SESSION['delete_city_status']) && $_SESSION['delete_city_status'] == 1) { ?> 
    <script>
        Swal.fire(
            'City Deleted',
            'City has has been deleted Successfully',
            'success'
        );
    </script> 
<?php } else if(isset($_SESSION['delete_city_status']) && $_SESSION['delete_city_status'] == 0) { ?> 
    <script>
        Swal.fire(
            'Oops',
            'Please Try agian',
            'error'
        );
    </script> 
<?php } unset($_SESSION['status']); unset($_SESSION['delete_city_status']); ?>  
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Manage Cities</span> </div>
            <div class="add-student input-box button"> <a href="addCity.php"> <i class="fa fa-university" aria-hidden="true"></i> &nbsp; Add City </a> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST">
                        <table>
                            <tr>
                                <th> ID </th>
                                <th> Name  </th>
                                <th> Image  </th>
                                <th> Action </th>
                            </tr> 
                        <?php if (empty($cityList)) { ?> <tr>
                                <td colspan="5"> City List is empty </td>
                            </tr> <?php } else { foreach ($cityList as $city) { ?> <tr>
                                <td> <?= $city['city_id'] ?> </td>
                                <td> <?= $city['name'] ?> </td>
                                <?php if ($city['image']) { ?>
                                    <td> <img src="<?= '../assets/img/'.$city['image']; ?>" style="width:100px;" alt="City Thumbnail"> </td>
                                <?php } else { ?>
                                    <td> <img src="../assets/img/city/no-image.png" style="width:100px;"> </td>
                                <?php } ?>
                                <td> 
                                <a href="updateCity.php?id=<?php echo $city['city_id']; ?>&page=product" class="btn btn-info"> View </a> 
                                <a href="../../Controller/Controller.php?admin&action=delete_city&id=<?= $city['city_id']; ?>" class="btn btn-danger"> Delete </a>
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