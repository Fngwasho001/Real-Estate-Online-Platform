<?php

class Booking
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Bookings (user_id, property_id, scheduled_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $data['user_id'], $data['property_id'], $data['scheduled_date']);
        return $stmt->execute();
    }

    public function getAll()
    {
        $query = "SELECT b.booking_id, u.full_name, p.title, b.scheduled_date 
                  FROM Bookings b 
                  JOIN Users u ON b.user_id = u.user_id 
                  JOIN Properties p ON b.property_id = p.property_id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Bookings WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
