<?php

//Include Necessary Classes
include_once('DbConnection.php');

class Property extends DbConnection
{
    /**
     * user id
     * @var $id
     */
    public $id;

    /**
     * title
     * @var $title
     */

    public $title;

    /**
     * content
     * @var $content
     */

    public $content;

    /**
     * property_type
     * @var $property_type
     */

    public $property_type;

    /**
     * selling_type
     * @var $selling_type
     */

    public $selling_type;

    /**
     * amenities
     * @var $amenities
     */

    public $amenities;

    /**
     * faults
     * @var $faults
     */

    public $faults;

    /**
     * bathroom
     * @var $bathroom
     */
    public $bathroom;


    /**
     * balcony
     * @var $balcony
     */

    public $balcony;

    /**
     * kitchen
     * @var $kitchen
     */

    public $kitchen;

    /**
     * hall
     * @var $hall
     */

    public $hall;


    /**
     * bedroom
     * @var $bedroom
     */

    public $bedroom;


    /**
     * location
     * @var $location
     */

    public $location;

    /**
     * city
     * @var $city
     */

    public $city;

    /**
     * area
     * @var $area
     */

    public $area;


    /**
     * price
     * @var $price
     */

    public $price;

    /**
     * thumbnail
     * @var $thumbnail
     */

    public $thumbnail;


    /**
     * image1
     * @var $image1
     */

    public $image1;


    /**
     * image2
     * @var $image2
     */

    public $image2;


    /**
     * image3
     * @var $image3
     */

    public $image3;


    /**
     * image4
     * @var $image4
     */

    public $image4;


    /**
     * seller_id
     * @var $seller_id
     */

    public $seller_id;


    /**
     * status
     * @var $status
     */

    public $status;


    /**
     * comment
     * @var $comment
     */

    public $comment = null;

    /**
     * visibility
     * @var $visibility
     */

    public $visibility;

    /**
     * pageSize
     * @var $pageSize
     */

    public $pageSize;

    /**
     * pageNo
     * @var $pageNo
     */

    public $pageNo;

    /**
     * Searched Property Ids
     * @var $propertyIds
     */

    public $propertyIds;


    public function getPropertiesBySeller()
    {
        $query  = "SELECT * FROM property WHERE seller_id=:seller_id order by id DESC";
        $stmt   = $this->conn->prepare($query);
        $stmt->bindParam(':seller_id', $this->seller_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function getPropertyById()
    {
        $query = "SELECT * FROM property 
                  INNER JOIN seller_profile ON seller_profile.id = property.seller_id 
                  INNER JOIN customer_entity on customer_entity.id=seller_profile.customer_id WHERE property.id=:property_id";
        $stmt   = $this->conn->prepare($query);
        $stmt->bindParam(':property_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public function add()
    {
        $query = "INSERT INTO property  
                  (title, content, property_type, selling_type, bathroom, balcony, kitchen, hall,
                  bedroom, location, city, area, price, amenities, faults, thumbnail, image1, image2, image3,
                  image4, seller_id, status, comment) 
    
                  VALUES (:title, :content, :property_type, :selling_type, :bathroom, :balcony, :kitchen, :hall,
                  :bedroom, :location, :city, :area, :price, :amenities, :faults, :thumbnail, :image1, :image2, :image3,
                  :image4, :seller_id, :status, :comment)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindParam(':property_type', $this->property_type, PDO::PARAM_STR);
        $stmt->bindParam(':selling_type', $this->selling_type, PDO::PARAM_STR);
        $stmt->bindParam(':bathroom', $this->bathroom, PDO::PARAM_STR);
        $stmt->bindParam(':balcony', $this->balcony, PDO::PARAM_INT);
        $stmt->bindParam(':kitchen', $this->kitchen, PDO::PARAM_INT);
        $stmt->bindParam(':hall', $this->hall, PDO::PARAM_INT);
        $stmt->bindParam(':bedroom', $this->bedroom, PDO::PARAM_INT);
        $stmt->bindParam(':location', $this->location, PDO::PARAM_STR);
        $stmt->bindParam(':city', $this->city, PDO::PARAM_STR);
        $stmt->bindParam(':area', $this->area, PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':amenities', $this->amenities, PDO::PARAM_STR);
        $stmt->bindParam(':faults', $this->faults, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $this->thumbnail, PDO::PARAM_STR);
        $stmt->bindParam(':image1', $this->image1, PDO::PARAM_STR);
        $stmt->bindParam(':image2', $this->image2, PDO::PARAM_STR);
        $stmt->bindParam(':image3', $this->image3, PDO::PARAM_STR);
        $stmt->bindParam(':image4', $this->image4, PDO::PARAM_STR);
        $stmt->bindParam(':seller_id', $this->seller_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $this->comment, PDO::PARAM_STR);

        $result = $stmt->execute();
        return $result;
    }


    public function update()
    {
        $query = "UPDATE property  
                  SET 
                  title=:title, 
                  content=:content, 
                  property_type=:property_type, 
                  selling_type=:selling_type, 
                  bathroom=:bathroom, 
                  balcony=:balcony,
                  kitchen=:kitchen, 
                  hall=:hall,
                  bedroom=:bedroom, 
                  location=:location, 
                  city=:city, 
                  area=:area, 
                  price=:price, 
                  amenities=:amenities,
                  faults=:faults,
                  seller_id=:seller_id, 
                  status=:status";

        if ($this->thumbnail !== null) {
            $query .= ", thumbnail = :thumbnail";
        }
        if ($this->image1 !== null) {
            $query .= ", image1 = :image1";
        }
        if ($this->image2 !== null) {
            $query .= ", image2 = :image2";
        }
        if ($this->image3 !== null) {
            $query .= ", image3 = :image3";
        }
        if ($this->image4 !== null) {
            $query .= ", image4 = :image4";
        }
        if ($this->visibility !== null) {
            $query .= ", visibility = :visibility";
        }
        if ($this->comment !== null) {
            $query .= ", comment = :comment";
        }

        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindParam(':property_type', $this->property_type, PDO::PARAM_STR);
        $stmt->bindParam(':selling_type', $this->selling_type, PDO::PARAM_STR);
        $stmt->bindParam(':bathroom', $this->bathroom, PDO::PARAM_INT);
        $stmt->bindParam(':balcony', $this->balcony, PDO::PARAM_INT);
        $stmt->bindParam(':kitchen', $this->kitchen, PDO::PARAM_INT);
        $stmt->bindParam(':hall', $this->hall, PDO::PARAM_INT);
        $stmt->bindParam(':bedroom', $this->bedroom, PDO::PARAM_INT);
        $stmt->bindParam(':location', $this->location, PDO::PARAM_STR);
        $stmt->bindParam(':city', $this->city, PDO::PARAM_STR);
        $stmt->bindParam(':area', $this->area, PDO::PARAM_STR);
        $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindParam(':amenities', $this->amenities, PDO::PARAM_STR);
        $stmt->bindParam(':faults', $this->faults, PDO::PARAM_STR);
        $stmt->bindParam(':seller_id', $this->seller_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);

        if ($this->thumbnail !== null) {
            $stmt->bindParam(':thumbnail', $this->thumbnail, PDO::PARAM_STR);
        }
        if ($this->image1 !== null) {
            $stmt->bindParam(':image1', $this->image1, PDO::PARAM_STR);
        }
        if ($this->image2 !== null) {
            $stmt->bindParam(':image2', $this->image2, PDO::PARAM_STR);
        }
        if ($this->image3 !== null) {
            $stmt->bindParam(':image3', $this->image3, PDO::PARAM_STR);
        }
        if ($this->image4 !== null) {
            $stmt->bindParam(':image4', $this->image4, PDO::PARAM_STR);
        }
        if ($this->visibility !== null) {
            $stmt->bindParam(':visibility', $this->visibility, PDO::PARAM_STR);
        }
        if ($this->comment !== null) {
            $stmt->bindParam(':comment', $this->comment, PDO::PARAM_STR);
        }
        $result = $stmt->execute();
        return $result;
    }

    public function updateStatus()
    {
        $query = "UPDATE property SET comment = :comment, visibility = :visibility";
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment', $this->comment, PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->visibility, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function delete()
    {
        $query = "DELETE FROM property WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * Get Count of all visible properties
     *
     * @return int
     */
    public function getVisibleProperties()
    {
        $query = "SELECT COUNT(*) AS total FROM property WHERE visibility = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Get Count of all properties
     *
     * @return int
     */
    public function getPropertiesCount()
    {
        $query = "SELECT COUNT(*) FROM property";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }



    /**
     * Get Searched Properties List
     *
     * @return int
     */
    public function getSearchedProperties()
    {
        if ($this->propertyIds == null) {
            return [];
        }

        $query = "SELECT * FROM property WHERE id IN ({$this->propertyIds})";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }



    /**
     * Get Delivery Point List
     *
     * @return array
     */
    public function getPropertiesList()
    {
        $offset = ($this->pageNo - 1) * $this->pageSize;
        $query = "SELECT * FROM property WHERE visibility = 1 ";
        $query .= "ORDER BY id DESC ";
        $query .= "LIMIT :offset, :recordsPerPage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':recordsPerPage', $this->pageSize, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     * Search Property
     *
     * @return string Comma-separated list of IDs
     */
    public function search()
    {
        $query = "SELECT id FROM property WHERE visibility = 1";

        // Append conditions to the query
        if ($this->property_type !== null && $this->property_type !== "any") {
            $query .= " AND property_type = :property_type";
        }
        if ($this->selling_type !== null && $this->selling_type !== "any") {
            $query .= " AND selling_type = :selling_type";
        }
        if (trim ($this->keyword) != null) {
            $query .= " AND title LIKE CONCAT('%', :keyword, '%')";
        }
        if ($this->city != null && $this->city != "any") {
            $query .= " AND city = :city";
        }
        if ($this->bedroom != null && $this->bedroom != "any") {
            $query .= " AND bedroom = :bedroom";
        }
        if ($this->bathroom != null && $this->bathroom != "any") {
            $query .= " AND bathroom = :bathroom";
        }
        if ($this->price != null && $this->price != "any") {
            $query .= " AND price = :price";
        }

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        if ($this->property_type !== null && $this->property_type !== "any") {
            $stmt->bindParam(':property_type', $this->property_type);
        }
        if ($this->selling_type !== null && $this->selling_type !== "any") {
            $stmt->bindParam(':selling_type', $this->selling_type);
        }
        if (trim ($this->keyword) != null) {
            $stmt->bindParam(':keyword', $this->keyword);
        }
        if ($this->city !== null && $this->city !== "any") {
            $stmt->bindParam(':city', $this->city);
        }
        if ($this->bedroom !== null && $this->bedroom !== "any") {
            $stmt->bindParam(':bedroom', $this->bedroom);
        }
        if ($this->bathroom !== null && $this->bathroom !== "any") {
            $stmt->bindParam(':bathroom', $this->bathroom);
        }
        if ($this->price !== null && $this->price !== "any") {
            $stmt->bindParam(':price', $this->price);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (empty($result)) {
            return null;
        }
        $idList = implode(',', $result);
        return $idList;
    }

    public function getAllProperties()
    {
        $query = "SELECT property.id AS property_id, property.*, seller_profile.*,customer_entity.*
                  FROM property 
                  INNER JOIN seller_profile ON property.seller_id = seller_profile.id 
                  INNER JOIN customer_entity on customer_entity.id = seller_profile.customer_id";
        $query .= " ORDER BY property.id DESC "; // Added space before ORDER BY
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
