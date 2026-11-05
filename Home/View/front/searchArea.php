<?php 
include_once('../../Controller/FrontController.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$keyword = '';
$city = '';
$prop_type = 'any';
$selling_type = 'any';
$bedrooms = 'any';
$bathroom = 'any';
$price = 'any';
$searchElements = [];
if (isset($_SESSION['search_elements']) && !empty($_SESSION['search_elements'])) {
  $searchElements = $_SESSION['search_elements'];

  if (isset($searchElements['keyword']) && $searchElements['keyword'] != null) {
    $keyword = $searchElements['keyword'];
  }
  if (isset($searchElements['city']) && $searchElements['city'] != null) {
    $city = $searchElements['city'];
  }
  if (isset($searchElements['property_type'])) {
    $prop_type = $searchElements['property_type'];
  }
  if (isset($searchElements['bedroom'])) {
    $bedrooms = $searchElements['bedroom'];
  }
  if (isset($searchElements['bathroom'])) {
    $bathroom = $searchElements['bathroom'];
  }
  if (isset($searchElements['price'])) {
    $price = $searchElements['price'];
  }
  if (isset($searchElements['selling_type'])) {
    $selling_type = $searchElements['selling_type'];
  }
}
$cities = FrontController::getCities();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <script src="../assets/lib/jquery/jquery.min.js"></script>

  <script>
  $(document).ready(function() {
    $(document).on("click", ".warning-button", function() {
        // Clear form fields
        $("input[name='keyword']").val('');
        $("select[name='property_type']").val('any');
        $("select[name='selling_type']").val('any');
        $("select[name='city']").val('any');
        $("select[name='bedrooms']").val('any');
        $("select[name='bathrooms']").val('any');
        $("select[name='price']").val('any');
        $.ajax({
          url: 'clear_search.php', 
          type: 'POST',
          success: function(response) {
            //
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });

    });
  });
</script>

</head>
  <div class="click-closed"></div>
  <!--/ Form Search Star /-->
  <div class="box-collapse">
    <div class="title-box-d">
      <h3 class="title-d">Search Property</h3>
    </div>
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
    <div class="box-collapse-wrap form">
      <form class="form-a" action="../../Controller/Controller.php" method="POST">
        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label for="Type">Keyword</label>
              <input type="text" class="form-control form-control-lg form-control-a" placeholder="Keyword" name="keyword" value="<?= $keyword; ?>">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="Type"> Property Type</label>
              <select class="form-control form-control-lg form-control-a" id="Type" name="property_type">
                <option value="any" <?php if ($prop_type == 'any') echo 'selected'; ?>>Any</option>
                <option value="apartment" <?php if ($prop_type == 'apartment') echo 'selected'; ?>>Apartment</option>
								<option value="flat" <?php if ($prop_type == 'flat') echo 'selected'; ?>>Flat</option>
								<option value="building" <?php if ($prop_type == 'building') echo 'selected'; ?>>Building</option>
								<option value="house" <?php if ($prop_type == 'house') echo 'selected'; ?>>House</option>
								<option value="villa" <?php if ($prop_type == 'villa') echo 'selected'; ?>>Villa</option>
								<option value="office" <?php if ($prop_type == 'office') echo 'selected'; ?>>Office</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="Type"> Selling Type </label>
              <select class="form-control form-control-lg form-control-a" id="Type" name="selling_type">
                <option value="any" <?php if ($prop_type == 'any') echo 'selected'; ?>>Any</option>
                <option value="sale" <?php if ($selling_type == 'sale') echo 'selected'; ?>>Buy</option>
                <option value="rent" <?php if ($selling_type == 'rent') echo 'selected'; ?>>Rent</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="city">City</label>

              <select class="form-control form-control-lg form-control-a" id="city" name="city">
                <?php foreach ($cities as $row) { ?>
									<option value="<?= $row['value']; ?>" <?php if ($city == $row['value']) echo 'selected'; ?>><?= $row['label']; ?></option>
							  <?php } ?>
              </select>
              </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="bedrooms">Bedrooms</label>
              <select class="form-control form-control-lg form-control-a" id="bedrooms" name="bedrooms">
                <option value="any" <?php if ($bedrooms == 'any') echo 'selected'; ?>>Any</option>
                <option value="1" <?php if ($bedrooms == '1') echo 'selected'; ?>>01</option>
                <option value="2" <?php if ($bedrooms == '2') echo 'selected'; ?>>02</option>
                <option value="3" <?php if ($bedrooms == '3') echo 'selected'; ?>>03</option>
                <option value="4" <?php if ($bedrooms == '4') echo 'selected'; ?>>04</option>
                <option value="5" <?php if ($bedrooms == '5') echo 'selected'; ?>>05</option>
                <option value="6" <?php if ($bedrooms == '6') echo 'selected'; ?>>06</option>
                <option value="7" <?php if ($bedrooms == '7') echo 'selected'; ?>>07</option>
                <option value="8" <?php if ($bedrooms == '8') echo 'selected'; ?>>08</option>
                <option value="9" <?php if ($bedrooms == '9') echo 'selected'; ?>>09</option>
                <option value="10" <?php if ($bedrooms == '10') echo 'selected'; ?>>10</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="bathrooms">Bathrooms</label>
              <select class="form-control form-control-lg form-control-a" id="bathrooms" name="bathrooms">
                <option value="any" <?php if ($bathroom == 'any') echo 'selected'; ?>>Any</option>
                <option value="1" <?php if ($bathroom == '1') echo 'selected'; ?>>01</option>
                <option value="2" <?php if ($bathroom == '2') echo 'selected'; ?>>02</option>
                <option value="3" <?php if ($bathroom == '3') echo 'selected'; ?>>03</option>
                <option value="4" <?php if ($bathroom == '4') echo 'selected'; ?>>04</option>
                <option value="5" <?php if ($bathroom == '5') echo 'selected'; ?>>05</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="price">Price</label>
              <select class="form-control form-control-lg form-control-a" id="price" name="price">
                    <option value="any" <?php if ($price == 'any') echo 'selected'; ?>>Any</option>
                    <?php
                    $start_price = 10000;
                    $end_price = 8000000;
                    $increment = 10000;

                    for ($i = $start_price; $i <= $end_price; $i += $increment) {
                        echo '<option value="' . $i . '"';
                        if ($price == $i) {
                            echo ' selected';
                        }
                        echo '>' . number_format($i) . '</option>';
                    }
                    ?>
                </select>

            </div>
          </div>
          <div class="col-md-12">
            <input type="hidden" value="search_property" name="action">
            <button type="submit" class="btn btn-b">Search Property</button>
            <button type="button" class="btn btn-warning warning-button"> Reset </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--/ Form Search End /-->
</body>
</html>
