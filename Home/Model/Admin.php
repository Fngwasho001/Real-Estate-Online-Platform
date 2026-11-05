<?php
 //Include Necessary Classes
include_once('DbConnection.php');

class Admin extends DbConnection
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
     * User Name
     * @var $email
     */

     public $email;

    /**
     * user password
     * @var $password
     */

    private $password;

    /**
     * User Name
     * @var $username
     */

     public $username;


    /**
     * Get User Details
     */
    public function loginAdmin()
    {
        $query = "SELECT * FROM admin WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if (!password_verify($this->getPassword(), $result['password'])) {
                return false;
            }
            return $result;
        } else {
            return false;
        }
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
