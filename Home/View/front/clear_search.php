<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

if (isset($_SESSION['search_elements']) && !empty($_SESSION['search_elements'])) {
   unset($_SESSION['search_elements']);
}

if (isset($_SESSION['property_ids']) && $_SESSION['search_elements'] != null) {
    unset($_SESSION['property_ids']); 
}
header("Location: propertyList.php");
?>