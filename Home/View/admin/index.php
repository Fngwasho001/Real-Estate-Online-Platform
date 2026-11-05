<?php

include_once('../../Controller/AdminController.php');
include 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$adminObj = new AdminController();
$report = $adminObj->quickReport();

$customers = isset($report['customers']) ? $report['customers'] : 0;
$sellers = isset($report['sellers']) ? $report['sellers'] : 0;
$properties = isset($report['properties']) ? $report['properties'] : 0;
$cities = isset($report['cities']) ? $report['cities'] : 0;
$pages = isset($report['pages']) ? $report['pages'] : 0;
$feedback = isset($report['feedback']) ? $report['feedback'] : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> DashBoard </title>
</head>

<body>
    <section class="home-section">
        <div class="home-content">
            <div class="sales-boxes">
                <div class="recent-sales box">
                    <div class="container">
                        <div class="row">
                            <h2> Quick Summary </h2>
                            <div class="container mt-5">
                            <div class="col-lg-3 col-sm-12">
                                <div class="card-box bg-blue">
                                    <div class="inner">
                                        <p> Total Users </p>
                                        <h1> <?= $customers ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-user-circle-o"></i> </div> 
                                    <a href="customerList.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card-box bg-orange">
                                    <div class="inner">
                                        <p> Total Sellers </p>
                                        <h1> <?= $sellers ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-address-book" aria-hidden="true"></i> </div> 
                                    <a href="sellerList.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card-box bg-green">
                                    <div class="inner">
                                        <p> Total Properties </p>
                                        <h1> <?= $properties ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-home" aria-hidden="true"></i> </div> 
                                    <a href="propertyList.php" class="card-box-footer">View More <i class="fa fa-home" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card-box bg-green">
                                    <div class="inner">
                                        <p> Total Feedback </p>
                                        <h1> <?= $feedback ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-envelope-open" aria-hidden="true"></i> </div> 
                                    <a href="contactList.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card-box bg-blue">
                                    <div class="inner">
                                        <p> Total Cities Guide </p>
                                        <h1> <?= $cities ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-university" aria-hidden="true"></i> </div> 
                                    <a href="cityList.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card-box bg-orange">
                                    <div class="inner">
                                        <p> Total CMS Pages </p>
                                        <h1> <?= $pages ?> </h1>
                                    </div>
                                    <div class="icon"> <i class="fa fa-file" aria-hidden="true"></i> </div> 
                                    <a href="cmsPages.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>
</html>