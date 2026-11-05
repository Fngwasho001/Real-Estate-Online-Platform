<!-- Redirect to admin / customer Index Page -->
<?php
if(isset($_GET['admin_ed2a3efebahr'])) {
    header ("Location: View/admin/login.php");
} else {
    header ("Location: View/front/index.php");
} 