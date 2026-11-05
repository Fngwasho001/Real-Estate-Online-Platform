<?php 
   include_once('../../Controller/AdminController.php');
   $cmsPages = AdminController::getAllCMSPages();
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
    <title> Manage CMS Pages </title>
</head>

<body> 
<?php  if(isset($_SESSION['status']) && $_SESSION['status'] == 1) { ?> 
    <script>
        Swal.fire(
            'success',
            'Page Added Successfully',
            'success'
        );
    </script> 
<?php } else if(isset($_SESSION['delete_page_status']) && $_SESSION['delete_page_status'] == 1) { ?> 
    <script>
        Swal.fire(
            'Page Deleted',
            'CMS Page has has been deleted Successfully',
            'success'
        );
    </script> 
<?php } else if(isset($_SESSION['delete_page_status']) && $_SESSION['delete_page_status'] == 0) { ?> 
    <script>
        Swal.fire(
            'Oops',
            'Please Try agian',
            'error'
        );
    </script> 
<?php } unset($_SESSION['status']); unset($_SESSION['delete_page_status']); ?>  
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Manage CMS Pages </span> </div>
            <div class="add-student input-box button"> <a href="addCmsPage.php"> <i class="fa fa-file" aria-hidden="true"></i> &nbsp; Add CMS Page </a> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST">
                        <table>
                            <tr>
                                <th> ID </th>
                                <th> Identifier  </th>
                                <th> Action </th>
                            </tr> 
                        <?php if (empty($cmsPages)) { ?> <tr>
                                <td colspan="5"> CMS Pages List is empty </td>
                            </tr> <?php } else { foreach ($cmsPages as $page) { ?> <tr>
                                <td> <?= $page['id'] ?> </td>
                                <td> <?= $page['identifier'] ?> </td>
                                <td> 
                                <a href="updateCmsPage.php?id=<?php echo $page['id']; ?>" class="btn btn-info"> View </a> 
                                <a href="../../Controller/Controller.php?admin&action=delete_cms&id=<?= $page['id']; ?>" class="btn btn-danger"> Delete </a>
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