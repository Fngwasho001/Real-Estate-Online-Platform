<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class Cms extends DbConnection
{
    /**
     * user id
     * @var $id
     */
    public $id;

    /**
     * identifier
     * @var $identifier
     */

    public $identifier;

    /**
     * Content
     * @var $content
     */

     public $content;

    /**
     * Get All CMS Pages
     */
    public function getAllCMSPages()
    {
        $query = "SELECT * FROM cms_page order by id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update()
    {
        $query = "UPDATE cms_page SET identifier = :identifier, content = :content";
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifier', $this->identifier, PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    
    public function add()
    {
        $query = "INSERT INTO cms_page (identifier, content) VALUES (:identifier, :content)";
        $stmt = $this->conn->prepare($query);
        // Bind parameters with proper data types
        $stmt->bindParam(':identifier', $this->identifier, PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
        // Execute the statement
        $result = $stmt->execute();
        return $result;
    }
    
    /**
     * Get User by id
     */
    public function getCmsPageById()
    {
        $query = "SELECT * FROM cms_page WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get User by identifier
     */
    public function getCMSPageByIdentifier()
    {
        $query = "SELECT * FROM cms_page WHERE identifier = :identifier LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifier', $this->identifier, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function delete()
    {
        $query = "DELETE FROM cms_page  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }   

    /**
     * Get Count of all Pages
     *
     * @return int
     */
    public function getPagesCount()
    {
        $query = "SELECT COUNT(*) FROM cms_page";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();  
        return $count;
    }

}