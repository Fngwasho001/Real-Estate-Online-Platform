<?php

class PropertyController
{
    private $propertyModel;

    public function __construct($propertyModel)
    {
        $this->propertyModel = $propertyModel;
    }

    public function addProperty()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $location = $_POST['location'];

            // Image Upload Handling
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "uploads/";
                $image = $targetDir . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $image);
            }

            $result = $this->propertyModel->addProperty($title, $description, $price, $location, $image);

            if ($result) {
                header("Location: /properties/success");
            } else {
                echo "Error adding property.";
            }
        }
    }
}

