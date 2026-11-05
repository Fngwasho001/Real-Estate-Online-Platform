<?php 
include_once('../../Controller/AdminController.php');
include 'header.php';

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

   $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
   $city = AdminController::getCityById($id);
    // echo "<pre>"; print_r($city); exit;

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
   
   <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 0) { ?> <script>
        Swal.fire(
            'Oops',
            'Please Try again',
            'warning'
        );
    </script> <?php } else if(isset($_SESSION['status']) && $_SESSION['status'] == 1) { ?> <script>
        Swal.fire(
            'City Updated',
            'City has been updated successfully',
            'success'
        );
    </script> <?php } unset($_SESSION['status']); ?> 
    
   <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard">Dashboard</span> </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td> <b> City Name  </b> </td>
                                <td> <input type="text" required name="name" autocomplete="false" class="admin-fields" 
                                        placeholder="Write City name here" value="<?= $city['name'] ?>"> </td>
                            </tr>
                            <tr>
                                <td> <b> City Description </b> </td>
                                    <td> <textarea id="description" class="admin-textarea"  name="description">
                                        <?= $city['description']; ?> </textarea></td> 
                            </tr>
                            <tr>
                                <td> <b> Image </b> </td>
                                <td>
                                    <p><input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" 
                                        style="display: none;"></p>
                                    <p><label for="file" style="cursor: pointer;"> Upload New Image </label></p>
                                    <p>
                                        <?php if ($city['image']) { ?>
                                            <img id="output" width="200" src="<?php echo "../assets/img/".$city['image'] ?>" />
                                        <?php } else { ?>
                                            <img id="output" width="200" src="<?php echo "../assets/img/city/no-image.png" ?>" />
                                        <?php } ?>
                                    
                                    </p>
                                </td>
                            </tr>
                        </table> 
                        <input type="hidden" value="update_city" name="action"> 
                        <input type="hidden" value="<?php echo $city['city_id']; ?>" name="city_id">
                        <input type="Submit" value="Update City" class="admin-button"> 
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>