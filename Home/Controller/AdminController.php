<?php

//Include Required Model Classes
include_once(dirname(__FILE__) . '/../Model/Customer.php');
include_once(dirname(__FILE__) . '/../Model/Admin.php');
include_once(dirname(__FILE__) . '/../Model/Seller.php');
include_once(dirname(__FILE__) . '/../Model/Property.php');
include_once(dirname(__FILE__) . '/../Model/ContactLogs.php');
include_once(dirname(__FILE__) . '/../Model/City.php');
include_once(dirname(__FILE__) . '/../Model/Cms.php');
include_once(dirname(__FILE__) . '/../Model/CityOptions.php');


class AdminController
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
            case 'add_city':
                $this->insertCity();
                break;
            case 'update_city':
                $this->updateCity();
                break;
            case 'admin_login':
                $this->loginAdmin();
                break;
            case 'add_cms':
                $this->addCmsPage();
                break;
            case 'update_cms':
                $this->updateCmsPage();
                break;
            case 'update_property':
                $this->updatePropertyStatus();
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

            case 'approve_seller':
                $this->updateSellerStatus($_GET['id'], 1);
                break;
            case 'disapprove_seller':
                $this->updateSellerStatus($_GET['id'], 0);
                break;
            case 'delete_seller':
                $this->deleteSeller($_GET['id']);
                break;
            case 'delete_city':
                $this->deleteCity($_GET['id']);
                break;
            case 'delete_customer':
                $this->deleteCustomer($_GET['id']);
                break;
            case 'delete_contact':
                $this->deleteFeedback($_GET['id']);
                break;
            case 'delete_property':
                $this->deleteProperty($_GET['id']);
                break;
            case 'delete_cms':
                $this->deleteCms($_GET['id']);
                break;
            case 'logout':
                $this->logoutAdmin();
                break;
            default:
                header("Location: ../View/front/index.php");
        }
    }

    private function updateSellerStatus($seller_id, $status)
    {
        $obj = new Seller();
        $obj->id = $seller_id;
        $obj->account_status = $status;
        if ($obj->updateSellerStatus()) {
            $_SESSION['seller_account_status'] = 1;
            header("Location: ../View/admin/updateSeller.php?id=".$seller_id."&page=product");
        } else {
            $_SESSION['seller_account_status'] = 0;
            header("Location: ../View/admin/updateSeller.php?id=".$seller_id."&page=product");
        }
    }

    private function deleteSeller($seller_id)
    {
        $obj = new Seller();
        $obj->id = $seller_id;
        if ($obj->deleteSeller()) {
            $_SESSION['delete_seller_account_status'] = 1;
            header("Location: ../View/admin//product.php?page=product");
        } else {
            $_SESSION['delete_seller_account_status'] = 0;
            header("Location: ../View/admin//product.php?page=product");
        }
    }

    private function deleteCustomer($id)
    {
        $obj = new Customer();
        $obj->id = $id;
        if ($obj->delete()) {
            $_SESSION['delete_status'] = 1;
            header("Location: ../View/admin/customerList.php?page=customer");
        } else {
            $_SESSION['delete_status'] = 0;
            header("Location: ../View/admin//customerList.php?page=customer");
        }
    }

    private function deleteFeedback($id)
    {
        $obj = new ContactLogs();
        $obj->id = $id;
        if ($obj->delete()) {
            $_SESSION['delete_status'] = 1;
            header("Location: ../View/admin/contactList.php?page=customer");
        } else {
            $_SESSION['delete_status'] = 0;
            header("Location: ../View/admin//contactList.php?page=customer");
        }
    }

    private function deleteProperty($id)
    {
        $obj = new Property();
        $obj->id = $id;
        if ($obj->delete()) {
            $_SESSION['delete_status'] = 1;
            header("Location: ../View/admin/propertyList.php?page=customer");
        } else {
            $_SESSION['delete_status'] = 0;
            header("Location: ../View/admin//propertyList.php?page=customer");
        }
    }

    private function deleteCity($city_id)
    {
        $obj = new City();
        $obj->city_id = $city_id;
        if ($obj->deleteCity()) {
            $_SESSION['delete_city_status'] = 1;
            header("Location: ../View/admin/cityList.php");
        } else {
            $_SESSION['delete_city_status'] = 0;
            header("Location: ../View/admin//cityList.php");
        }
    }

    private function insertCity()
    {
        $obj = new City();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $filePath = '';
        //Move the uploaded file to category folder
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $targetDir = "../View/assets/img/city/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $filePath = 'city/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }
        $obj->name = $name;
        $obj->description = $description;
        $obj->image = $filePath;
        try {
            if ($obj->add()) {
                $_SESSION['status'] = 1;
                header("Location: ../View/admin/cityList.php");
                exit;
            } else {
                $_SESSION['status'] = 0;
                header("Location: ../View/admin/addCity.php");
                exit;
            }
        } catch(Exception $ex) {
            $_SESSION['status'] = 0;
            header("Location: ../View/admin/addCity.php");
            exit;
        }
    }

    private function addCmsPage()
    {

        $obj = new Cms();
        $identifier =  htmlspecialchars($_POST['identifier'], ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $obj->identifier = $identifier;
        $obj->content = $content;
        try {
            if ($obj->add()) {
                $_SESSION['status'] = 1;
                header("Location: ../View/admin/cmsPages.php");
                exit;
            }
        } catch(Exception $ex) {
            $_SESSION['status'] = 0;
            header("Location: ../View/admin/addCmsPage.php");
            exit;
        }
    }

    private function updateCmsPage()
    {
        $obj = new Cms();
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $identifier = htmlspecialchars($_POST['identifier'], ENT_QUOTES, 'UTF-8');

        $obj->id = $id;
        $obj->identifier = $identifier;
        $obj->content = $content;
        try {
            if ($obj->update()) {
                $_SESSION['status'] = 1;
                header("Location: ../View/admin/updateCmsPage.php?id=".$id);
                exit;
            } else {
                $_SESSION['status'] = 0;
                header("Location: ../View/admin/updateCmsPage.php?id=".$id);
                exit;
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            exit;
            $_SESSION['status'] = 0;
            header("Location: ../View/admin/updateCmsPage.php?id=".$id);
            exit;
        }
    }

    private function deleteCms($id)
    {
        $obj = new Cms();
        $obj->id = $id;
        if ($obj->delete()) {
            $_SESSION['delete_page_status'] = 1;
            header("Location: ../View/admin/cmsPages.php");
        } else {
            $_SESSION['delete_page_status'] = 0;
            header("Location: ../View/admin/cmsPages.php");
        }
    }

    private function updateCity()
    {
        $obj = new City();
        $city_id = htmlspecialchars($_POST['city_id'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $filePath = '';
        //Move the uploaded file to category folder
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $targetDir = "../View/assets/img/city/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '.' . $imageFileType;
            $filePath = 'city/'.$uniqueFilename;
            $targetFile = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }
        $obj->name = $name;
        $obj->description = $description;
        $obj->image = $filePath;
        $obj->city_id = $city_id;
        try {
            if ($obj->update()) {
                $_SESSION['status'] = 1;
                header("Location: ../View/admin/updateCity.php?id=$city_id&page=city");
                exit;
            } else {
                $_SESSION['status'] = 0;
                header("Location: ../View/admin/updateCity.php?id=$city_id&page=city");
                exit;
            }
        } catch(Exception $ex) {
            $_SESSION['status'] = 0;
            header("Location: ../View/admin/updateCity.php?id=$city_id&page=city");
            exit;
        }
    }

    private function updatePropertyStatus()
    {
        $obj = new Property();
        $id = htmlspecialchars($_POST['property_id'], ENT_QUOTES, 'UTF-8');
        $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
        $visibility = htmlspecialchars($_POST['visibility_status'], ENT_QUOTES, 'UTF-8');

        $obj->id = $id;
        $obj->comment = $comment;
        $obj->visibility = $visibility;

        try {
            if ($obj->updateStatus()) {
                $_SESSION['property_update_status'] = 1;
                header("Location: ../View/admin/updateProperty.php?id=".$id);
                exit;
            }
        } catch(Exception $ex) {
            $_SESSION['property_update_status'] = 0;
            header("Location: ../View/admin/updateProperty.php?id=".$id);
            exit;
        }
    }

    private function loginAdmin()
    {
        $userObj = new Admin();
        $username = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        $userObj->username = $username;
        $userObj->setPassword($password);
        $data = $userObj->loginAdmin();
        if(empty($data)) {
            $_SESSION['login_status'] = 0;
            header("Location: ../View/admin/login.php");
            exit;
        } else {
            $_SESSION['admin_id'] = $data['id'];
            header("Location: ../View/admin/index.php");
            exit;
        }
    }

    private function logoutAdmin()
    {
        session_unset();
        session_destroy();
        header("Location: ../View/admin/login.php");
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

    public static function getUserById($id)
    {
        $obj = new Customer();
        $obj->id = $id;
        return $obj->getUserById();
    }

    public static function getSellerById($sellerId)
    {
        $obj = new Seller();
        $obj->id = $sellerId;
        return $obj->getSellerById();
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
    public static function getAllCities()
    {
        $obj = new City();
        return $obj->getAllCities();
    }

    public static function getCityById($cityId)
    {
        $obj = new City();
        $obj->city_id = $cityId;
        return $obj->getCityById();
    }

    public static function getAllLogs()
    {
        $obj = new ContactLogs();
        return $obj->getAllLogs();
    }

    public static function getContactById($id)
    {
        $obj = new ContactLogs();
        $obj->id = $id;
        return $obj->getContactById();
    }

    public static function getAllProperties()
    {
        $obj = new Property();
        return $obj->getAllProperties();
    }

    public static function getAllCMSPages()
    {
        $obj = new Cms();
        return $obj->getAllCMSPages();
    }

    public static function getCmsPageById($id)
    {
        $obj = new Cms();
        $obj->id = $id;
        return $obj->getCmsPageById();
    }

    public function getCustomerCount()
    {
        $obj = new Customer();
        return $obj->getCustomerCount();
    }

    public function getSellersCount()
    {
        $obj = new Seller();
        return $obj->getSellerCount();
    }

    public function getPropertiesCount()
    {
        $obj = new Property();
        return $obj->getPropertiesCount();
    }

    public function getCitiesCount()
    {
        $obj = new City();
        return $obj->getCitiesCount();
    }

    public function getPagesCount()
    {
        $obj = new Cms();
        return $obj->getPagesCount();
    }

    public function getFeedbackCount()
    {
        $obj = new ContactLogs();
        return $obj->getFeedbackCount();
    }

    public function quickReport()
    {
        return [
            'customers' => $this->getCustomerCount(),
            'sellers' => $this->getSellersCount(),
            'properties' => $this->getPropertiesCount(),
            'cities' => $this->getCitiesCount(),
            'pages' => $this->getPagesCount(),
            'feedback' => $this->getFeedbackCount()
        ];
    }

    public static function getCities(){
        $obj = new CityOptions();
        return $obj->getCities();
    }
}
