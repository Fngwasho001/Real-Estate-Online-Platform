<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class Customer extends DbConnection
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
     * user password
     * @var $password
     */

    private $password;

    /**
     * Phone No
     * @var $phoneNo
     */

     public $phoneNo;

    /**
     * Description
     * @var $description
     */

     public $description;

    /**
     * Secret Answer
     * @var $secretAnswer
     */

     public $secretAnswer;

    /**
     * Image
     * @var $image
     */

     public $image;

    /**
     * Get User Details
     */
    public function loginUser()
    {
        $query = "SELECT * FROM customer_entity WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (!password_verify($this->getPassword(), $result['password_hash'])) {
                return false;
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get All Customers
     */
    public function getAllCustomers()
    {
        $query = "SELECT * FROM customer_entity order by id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCustomerCount()
    {
        $query = "SELECT COUNT(*) FROM customer_entity";
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
        $query = "INSERT INTO customer_entity  
                  (name, email, phone, secret_answer, password_hash, description,image_path) 
                  VALUES (:name, :email, :phone, :secret_answer, :password_hash, :description,:image_path)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $this->phoneNo, PDO::PARAM_STR);
        $stmt->bindParam(':secret_answer', $this->secretAnswer, PDO::PARAM_STR);
        $stmt->bindParam(':password_hash', $this->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);  
        $stmt->bindParam(':image_path', $this->image, PDO::PARAM_STR);  
        $result = $stmt->execute();
        return $result;
    }
    
    public function update()
    {
        $query = "UPDATE customer_entity  
                  SET name = :name, email = :email, phone = :phone, description = :description";
        if ($this->password !== null) {
            $query .= ", password_hash = :password_hash";
        }
        if ($this->image !== null) {
            $query .= ", image_path = :image_path";
        }
    
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $this->phoneNo, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        if ($this->password !== null) {
            $stmt->bindParam(':password_hash', $this->getPassword(), PDO::PARAM_STR);
        }
        if ($this->image !== null) {
            $stmt->bindParam(':image_path', $this->image, PDO::PARAM_STR);
        }
        $result = $stmt->execute();
        return $result;
    }

    public function delete()
    {
        $query = "DELETE FROM customer_entity WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    
    public function updatePassword()
    {
        $query = "UPDATE customer_entity  SET password_hash = :password_hash";
        $query .= " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password_hash', $this->getPassword(), PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
    

    /**
     * Get User Type
     */
    public function getUserByEmail()
    {
        $query = "SELECT * FROM customer_entity WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get User Type
     */
    public function getUserById()
    {
        $query = "SELECT * FROM customer_entity WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Set password
     * @param Assign value to password
     */

    public function setPassword($pass)
    {
        $this->password = $pass;
    }

    /**
     * Returns password
     */

    public function getPassword()
    {
        return $this->password;
    }
}
