<?php 
   include_once('../../Controller/FrontController.php');
   $sellerList = FrontController::getAllSellers();

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    </link>
    <title> Manage Sellers </title>
</head>

<body> 
<?php  
if(isset($_SESSION['delete_seller_account_status']) && $_SESSION['delete_seller_account_status'] == 0) { ?> 
    <script>
        Swal.fire(
            'Oops',
            'Please Try Again',
            'warning'
        );
    </script> 
<?php } else if(isset($_SESSION['delete_seller_account_status']) && $_SESSION['delete_seller_account_status'] == 1) { ?> 
    <script>
        Swal.fire(
            'Seller Deleted',
            'Seller Account has been deleted Successfully',
            'success'
        );
    </script> 
<?php } unset($_SESSION['delete_seller_account_status']); ?>  
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Manage Sellers</span> </div>
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
                                <th> Status </th>
                                <th> Action </th>
                            </tr> <?php 
                     
                     if (empty($sellerList)) { ?> <tr>
                                <td colspan="5"> Product List is empty </td>
                            </tr> <?php } else { foreach ($sellerList as $seller) { ?> <tr>
                                <td> <?= $seller['id'] ?> </td>
                                <td> <?= $seller['name'] ?> </td>
                                <td> <?= $seller['email'] ?> </td>
                                <td> <?= $seller['phone'] ?> </td>
                                <td> <?= $seller['account_status'] ?> </td>
                                <td> 
                                <a href="updateSeller.php?id=<?php echo $seller['seller_id']; ?>&page=product" class="link-btn" style="background:#17a2b8;"> View </a> </td>
                            </tr> <?php }} ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>