<?php

//Include Required Model Classes
include_once(dirname(__FILE__) . '/../Model/Customer.php');
include_once(dirname(__FILE__) . '/../Model/Seller.php');
include_once(dirname(__FILE__) . '/../Model/Property.php');
include_once(dirname(__FILE__) . '/../Model/ContactLogs.php');
include_once(dirname(__FILE__) . '/../Model/Wishlist.php');
include_once(dirname(__FILE__) . '/../Model/City.php');
include_once(dirname(__FILE__) . '/../Model/Cms.php');
include_once(dirname(__FILE__) . '/../Model/CityOptions.php');

class FrontController
{
    public function initProcess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if($_POST) {
            $this->handlePostRequests();
        }
        if ($_GET) {
            $this->handleGetRequests();
        }
    }

    private function handlePostRequests()
    {
        $action = '';
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        switch ($action) {

            case 'customer_signup':
                $this->registerCustomer();
                break;
            case 'customer_update':
                $this->updateCustomer();
                break;
            case 'customer_login':
                $this->loginCustomer();
                break;
            case 'customer_forget_password':
                $this->recoverCustomerPassword();
                break;
            case 'insert_seller':
                $this->insertSeller(0);
                break;
            case 'update_seller':
                $this->updateSeller();
                break;
            case 'add_property':
                $this->addProperty();
                break;
            case 'update_property':
                $this->updateProperty();
                break;
            case 'contact_us':
                $this->submitContactUs();
                break;
            case 'search_property':
                $this->searchProperty();
                break;
            default:
                header("Location: ../View/front/index.php");
        }
    }

    private function handleGetRequests()
    {
        $action = '';
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
        switch ($action) {

            case 'logout':
                $this->logoutCustomer();
                break;
            case 'customer_forget_password':
                $this->recoverCustomerPassword();
                break;
            case 'add_wishlist':
                $this->addToWishList();
                break;
            case 'delete_wishlist':
                $this->deleteToWishList();
                break;
            case 'delete_property':
                $this->deleteProperty($_GET['id']);
                break;
            default:
                header("Location: ../View/front/index.php");
        }
    }

    private function registerCustomer()
    {
        $userObj = new Customer();
        
        $name = htmlspecialchars($_POST['customer_name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['customer_email'], ENT_QUOTES, 'UTF-8');
        $phoneNo = htmlspecialchars($_POST['customer_phone'], ENT_QUOTES, 'UTF-8');
        $secretAnswer = htmlspecialchars($_POST['customer_answer'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['customer_description'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['customer_password'], ENT_QUOTES, 'UTF-8');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $filePath = '';
        //Move the uploaded file to category folder
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $targetDir = "../View/assets/img/customer/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $filePath = 'customer/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }
        $userObj->name = $name;
        $userObj->email = $email;
        $userObj->phoneNo = $phoneNo;
        $userObj->description = $description;
        $userObj->secretAnswer = $secretAnswer;
        $userObj->image = $filePath;
        $userObj->setPassword($hashed_password);
        try {
            if($userObj->CheckForExistingEmail()) {
                $_SESSION['register_status'] = 2;
                header("Location: ../View/front/signup.php");
            } else {
                if ($userObj->add()) {
                    $userDetail = $userObj->getUserByEmail();
                    if (isset($userDetail['email'])) {
                        $_SESSION['customer_id'] = $userDetail['id'];
                    }
                    if ($_POST['registered_as'] == 'seller') {
                        $this->insertSeller(1);
                        $_SESSION['register_status'] = 3;
                        header("Location: ../View/front/login.php");
                    } else {
                        $_SESSION['register_status'] = 1;
                        header("Location: ../View/front/login.php");
                    }
                }
            }
        } catch(Exception $ex) {
            $_SESSION['register_status'] = 0;
            header("Location: ../View/front/signup.php");
        }
    }

    private function updateCustomer()
    {
        $userObj = new Customer();
        $name = htmlspecialchars($_POST['customer_name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['customer_email'], ENT_QUOTES, 'UTF-8');
        $phoneNo = htmlspecialchars($_POST['customer_phone'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['customer_description'], ENT_QUOTES, 'UTF-8');
        $filePath = '';
        //Move the uploaded file to category folder
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $targetDir = "../View/assets/img/customer/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $filePath = 'customer/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
            $userObj->image = $filePath;
        }
        if ($_POST['customer_password'] != null) {
            $password = htmlspecialchars($_POST['customer_password'], ENT_QUOTES, 'UTF-8');
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $userObj->setPassword($hashed_password);
        }
        $userObj->id = $_SESSION['customer_id'];
        $userObj->name = $name;
        $userObj->email = $email;
        $userObj->phoneNo = $phoneNo;
        $userObj->description = $description;
        try {
            if($userObj->CheckForEmailUpdate()) {
                $_SESSION['account_update_status'] = 2;
                header("Location: ../View/front/account.php");
            } else {
                if ($userObj->update()) {
                    $_SESSION['account_update_status'] = 1;
                    header("Location: ../View/front/account.php");
                }
            }
        } catch(Exception $ex) {
            $_SESSION['account_update_status'] = 0;
            header("Location: ../View/front/account.php");
        }
    }

    private function loginCustomer()
    {
        $userObj = new Customer();
        $email = htmlspecialchars($_POST['customer_email'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['customer_password'], ENT_QUOTES, 'UTF-8');
        $userObj->email = $email;
        $userObj->setPassword($password);
        $data = $userObj->loginUser();
        if(empty($data)) {
            $_SESSION['login_status'] = 0;
            header("Location: ../View/front/login.php");
        } else {
            $_SESSION['customer_id'] = $data['id'];
            header("Location: ../View/front/index.php");
        }
    }

    private function recoverCustomerPassword()
    {
        $userObj = new Customer();
        $email = htmlspecialchars($_POST['customer_email'], ENT_QUOTES, 'UTF-8');
        $secretAnswer = htmlspecialchars($_POST['customer_answer'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['customer_password'], ENT_QUOTES, 'UTF-8');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $userObj->email = $email;
        $userObj->secretAnswer = $secretAnswer;
        $userObj->setPassword($hashed_password);

        try {
            if(!$userObj->confirmSecretAnswer()) {
                $_SESSION['forget_password_status'] = 2;
                header("Location: ../View/front/forgetPassword.php");
            } else {
                if ($userObj->updatePassword()) {
                    $_SESSION['forget_password_status'] = 1;
                    header("Location: ../View/front/login.php");
                }
            }
        } catch(Exception $ex) {
            $_SESSION['forget_password_status'] = 0;
            header("Location: ../View/front/signup.php");
        }
    }

    private function insertSeller($isSignup = 0)
    {
        $sellerObj = new Seller();
        $address = htmlspecialchars($_POST['customer_address'], ENT_QUOTES, 'UTF-8');
        $fbUrl = htmlspecialchars($_POST['facebook_profile_url'], ENT_QUOTES, 'UTF-8');
        $instaUrl = htmlspecialchars($_POST['instagram_profile_url'], ENT_QUOTES, 'UTF-8');
        $twitterUrl = htmlspecialchars($_POST['twitter_profile_url'], ENT_QUOTES, 'UTF-8');
        $linkedInUrl = htmlspecialchars($_POST['linkedin_profile_url'], ENT_QUOTES, 'UTF-8');

        $sellerObj->address = $address;
        $sellerObj->facebookUrl = $fbUrl;
        $sellerObj->instagramUrl = $instaUrl;
        $sellerObj->twitterUrl = $twitterUrl;
        $sellerObj->linkedInUrl = $linkedInUrl;
        $sellerObj->customerId = $_SESSION['customer_id'];

        try {
            if ($sellerObj->add()) {
                if ($isSignup == 1) {
                    return true;
                } else {
                    $_SESSION['seller_insert_status'] = 1;
                    header("Location: ../View/front/account.php");
                }

            }
        } catch(Exception $ex) {

            if ($isSignup == 1) {
                return false;
            } else {
                $_SESSION['seller_insert_status'] = 0;
                header("Location: ../View/front/account.php");
            }
        }
    }

    private function updateSeller()
    {
        $sellerObj = new Seller();
        $address = htmlspecialchars($_POST['customer_address'], ENT_QUOTES, 'UTF-8');
        $fbUrl = htmlspecialchars($_POST['facebook_profile_url'], ENT_QUOTES, 'UTF-8');
        $instaUrl = htmlspecialchars($_POST['instagram_profile_url'], ENT_QUOTES, 'UTF-8');
        $twitterUrl = htmlspecialchars($_POST['twitter_profile_url'], ENT_QUOTES, 'UTF-8');
        $linkedInUrl = htmlspecialchars($_POST['linkedin_profile_url'], ENT_QUOTES, 'UTF-8');

        $sellerObj->address = $address;
        $sellerObj->facebookUrl = $fbUrl;
        $sellerObj->instagramUrl = $instaUrl;
        $sellerObj->twitterUrl = $twitterUrl;
        $sellerObj->linkedInUrl = $linkedInUrl;
        $sellerObj->id = $_POST['seller_id'];
        $sellerObj->customerId = $_SESSION['customer_id'];
        try {
            if ($sellerObj->update()) {
                $_SESSION['seller_update_status'] = 1;
                header("Location: ../View/front/editSeller.php");
            }
        } catch(Exception $ex) {
            $_SESSION['seller_update_status'] = 0;
            header("Location: ../View/front/editSeller.php");
        }
    }

    public function addProperty()
    {
        $obj = new Property();
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $property_type = htmlspecialchars($_POST['property_type'], ENT_QUOTES, 'UTF-8');
        $selling_type = htmlspecialchars($_POST['selling_type'], ENT_QUOTES, 'UTF-8');
        $bathroom = htmlspecialchars($_POST['bathroom'], ENT_QUOTES, 'UTF-8');
        $balcony = htmlspecialchars($_POST['balcony'], ENT_QUOTES, 'UTF-8');
        $kitchen = htmlspecialchars($_POST['kitchen'], ENT_QUOTES, 'UTF-8');
        $hall = htmlspecialchars($_POST['hall'], ENT_QUOTES, 'UTF-8');
        $bedroom = htmlspecialchars($_POST['bedroom'], ENT_QUOTES, 'UTF-8');
        $location = htmlspecialchars($_POST['localtion'], ENT_QUOTES, 'UTF-8');
        $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
        $area = htmlspecialchars($_POST['area'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
        $seller_id = htmlspecialchars($_POST['seller_id'], ENT_QUOTES, 'UTF-8');
        $features = isset($_POST['features']) ? $_POST['features'] : [];
        $faults = isset($_POST['faults']) ? $_POST['faults'] : [];

        $thumbnail = '';
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $targetDir = "../View/assets/img/property/";


        if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["thumbnail"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $thumbnail = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
            $obj->image = $thumbnail;
        }

        if (isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image1"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image1 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile);
            $obj->image1 = $image1;
        }

        if (isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image2"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image2 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile);
            $obj->image2 = $image2;
        }

        if (isset($_FILES["image3"]) && $_FILES["image3"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image3"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image3 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile);
            $obj->image3 = $image3;
        }

        if (isset($_FILES["image4"]) && $_FILES["image4"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image4"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image4 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image4"]["tmp_name"], $targetFile);
            $obj->image4 = $image4;
        }

        $obj->title = $title;
        $obj->content = $content;
        $obj->property_type = $property_type;
        $obj->selling_type = $selling_type;
        $obj->bathroom = $bathroom;
        $obj->hall = $hall;
        $obj->balcony = $balcony;
        $obj->kitchen = $kitchen;
        $obj->bedroom = $bedroom;
        $obj->location = $location;
        $obj->city = $city;
        $obj->area = $area;
        $obj->price = $price;
        $obj->amenities = $this->prepareAmenitiesJson($features);
        $obj->faults = $this->prepareFaultsJson($faults);
        $obj->thumbnail = $thumbnail;
        $obj->image1 = $image1;
        $obj->image2 = $image2;
        $obj->image3 = $image3;
        $obj->image4 = $image4;
        $obj->status = $status;
        $obj->seller_id = $seller_id;

        try {
            if ($obj->add()) {
                $_SESSION['property_add_status'] = 1;
                header("Location: ../View/front/seller_properties.php");
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            exit;
            $_SESSION['property_add_status'] = 0;
            header("Location: ../View/front/property.php");
        }
    }

    private function updateProperty()
    {
        $obj = new Property();
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $property_type = htmlspecialchars($_POST['property_type'], ENT_QUOTES, 'UTF-8');
        $selling_type = htmlspecialchars($_POST['selling_type'], ENT_QUOTES, 'UTF-8');
        $bathroom = htmlspecialchars($_POST['bathroom'], ENT_QUOTES, 'UTF-8');
        $balcony = htmlspecialchars($_POST['balcony'], ENT_QUOTES, 'UTF-8');
        $kitchen = htmlspecialchars($_POST['kitchen'], ENT_QUOTES, 'UTF-8');
        $hall = htmlspecialchars($_POST['hall'], ENT_QUOTES, 'UTF-8');
        $bedroom = htmlspecialchars($_POST['bedroom'], ENT_QUOTES, 'UTF-8');
        $location = htmlspecialchars($_POST['localtion'], ENT_QUOTES, 'UTF-8');
        $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
        $area = htmlspecialchars($_POST['area'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
        $seller_id = htmlspecialchars($_POST['seller_id'], ENT_QUOTES, 'UTF-8');
        $features = isset($_POST['features']) ? $_POST['features'] : [];
        $faults = isset($_POST['faults']) ? $_POST['faults'] : [];
        $thumbnail = '';
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';
        $targetDir = "../View/assets/img/property/";


        if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["thumbnail"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $thumbnail = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
            $obj->thumbnail = $thumbnail;
        }

        if (isset($_FILES["image1"]) && $_FILES["image1"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image1"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image1 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile);
            $obj->image1 = $image1;
        }

        if (isset($_FILES["image2"]) && $_FILES["image2"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image2"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image2 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile);
            $obj->image2 = $image2;
        }

        if (isset($_FILES["image3"]) && $_FILES["image3"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image3"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image3 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile);
            $obj->image3 = $image3;
        }

        if (isset($_FILES["image4"]) && $_FILES["image4"]["error"] == 0) {
            $targetFile = $targetDir . basename($_FILES["image4"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $image4 = 'property/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image4"]["tmp_name"], $targetFile);
            $obj->image4 = $image4;
        }

        $obj->id = $id;
        $obj->title = $title;
        $obj->content = $content;
        $obj->property_type = $property_type;
        $obj->selling_type = $selling_type;
        $obj->bathroom = $bathroom;
        $obj->hall = $hall;
        $obj->balcony = $balcony;
        $obj->kitchen = $kitchen;
        $obj->bedroom = $bedroom;
        $obj->location = $location;
        $obj->city = $city;
        $obj->area = $area;
        $obj->price = $price;
        $obj->amenities = $this->prepareAmenitiesJson($features);
        $obj->faults = $this->prepareFaultsJson($faults);
        $obj->status = $status;
        $obj->seller_id = $seller_id;
        try {
            if ($obj->update()) {
                $_SESSION['property_update_status'] = 1;
                header("Location: ../View/front/editProperty.php?id=".base64_encode($id));
            }
        } catch(Exception $ex) {
            $_SESSION['property_update_status'] = 0;
            header("Location: ../View/front/editProperty.php?id=".base64_encode($id));
        }
    }

    private function deleteProperty($id)
    {
        $obj = new Property();
        $obj->id = $id;
        if ($obj->delete()) {
            $_SESSION['delete_status'] = 1;
            header("Location: ../View/front/seller_properties.php");
        } else {
            $_SESSION['delete_status'] = 0;
            header("Location: ../View/front/seller_properties.php");
        }
    }

    private function prepareAmenitiesJson($amenities)
    {
        $arr =  [
             'parking' => isset($amenities['parking']) ?? 0,
             'swimming_pool' => isset($amenities['swimming_pool']) ?? 0,
             'ground' => isset($amenities['ground']) ?? 0,
             'gym' => isset($amenities['gym']) ?? 0,
             'security' => isset($amenities['security']) ?? 0,
             'elevator' => isset($amenities['elevator']) ?? 0,
             'cctv' => isset($amenities['cctv']) ?? 0,
             'garden' => isset($amenities['garden']) ?? 0,
             'watersupply' => isset($amenities['watersupply']) ?? 0,
             'powerbackup' => isset($amenities['powerbackup']) ?? 0,
         ];
        return json_encode($arr);
    }

    private function prepareFaultsJson($faults)
    {
        $arr = [
            'plumbing' => isset($faults['plumbing']) ?? 0,
            'electrical' => isset($faults['electrical']) ?? 0,
            'foundation' => isset($faults['foundation']) ?? 0,
            'roof' => isset($faults['roof']) ?? 0,
            'hvac' => isset($faults['hvac']) ?? 0,
            'mold' => isset($faults['mold']) ?? 0,
            'pest' => isset($faults['pest']) ?? 0,
            'windows' => isset($faults['windows']) ?? 0,
        ];
        return json_encode($arr);
    }

    private function searchProperty()
    {
        $obj = new Property();
        $keyword = htmlspecialchars($_POST['keyword'], ENT_QUOTES, 'UTF-8');
        $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
        $property_type =  htmlspecialchars($_POST['property_type'], ENT_QUOTES, 'UTF-8');
        $selling_type =  htmlspecialchars($_POST['selling_type'], ENT_QUOTES, 'UTF-8');
        $bedroom = htmlspecialchars($_POST['bedrooms'], ENT_QUOTES, 'UTF-8');
        $bathroom = htmlspecialchars($_POST['bathrooms'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $obj->keyword = $keyword;
        $obj->city = $city;
        $obj->bedroom = $bedroom;
        $obj->bathroom = $bathroom;
        $obj->property_type = $property_type;
        $obj->selling_type = $selling_type;
        $obj->price = $price;
        $query = "";

        try {
            $propertyIds = $obj->search();
            $_SESSION['search_elements'] = [
                'keyword' => $keyword,
                'city' => $city,
                'bathroom' => $bathroom,
                'property_type' => $property_type,
                'selling_type' => $selling_type,
                'bedroom' => $bedroom,
                'price' => $price,
            ];
            $_SESSION['property_ids'] = $propertyIds;
            header("Location: ../View/front/searchResult.php");
        } catch(Exception $ex) {
            $_SESSION['status'] = 0;
            header("Location: ../View/front/propertyList.php");
        }
    }
    private function submitContactUs()
    {
        $obj = new ContactLogs();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        $obj->name = $name;
        $obj->email = $email;
        $obj->subject = $subject;
        $obj->message = $message;
        try {
            if ($obj->add()) {
                $_SESSION['contact_us_status'] = 1;
                header("Location: ../View/front/contact.php");
            }
        } catch(Exception $ex) {
            $_SESSION['contact_us_status'] = 0;
            header("Location: ../View/front/contact.php");
        }
    }

    private function addToWishList()
    {
        $obj = new Wishlist();
        $customer_id = $_SESSION['customer_id'];
        $property_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        $obj->property_id = $property_id;
        $obj->customer_id = $customer_id;
        try {
            if ($obj->add()) {
                $_SESSION['wishlist_status'] = 1;
                $_SESSION['wishlist_message'] = 'Successfully added to your wishlist';

                if (isset($_GET['is_listing']) && $_GET['is_listing'] == 1) {
                    header("Location: ../View/front/propertyList.php");
                    exit;
                }

                header("Location: ../View/front/propertyDetail.php?id=".base64_encode($property_id));
            }
        } catch(Exception $ex) {
            $_SESSION['wishlist_status'] = 0;
            header("Location: ../View/front/propertyDetail.php?id=".base64_encode($property_id));
        }
    }

    private function deleteToWishList()
    {
        // echo "<pre>"; print_r($_GET); exit;
        $obj = new Wishlist();
        $customer_id = $_SESSION['customer_id'];
        $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
        $obj->id = $id;
        $obj->customer_id = $customer_id;
        try {
            if ($obj->delete()) {
                $_SESSION['wishlist_status'] = 1;
                $_SESSION['wishlist_message'] = 'Successfully deleted from your wishlist';
                if (isset($_GET['is_wishlisting']) && $_GET['is_wishlisting'] == 1) {
                    header("Location: ../View/front/wishlist.php");
                    exit;
                } elseif (isset($_GET['is_listing']) && $_GET['is_listing'] == 1) {
                    if (isset($_GET['page'])) {
                        header("Location: ../View/front/propertyList.php?page=".$_GET['page']);
                    } else {
                        header("Location: ../View/front/propertyList.php");
                        exit;
                    }
                } else {
                    header("Location: ../View/front/propertyDetail.php?id=".base64_encode($_GET['property_id']));
                    exit;
                }
            } else {
                $_SESSION['wishlist_status'] = 0;
                header("Location: ../View/front/propertyDetail.php?id=".base64_encode($_GET['property_id']));
            }
        } catch(Exception $ex) {
            $_SESSION['wishlist_status'] = 0;
            header("Location: ../View/front/propertyDetail.php?id=".base64_encode($_GET['property_id']));
        }
    }

    private function logoutCustomer()
    {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }

    public static function getAllCustomers()
    {
        $obj = new Customer();
        return $obj->getAllCustomers();
    }
    public static function getAllSellers()
    {
        $obj = new Seller();
        return $obj->getAllSellers();
    }

    public static function getUserById()
    {
        $obj = new Customer();
        $obj->id = $_SESSION['customer_id'];
        return $obj->getUserById();
    }

    public static function getSellerByCustomerId()
    {
        $obj = new Seller();
        if (isset($_SESSION['customer_id'])) {
            $obj->customerId = $_SESSION['customer_id'];
            return $obj->getSellerByCustomerId();
        }
        return [];
    }

    public static function getPropertiesBySeller($sellerId)
    {
        $obj = new Property();
        $obj->seller_id = $sellerId;
        return $obj->getPropertiesBySeller();
    }
    public static function getPropertyById($id)
    {
        $obj = new Property();
        $obj->id = $id;
        return $obj->getPropertyById();
    }
    public static function getVisibleProperties()
    {
        $obj = new Property();
        return $obj->getVisibleProperties();
    }
    public static function getPropertiesList($pageSize, $pageNo)
    {
        $obj = new Property();
        $obj->pageSize = $pageSize;
        $obj->pageNo = $pageNo;
        return $obj->getPropertiesList();
    }
    public static function getSearchedProperties($propertyIds)
    {
        $obj = new Property();
        $obj->propertyIds = $propertyIds;
        return $obj->getSearchedProperties();
    }
    public static function getChatsBetweenCustomers($receiver_id)
    {
        $obj = new Chats();
        $obj->sender_id = $_SESSION['customer_id'];
        $obj->receiver_id = $receiver_id;
        return $obj->getChatsBetweenCustomers();
    }
    public static function getCustomerWishList()
    {
        if (!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == null) {
            return [];
        }

        $obj = new Wishlist();
        $obj->customer_id = $_SESSION['customer_id'];
        return $obj->getCustomerWishList();
    }
    public static function getWishListByPropertyId($property_id)
    {
        $obj = new Wishlist();
        $obj->customer_id = $_SESSION['customer_id'];
        $obj->property_id = $property_id;
        $result = $obj->getWishListByPropertyId();
        if (!empty($result)) {
            return $result['id'];
        }
        return 0;
    }
    public static function getAllCities()
    {
        $obj = new City();
        return $obj->getAllCities();
    }
    public static function getCMSPageByIdentifier($identifier)
    {
        $obj = new Cms();
        $obj->identifier = $identifier;
        return $obj->getCMSPageByIdentifier();
    }

    public static function getCities(){
        $obj = new CityOptions();
        return $obj->getCities();
    }
}
