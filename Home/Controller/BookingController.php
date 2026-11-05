<?php

class BookingController extends Controller
{

    public function form($property_id = null)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit();
        }

        $propertyModel = $this->model('Property');
        $property = $propertyModel->findById($property_id);

        $this->view('booking/form', ['property' => $property]);
    }

    public function submit()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $property_id = $_POST['property_id'];
        $scheduled_date = $_POST['scheduled_date'];

        $bookingModel = $this->model('Booking');
        $bookingModel->create([
            'user_id' => $user_id,
            'property_id' => $property_id,
            'scheduled_date' => $scheduled_date
        ]);

        // Optionally send email using Mailer class
        require_once '../app/helpers/Mailer.php';
        $propertyModel = $this->model('Property');
        $property = $propertyModel->findById($property_id);
        $owner = $propertyModel->getOwnerEmail($property_id);

        Mailer::sendBookingEmail($owner['email'], $property['title'], $scheduled_date);

        $this->view('booking/confirmation', ['property' => $property, 'date' => $scheduled_date]);
    }
}

