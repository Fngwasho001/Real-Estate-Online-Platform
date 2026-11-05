<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class Wishlist extends DbConnection
{
    /**
     * user id
     * @var $id
     */
    public $id;

    /**
     * Customer Id
     * @var $customer_id
     */

    public $customer_id;

    /**
     * Property Id
     * @var $property_id
     */

     public $property_id;

/**
 * Get WishList By User with Property Details
 */
public function getCustomerWishList()
{
    $query = "SELECT wishlist.id AS wishlist_id, wishlist.*, property.*
              FROM wishlist 
              INNER JOIN property ON wishlist.property_id = property.id 
              WHERE wishlist.customer_id=:customer_id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':customer_id', $this->customer_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


public function getWishListByPropertyId() {
    $query  = "SELECT * FROM wishlist WHERE property_id = :property_id AND customer_id = :customer_id LIMIT 1";
    $stmt   = $this->conn->prepare($query);
    $stmt->bindParam(':property_id', $this->property_id);
    $stmt->bindParam(':customer_id', $this->customer_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; // Corrected return statement
}

    /**
     * Delete Item from Customer's Wishlist
     */
    public function delete()
    {
        $query = "DELETE FROM wishlist WHERE id = :wishlist_id AND customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':wishlist_id', $this->id);
        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function add()
    {
        $query = "INSERT INTO wishlist  
                  (customer_id, property_id) 
                  VALUES (:customer_id, :property_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $this->customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $this->property_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}