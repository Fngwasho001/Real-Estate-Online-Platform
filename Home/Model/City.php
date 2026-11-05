<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class City extends DbConnection
{
    /**
     * city_id
     * @var $city_id
     */
    public $city_id;

    /**
     * City name
     * @var $name
     */

    public $name;

    /**
     * City Description
     * @var $description
     */

     public $description;

    /**
     * Image
     * @var $image
     */

     public $image;

   
    public function getAllCities()
    {
        $query = "SELECT * FROM city ORDER BY city_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
    public function getCityById()
    {
        $query = "SELECT * FROM city WHERE city_id = :city_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':city_id', $this->city_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteCity()
    {
        $query = "DELETE FROM city WHERE city_id = :city_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':city_id', $this->city_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function add()
    {
        $query = "INSERT INTO city  
                  (name, description, image) 
                  VALUES (:name, :description, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

    public function update()
    {
        $query = "UPDATE city 
                  SET name = :name, description = :description";
    
        // Check if image is not null, then include it in the update query
        if (!empty($this->image)) {
            $query .= ", image = :image";
        }
    
        $query .= " WHERE city_id = :city_id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        
        // Bind image parameter only if it's not empty
        if (!empty($this->image)) {
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
        }
        
        $stmt->bindParam(':city_id', $this->city_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * Get Count of all cities
     *
     * @return int
     */
    public function getCitiesCount()
    {
        $query = "SELECT COUNT(*) FROM city";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();  
        return $count;
    }

}