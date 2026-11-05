<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

 //Include Necessary Classes
include_once('DbConnection.php');

class Seller extends DbConnection
{
    /**
     * user id
     * @var $id
     */
    public $id;

    /**
     * Address
     * @var $address
     */

     public $address;

    /**
     * Facebook Profile url
     * @var $facebookUrl
     */

     public $facebookUrl;


    /**
     * Instagram Profile url
     * @var $instagramUrl
     */

     public $instagramUrl;


    /**
     * Twitter Profile url
     * @var $twitterUrl
     */

     public $twitterUrl;

    /**
     * LinkedIn Profile url
     * @var $linkedInUrl
     */

     public $linkedInUrl;

    /**
     * Customer Id
     * @var $customerId
     */

     public $customerId;


    /**
     * Account Status
     * @var $account_status
     */

     public $account_status;

    /**
     * Get All Sellers
     */
    public function getAllSellers()
    {
        $query = "SELECT seller_profile.id AS seller_id, seller_profile.*, customer_entity.* FROM seller_profile
         INNER JOIN customer_entity ON seller_profile.customer_id = customer_entity.id order by seller_profile.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getSellerCount()
    {
        $query = "SELECT COUNT(*) FROM seller_profile";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();  
        return $count;
    } 

    public function CheckForExistingEmail() {
        $query  = "SELECT * FROM customer_entity WHERE email=:email LIMIT 1";
        $stmt   = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } 
        return false;
    }
    
    public function confirmSecretAnswer() {
        $query  = "SELECT * FROM customer_entity WHERE email=:email AND secret_answer=:secretAnswer";
        $stmt   = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':secretAnswer', $this->secretAnswer, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } 
        return false;
    }

    public function CheckForEmailUpdate() {
        $query  = "SELECT * FROM customer_entity WHERE email=:email AND id != :id";
        $stmt   = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } 
        return false;

    }
    
    
    public function add()
    {
        $query = "INSERT INTO seller_profile  
                  (address, facebook_profile_url, instagram_profile_url, twitter_profile_url,linkedin_profile_url,customer_id) 
                  VALUES (:address, :facebook_profile_url, :instagram_profile_url, :twitter_profile_url, :linkedin_profile_url,:customer_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
        $stmt->bindParam(':facebook_profile_url', $this->facebookUrl, PDO::PARAM_STR);
        $stmt->bindParam(':instagram_profile_url', $this->instagramUrl, PDO::PARAM_STR);
        $stmt->bindParam(':twitter_profile_url', $this->twitterUrl, PDO::PARAM_STR);
        $stmt->bindParam(':linkedin_profile_url', $this->linkedInUrl, PDO::PARAM_STR);  
        $stmt->bindParam(':customer_id', $this->customerId, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    
    public function update()
    {
        $query = "UPDATE seller_profile  
                  SET 
                  facebook_profile_url = :facebook_profile_url, 
                  instagram_profile_url = :instagram_profile_url, 
                  twitter_profile_url = :twitter_profile_url, 
                  linkedin_profile_url = :linkedin_profile_url, 
                  customer_id = :customer_id, 
                  address = :address";
    
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
        $stmt->bindParam(':facebook_profile_url', $this->facebookUrl, PDO::PARAM_STR);
        $stmt->bindParam(':instagram_profile_url', $this->instagramUrl, PDO::PARAM_STR);
        $stmt->bindParam(':twitter_profile_url', $this->twitterUrl, PDO::PARAM_STR);
        $stmt->bindParam(':linkedin_profile_url', $this->linkedInUrl, PDO::PARAM_STR);  
        $stmt->bindParam(':customer_id', $this->customerId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    
    public function updateSellerStatus()
    {
        $query = "UPDATE seller_profile  SET
                  account_status = :account_status";
    
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account_status', $this->account_status, PDO::PARAM_INT);  
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }


    public function deleteSeller()
    {
        $query = "DELETE FROM seller_profile WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function getSellerByCustomerId()
    {
        $query = "SELECT * FROM seller_profile WHERE customer_id = :customer_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $this->customerId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSellerById()
    {
        $query = "SELECT seller_profile.id AS seller_id, seller_profile.*, customer_entity.* FROM seller_profile
         INNER JOIN customer_entity ON seller_profile.customer_id = customer_entity.id WHERE seller_profile.id = :seller_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
