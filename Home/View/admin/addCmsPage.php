<?php 
   include 'header.php';

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Add CMS Page </title>
</head>

<body> 
   <?php if(isset($_SESSION['config_success']) && $_SESSION['config_success'] == 0) { ?> <script>
        Swal.fire(
            'Oops',
            '<?php echo $_SESSION['config_message']; ?>',
            'warning'
        );
    </script> <?php } else if(isset($_SESSION['config_success']) && $_SESSION['config_success'] == 1) { ?> <script>
        Swal.fire(
            'Success',
            '<?php echo $_SESSION['config_message']; ?>',
            'success'
        );
    </script> <?php } unset($_SESSION['config_success']);  unset($_SESSION['config_message']); ?> 
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button"> <i class='bx bx-menu sidebarBtn'></i> <span class="dashboard"> Page Content </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST" enctype="multipart/form-data">
                        <div class="title-box-d">
                            <h4> Identifier </h4>
                            <input type="text" required name="identifier" autocomplete="false" class="admin-fields" placeholder="Unique Identifier e.g. about_us">
                        </div>
                        <div class="title-box-d mt-3">
                            <h4> Content </h4>
                            <textarea class="admin-textarea tinymce" required name="content"> </textarea> <br> <br>
                        </div>
                        <input type="hidden" value="add_cms" name="action" />
                        <button type="submit" class="btn btn-primary align-right" > Submit  </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>