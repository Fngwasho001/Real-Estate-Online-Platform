<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class ContactLogs extends DbConnection
{
    /**
     * user id
     * @var $id
     */
    public $id;

    /**
     * User Name
     * @var $name
     */

    public $name;

    /**
     * User Email
     * @var $email
     */

     public $email;

    /**
     * Subject
     * @var $subject
     */

     public $subject;

    /**
     * Message
     * @var $message
     */

     public $message;

    /**
     * Get User Type
     */
    public function getAllLogs()
    {
        $query = "SELECT * FROM contact_logs order by id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
    public function add()
    {
        $query = "INSERT INTO contact_logs  
                  (name, email, subject, message) 
                  VALUES (:name, :email, :subject, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $this->subject, PDO::PARAM_STR);
        $stmt->bindParam(':message', $this->message, PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * Get User by id
     */
    public function getContactById()
    {
        $query = "SELECT * FROM contact_logs WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete()
    {
        $query = "DELETE FROM contact_logs WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }   

    /**
     * Get Count of all cities
     *
     * @return int
     */
    public function getFeedbackCount()
    {
        $query = "SELECT COUNT(*) FROM contact_logs";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();  
        return $count;
    }
    
}