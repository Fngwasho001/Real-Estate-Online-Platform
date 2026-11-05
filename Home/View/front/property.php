<?php
include_once('../../Controller/FrontController.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
}
$seller = FrontController::getSellerByCustomerId();
$cities = FrontController::getCities();
if (empty($seller)) {
    header("Location: account.php");
}
if ($seller['account_status'] == 0) {
    header("Location: login.php");
}
include __DIR__ . '/header.php'; 
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title> Add Property </title>
	</head>

	<body>

	<?php if (isset($_SESSION['property_add_status']) && $_SESSION['property_add_status'] == 0) {  ?>
		<script>
			Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "We are unable to add your property, please try again",
			});
		</script>
		<?php } unset($_SESSION['property_add_status']); ?>

		<!--/ Intro Single star /-->
		<section class="intro-single">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-8">
						<div class="title-single-box">
							<h1 class="title-single">Add New Property</h1> <span class="color-text-a"></span> </div>
					</div>
					<div class="col-md-12 col-lg-4">
						<nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"> <a href="index.html">Home</a> </li>
								<li class="breadcrumb-item active" aria-current="page"> Add Property </li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</section>
		<!--/ Intro Single End /-->
		<section class="news-single nav-arrow-b">
			<div class="container">
				<div class="row">
					<div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
						<div class="form-comments">
							<form action="../../Controller/Controller.php" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="title">Title</label>
											<input type="text" name="title" class="form-control form-control-a" id="title" placeholder="Enter a suitable title of your property *" required autocomplete="off" /> </div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="content"> Content: </label>
											<textarea id="content" name="content" class="form-control" cols="45" rows="3"></textarea>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="property_type">Property Type</label>
											<select id="property_type" class="form-select form-control form-control-a" name="property_type">
												<option value="apartment">Apartment</option>
												<option value="flat">Flat</option>
												<option value="building">Building</option>
												<option value="house">House</option>
												<option value="villa">Villa</option>
												<option value="office">Office</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="selling_type">Selling Type</label>
											<select id="selling_type" class="form-select form-control form-control-a" name="selling_type">
												<option value="rent">Rent</option>
												<option value="sale">Sale</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="bathroom">Bathroom</label>
											<input type="number" name="bathroom" class="form-control form-control-a" id="bathroom" 
											placeholder="Enter No of Bathrooms*" required autocomplete="off" min="0" value="1"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="balcony">Balcony</label>
											<input type="number" name="balcony" class="form-control form-control-a" id="balcony"
											 placeholder="Enter No of balcony*" required autocomplete="off" min="0" value="0"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="kitchen">Kitchen</label>
											<input type="number" name="kitchen" class="form-control form-control-a" id="kitchen" 
											placeholder="Enter No of kitchens*" required autocomplete="off" min="0" value="1"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="hall">Hall</label>
											<input type="number" name="hall" class="form-control form-control-a" id="hall" 
											placeholder="Enter No of halls*" required autocomplete="off" min="0" value="1"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="bedroom">Bedrooms</label>
											<input type="number" name="bedroom" class="form-control form-control-a" id="hall" 
											placeholder="Enter No of bedrooms*" required autocomplete="off" min="0" value="1"/> </div>
									</div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="localtion"> Address: </label>
                                            <textarea id="localtion" name="localtion" class="form-control" 
											placeholder="Enter Complete Location *" name="localtion" cols="45" rows="3" required></textarea>
                                        </div>
                                    </div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<hr />
											<h3>Price and Location</h3>
											<hr /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="city">City</label>
											<select id="city" class="form-select form-control form-control-a" name="city">
											<?php foreach ($cities as $city) { ?>
												<option value="<?= $city['value']; ?>"><?= $city['label']; ?></option>
											<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="area">Area</label>
											<input type="number" name="area" class="form-control form-control-a" id="hall" 
											placeholder="Enter area size ( in sqrt )" required autocomplete="off" step="any" min="1"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="price">Price</label>
											<input type="number" name="price" class="form-control form-control-a" id="price" 
											placeholder="Enter No of price*" required autocomplete="off" min="1"/> </div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="price">Features</label>
											<div class="alert alert-info" role="alert">Please select the features included in your property:</div>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="col-md-12">
											<ul style="display: grid; grid-template-columns: repeat(2, 1fr); list-style: none; padding: 0;">
												<li class="mb-3">
												<input type="checkbox" id="parking" value="1" name="features[parking]">
												<label for="parking">Parking</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="swimming-pool" value="1" name="features[swimming_pool]">
												<label for="swimming-pool">Swimming Pool</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="gym" value="1" name="features[gym]">
												<label for="gym">GYM</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="security" value="1" name="features[security]">
												<label for="security">Security</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="elevator" value="1" name="features[elevator]">
												<label for="elevator">Elevator</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="cctv" value="1" name="features[cctv]">
												<label for="cctv">CCTV</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="ground" value="1" name="features[ground]">
												<label for="ground">Play Ground</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="garden" value="1" name="features[garden]">
												<label for="garden">Garden</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="watersupply" value="1" name="features[watersupply]">
												<label for="watersupply">Water Supply</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="powerbackup" value="1" name="features[powerbackup]">
												<label for="powerbackup">Power Backup</label>
												</li>
											</ul>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="Faults">Faults</label>
											<div class="alert alert-warning" role="alert"> Please select any known faults or issues with the property. </div>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="col-md-12">
											<ul style="display: grid; grid-template-columns: repeat(2, 1fr); list-style: none; padding: 0;">
												<li class="mb-3">
												<input type="checkbox" id="foundation" value="1" name="faults[foundation]">
												<label for="foundation">Foundation Damage</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="roof" value="1" name="faults[roof]">
												<label for="roof">Roof leaks or damage</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="electrical-pool" value="1" name="faults[electrical]">
												<label for="electrical">Electrical issues</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="plumbing" value="1" name="faults[plumbing]">
												<label for="plumbing">Plumbing problems</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="hvac" value="1" name="faults[hvac]">
												<label for="hvac">HVAC Inefficency</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="mold" value="1" name="faults[mold]">
												<label for="mold">Mold Pressence</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="pest" value="1" name="faults[pest]">
												<label for="pest"> Pest Infestation </label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="windows" value="1" name="faults[windows]">
												<label for="windows">Paint or wall damage</label>
												</li>
											</ul>
										</div>
										</div
									</div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<hr />
											<h3>Images / Gallery & Status</h3>
											<hr /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="thumbnail">Thumbnail *</label>
											<input type="file" accept="image/*" name="thumbnail" id="file" onchange="loadFile(event,'thumbnail')" class="form-control" required /> <img id="thumbnail" width="200" class="img-fluid rounded" alt="Preview Image" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image1">Image 1 *</label>
											<input type="file" accept="image/*" name="image1" onchange="loadFile(event,'image1')" class="form-control" required /> <img id="image1" width="200" class="img-fluid rounded" alt="Preview Image" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image2">Image 2</label>
											<input type="file" accept="image/*" name="image2" onchange="loadFile(event,'image2')" class="form-control" /> <img id="image2" width="200" class="img-fluid rounded" alt="Preview Image" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image3">Image 3</label>
											<input type="file" accept="image/*" name="image3" onchange="loadFile(event,'image3')" class="form-control" /> <img id="image3" width="200" class="img-fluid rounded" alt="Preview Image" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image3">Image 4</label>
											<input type="file" accept="image/*" name="image4" onchange="loadFile(event,'image4')" class="form-control" /> <img id="image4" width="200" class="img-fluid rounded" alt="Preview Image" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="status">Status</label>
											<select id="status" class="form-select form-control form-control-a" name="status" onchange="toggleSellerFields()">
												<option value="available">Available</option>
												<option value="sold out">Sold Out</option>
											</select>
										</div>
									</div>
									<input type="hidden" value="add_property" name="action" />
									<input type="hidden" value="<?= $seller['id']; ?>" name="seller_id" />
									<div class="col-md-12">
										<button type="submit" class="btn btn-a">Submit Property for Approval</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include_once __DIR__ . '/footer.php'; ?>
		<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
		<div id="preloader"></div>
	</body>
</html>
	</html>