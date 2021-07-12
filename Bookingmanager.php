<?php
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                                           ///////////////////////
///////////////                         BOOKING MANAGER                                   ///////////////////////
///////////////                                                                           ///////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
class bookingManager
{
    private $_db;
 
    public function __construct($db)
    {
        $this->setDb($db);
    }
 
    public function setDb(PDO $dbh)
    {
        $this->_db = $dbh;
    }
 
 
    //insertion
    public function addBooking(Booking $booking)
    {
        $sql = 'INSERT INTO bookings (client_id, arrival_date, departure_date, booking_date, room_id) VALUES (:client_id, :arrival, :departure, :today, :room_id)';
        $stmnt = $this->_db->prepare($sql); //
        $clientId = $booking->getClientId();
        $arrival = $booking->getArrival();
        $departure = $booking->getDeparture();
        $today = $booking->getToday();
        $roomId = $booking->getRoomId();
        $stmnt->bindParam(':client_id', $clientId);
        $stmnt->bindParam(':arrival', $arrival);
        $stmnt->bindParam(':departure', $departure);
        $stmnt->bindParam(':today', $today);
        $stmnt->bindParam(':room_id', $roomId);
        $stmnt->execute();
             
        //gestion des erreurs
        $errors = $stmnt->errorInfo();
        if ($errors[0] = '00000')
        {
            echo 'Erreur SQL ' . $errors[2];
        }
        else
        {
            //$success_msg = 'Votre réservation a bien été enregistrée. (bookingManager)';
            echo 'Votre réservation a bien été enregistrée. (addBooking)';
        }      
    }
     
    public function getRoomsByResortId($resort_id)
    {
        $resort_id = trim($_POST['resort']);
        $sql = 'SELECT number, arrival_date, departure_date FROM rooms AS o
                LEFT JOIN bookings as b ON b.room_id=o.id
                INNER JOIN resorts AS r ON r.id=o.resort_id
                WHERE r.id= "'.$resort_id.'"
                ORDER BY number ASC';
        $stmnt = $this->_db->prepare($sql);
        $stmnt->execute();
        while ($row = $stmnt->fetchAll(PDO::FETCH_ASSOC))
        {
            $result[] = $row;
        }
        return $result;
 
        //gestion des erreurs
        $errors = $stmnt->errorInfo();
        if ($errors[0] = '00000')
        {
            echo 'Erreur SQL ' . $errors[2];
        }
        else
        {
            echo 'Votre réservation a bien été enregistrée. (getRoomsByHotel)';
        }
    }
}
?>