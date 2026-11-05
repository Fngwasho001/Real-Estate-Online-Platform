<?php 
   include_once('../../Controller/AdminController.php');
   $logs = AdminController::getAllLogs();

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    </link>
    <title> Manage Feedbacks </title>
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
            'Log Deleted',
            'Feedback has been deleted Successfully.',
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
                                <th> Subject </th>
                                <th> Action </th>
                            </tr> <?php 
                     
                     if (empty($logs)) { ?> <tr>
                                <td colspan="5"> Feedback List is empty </td>
                            </tr> <?php } else { foreach ($logs as $log) { ?> <tr>
                                <td> <?= $log['id'] ?> </td>
                                <td> <?= $log['name'] ?> </td>
                                <td> <?= $log['email'] ?> </td>
                                <td> <?= $log['subject'] ?> </td>
                                <td> 
                                <a href="viewContact.php?id=<?php echo $log['id']; ?>&page=product" class="link-btn" style="background:#17a2b8;"> View </a> 
                                <a href="../../Controller/Controller.php?admin&action=delete_contact&id=<?= $log['id']; ?>" class="link-btn"> Delete  </a>
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