<?php
include 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title> Add City </title>
</head>

<body>
    <!-- Display Success/Error Messages --> 
    <?php if(isset($_SESSION['success']) && $_SESSION['success'] == 0) { ?> 
    <script>
        Swal.fire('Oops', 
        '<?php echo $_SESSION['message']; ?>', 
        'warning');
    </script> 
    <?php } elseif(isset($_SESSION['success']) && $_SESSION['success'] == 1) { ?> 
    <script>
        Swal.fire('Success', 
        'Account Updated Successfully', 
        'success');
    </script> <?php } unset($_SESSION['success']) ?> 
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button"> 
                <i class='bx bx-menu sidebarBtn'></i> 
                <span class="dashboard"> Add City </span> 
            </div>
        </nav>
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <form auto_complete="off" action="../../Controller/Controller.php?admin" method="POST" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td> <b> City Name  </b> </td>
                                <td> <input type="text" required name="name" autocomplete="false" class="admin-fields" 
                                        placeholder="Write City name here"> </td>
                            </tr>
                            <tr>
                                <td> <b> City Description </b> </td>
                                    <td> <textarea id="description" class="admin-textarea" required name="description"> </textarea></td> <
                            </tr>
                            <tr>
                                <td> <b> Image </b> </td>
                                <td>
                                    <p> <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" 
                                            style="display: none;"> </p>
                                    <p> <label for="file" style="cursor: pointer;">Upload Image</label> </p>
                                    <p><img id="output" width="200" /></p>
                                </td>
                            </tr>
                        </table> 
                        <input type="Submit" value="Add City " class="admin-button"> 
                        <input type="hidden" value="add_city" name="action">
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>