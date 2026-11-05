<?php
include_once('../../Controller/FrontController.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
}
$seller = FrontController::getSellerByCustomerId();
if (empty($seller)) {
    header("Location: account.php");
}
if ($seller['account_status'] == 0) {
	header("Location: account.php");
}
$propertyId = base64_decode($_GET['id']);
$property = FrontController::getPropertyById($propertyId);
$cities = FrontController::getCities();

if (empty($property)) {
  header("Location: propertyList.php");
}
if ($property['customer_id'] != $_SESSION['customer_id']) {
    header("Location: propertyList.php");
}
include_once __DIR__ . '/header.php'; 
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title> <?= $property['title']; ?> </title>
	</head>

	<body>

	<?php if (isset($_SESSION['property_update_status']) && $_SESSION['property_update_status'] == 0) {  ?>
		<script>
			Swal.fire({
			icon: "error",
			title: "Oops...",
			text: "We are unable to update your property, please try again",
			});
		</script>
		<?php } if (isset($_SESSION['property_update_status']) && $_SESSION['property_update_status'] == 1) { ?>
		<script>
			Swal.fire({
			title: "Property Updated !",
			text: "Your Property has been updated successfully.",
			icon: "success"
			});
		</script>
	<?php }  unset($_SESSION['property_update_status']);
	 ?>

		<!--/ Intro Single star /-->
		<section class="intro-single">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-8">
						<div class="title-single-box">
							<h1 class="title-single"><?= $property['title']; ?></h1> <span class="color-text-a"></span> </div>
					</div>
					<div class="col-md-12 col-lg-4">
						<nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"> <a href="index.html">Home</a> </li>
								<li class="breadcrumb-item active" aria-current="page"> <?= $property['title']; ?> </li>
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
											<input type="text" name="title" class="form-control form-control-a" id="title" value="<?= $property['title']; ?>" required autocomplete="off" /> </div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="content"> Content: </label>
											<textarea id="content" name="content" class="form-control" cols="45" rows="3"><?= $property['content']; ?></textarea>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="property_type">Property Type</label>
                                            <select id="property_type" class="form-select form-control form-control-a" name="property_type" onchange="toggleSellerFields()">
                                                <option value="apartment" <?php if ($property['property_type'] == 'apartment') echo 'selected'; ?>>Apartment</option>
                                                <option value="flat" <?php if ($property['property_type'] == 'flat') echo 'selected'; ?>>Flat</option>
                                                <option value="building" <?php if ($property['property_type'] == 'building') echo 'selected'; ?>>Building</option>
                                                <option value="house" <?php if ($property['property_type'] == 'house') echo 'selected'; ?>>House</option>
                                                <option value="villa" <?php if ($property['property_type'] == 'villa') echo 'selected'; ?>>Villa</option>
                                                <option value="office" <?php if ($property['property_type'] == 'office') echo 'selected'; ?>>Office</option>
                                            </select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="selling_type">Selling Type</label>
											<select id="selling_type" class="form-select form-control form-control-a" name="selling_type" onchange="toggleSellerFields()">
												<option value="rent" <?php if ($property['selling_type'] == 'rent') echo 'selected'; ?>>Rent</option>
												<option value="sale" <?php if ($property['selling_type'] == 'sale') echo 'selected'; ?>>Sale</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="bathroom">Bathroom</label>
											<input type="number" name="bathroom" class="form-control form-control-a" id="bathroom" 
                                            value="<?= $property['bathroom']; ?>" placeholder="Enter No of Bathrooms*" required autocomplete="off" min="0"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="balcony">Balcony</label>
											<input type="number" name="balcony" class="form-control form-control-a" 
                                            value="<?= $property['balcony']; ?>" id="balcony" placeholder="Enter No of balcony*" required autocomplete="off"  min="0"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="kitchen">Kitchen</label>
											<input type="number" name="kitchen" class="form-control form-control-a" id="kitchen" 
                                            value="<?= $property['kitchen']; ?>" placeholder="Enter No of kitchens*" required autocomplete="off" min="0"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="hall">Hall</label>
											<input type="number" name="hall" class="form-control form-control-a" id="hall" 
                                            value="<?= $property['hall']; ?>" placeholder="Enter No of halls*" required autocomplete="off" min="0"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="bedroom">Bedrooms</label>
											<input type="number" name="bedroom" class="form-control form-control-a" id="hall" 
                                            value="<?= $property['bedroom']; ?>" placeholder="Enter No of bedrooms*" required autocomplete="off" min="0" /> </div>
									</div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="localtion"> Location: </label>
                                            <textarea id="localtion" name="localtion" class="form-control" 
                                             placeholder="Enter Complete Location *" name="localtion" cols="45" rows="3" required><?= $property['location']; ?></textarea>
                                        </div>
                                    </div>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<hr />
											<h3>Price and Location</h3>
											<hr /> </div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="form-group">
										<label for="city">City</label>

										<select class="form-control form-control-lg form-control-a" id="city" name="city">
											<?php foreach ($cities as $row) { ?>
												<option value="<?= $row['value']; ?>" <?php if ($property['city'] == $row['value']) echo 'selected'; ?>><?= $row['label']; ?></option>
											<?php } ?>
										</select>
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="area">Area</label>
											<input type="number" name="area" class="form-control form-control-a" id="hall" value="<?= $property['area']; ?>" 
                                            placeholder="Enter area size ( in sqrt )" required autocomplete="off" step="any" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="price">Price</label>
											<input type="number" name="price" class="form-control form-control-a" id="price" 
                                            value="<?= $property['price']; ?>" placeholder="Enter No of price*" required autocomplete="off" /> </div>
									</div>

									<?php $amenities = json_decode($property['amenities'],true);?>
									<div class="col-md-12 mb-3">
										<div class="form-group">
											<label for="price">Amenities</label>
											<div class="alert alert-info" role="alert">Please select the features included in your property:</div>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="col-md-12">
											<ul style="display: grid; grid-template-columns: repeat(2, 1fr); list-style: none; padding: 0;">
												<li class="mb-3">
												<input type="checkbox" id="parking" value="1" name="features[parking]"
												<?php if($amenities['parking'] == 1) { echo "checked";}  ?>>
												<label for="parking">Parking</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="swimming-pool" value="1" name="features[swimming_pool]"
												<?php if($amenities['swimming_pool'] == 1) { echo "checked";}  ?>>
												<label for="swimming-pool">Swimming Pool</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="gym" value="1" name="features[gym]"
												<?php if($amenities['gym'] == 1) { echo "checked";}  ?>>
												<label for="gym">GYM</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="security" value="1" name="features[security]"
												<?php if($amenities['security'] == 1) { echo "checked";}  ?>>
												<label for="security">Security</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="elevator" value="1" name="features[elevator]"
												<?php if($amenities['elevator'] == 1) { echo "checked";}  ?>>
												<label for="elevator">Elevator</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="cctv" value="1" name="features[cctv]"
												<?php if($amenities['cctv'] == 1) { echo "checked";}  ?>>
												<label for="cctv">CCTV</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="ground" value="1" name="features[ground]"
												<?php if($amenities['ground'] == 1) { echo "checked";}  ?>>
												<label for="ground">Play Ground</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="garden" value="1" name="features[garden]"
												<?php if($amenities['garden'] == 1) { echo "checked";}  ?>>
												<label for="garden">Garden</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="watersupply" value="1" name="features[watersupply]"
												<?php if($amenities['watersupply'] == 1) { echo "checked";}  ?>>
												<label for="watersupply">Water Supply</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="powerbackup" value="1" name="features[powerbackup]"
												<?php if($amenities['powerbackup'] == 1) { echo "checked";}  ?>>
												<label for="powerbackup">Power Backup</label>
												</li>
											</ul>
										</div>
									</div>
									<?php $faults = json_decode($property['faults'],true);?>
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
												<input type="checkbox" id="foundation" value="1" name="faults[foundation]"
												<?php if($faults['foundation'] == 1) { echo "checked";}  ?>>
												<label for="foundation">Foundation Damage</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="roof" value="1" name="faults[roof]"
												<?php if($faults['roof'] == 1) { echo "checked";}  ?>>
												<label for="roof">Roof leaks or damage</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="electrical-pool" value="1" name="faults[electrical]"
												<?php if($faults['electrical'] == 1) { echo "checked";}  ?>>
												<label for="electrical">Electrical issues</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="plumbing" value="1" name="faults[plumbing]"
												<?php if($faults['plumbing'] == 1) { echo "checked";}  ?>>
												<label for="plumbing">Plumbing problems</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="hvac" value="1" name="faults[hvac]"
												<?php if($faults['hvac'] == 1) { echo "checked";}  ?>>
												<label for="hvac">HVAC Inefficency</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="mold" value="1" name="faults[mold]"
												<?php if($faults['mold'] == 1) { echo "checked";}  ?>>
												<label for="mold">Mold Pressence</label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="pest" value="1" name="faults[pest]"
												<?php if($faults['pest'] == 1) { echo "checked";}  ?>>
												<label for="pest"> Pest Infestation </label>
												</li>
												<li class="mb-3">
												<input type="checkbox" id="windows" value="1" name="faults[windows]"
												<?php if($faults['windows'] == 1) { echo "checked";}  ?>>
												<label for="windows">Windows or Door Damage</label>
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
											<input type="file" accept="image/*" name="thumbnail" id="file" onchange="loadFile(event,'thumbnail')" class="form-control"  /> 
                                            <img id="thumbnail" width="200" class="img-fluid rounded" alt="Preview Image" src="<?php echo '../assets/img/' . $property['thumbnail']; ?>" /> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image1">Image 1 *</label>
											<input type="file" accept="image/*" name="image1" onchange="loadFile(event,'image1')" class="form-control"  /> 
                                            <img id="image1" width="200" class="img-fluid rounded" alt="Preview Image" src="<?php echo '../assets/img/' . $property['image1']; ?>"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image2">Image 2</label>
											<input type="file" accept="image/*" name="image2" onchange="loadFile(event,'image2')" class="form-control" />
                                             <img id="image2" width="200" class="img-fluid rounded" alt="Preview Image" src="<?php echo '../assets/img/' . $property['image2']; ?>"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image3">Image 3</label>
											<input type="file" accept="image/*" name="image3" onchange="loadFile(event,'image3')" class="form-control" />
                                             <img id="image3" width="200" class="img-fluid rounded" alt="Preview Image" src="<?php echo '../assets/img/' . $property['image3']; ?>"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="image3">Image 4</label>
											<input type="file" accept="image/*" name="image4" onchange="loadFile(event,'image4')" class="form-control" /> 
                                            <img id="image4" width="200" class="img-fluid rounded" alt="Preview Image" src="<?php echo '../assets/img/' . $property['image4']; ?>"/> </div>
									</div>
									<div class="col-md-6 mb-3">
										<div class="form-group">
											<label for="status">Status</label>
											<select id="status" class="form-select form-control form-control-a" name="status" onchange="toggleSellerFields()">
												<option value="available" <?php if ($property['status'] == 'available') echo 'selected'; ?>>Available</option>
												<option value="sold out" <?php if ($property['status'] == 'available') echo 'selected'; ?>>Sold Out</option>
											</select>
										</div>
									</div>
									<input type="hidden" value="update_property" name="action" />
									<input type="hidden" value="<?= $seller['id']; ?>" name="seller_id" />
									<input type="hidden" value="<?= $propertyId; ?>" name="id" />
									<div class="col-md-12">
										<button type="submit" class="btn btn-a">Update Property</button>
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