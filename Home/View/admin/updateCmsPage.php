<?php 
   include 'header.php';
   include_once('../../Controller/AdminController.php');

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
$id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
$page = AdminController::getCmsPageById($id);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Update CMS </title>
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
            'Page Updated',
            'CMS Page has been updated successfully',
            'success'
        );
    </script> <?php } unset($_SESSION['status']); ?> 
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard"> About Us Page Content </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST" enctype="multipart/form-data">
                        <div class="title-box-d">
                            <h4> Identifier </h4>
                            <input type="text" required name="identifier" 
                            value = "<?= $page['identifier']; ?>" autocomplete="false" class="admin-fields" placeholder="Unique Identifier e.g. about_us">
                        </div>
                        <div class="title-box-d mt-3">
                            <h4> Content </h4>
                            <textarea class="admin-textarea tinymce" required name="content"> <?= html_entity_decode($page['content']); ?> </textarea> <br> <br>
                        </div>
                        <input type="hidden" value="update_cms" name="action" />
                        <input type="hidden" value="<?= $page['id']; ?>" name="id" />
                        <button type="submit" class="btn btn-primary align-right" > Update  </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>