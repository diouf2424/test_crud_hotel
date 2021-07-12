<?php
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                                           ///////////////////////
///////////////                               BOOKING                                     ///////////////////////
///////////////                                                                           ///////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
class Booking
{
    private $_client_id;
    private $_arrival;
    private $_departure;
    private $_today;
    private $_room_id;
     
    public function __construct(array $bookingData)
    {
        $this->setClientId($bookingData['client_id']);
        $this->setArrival();
        $this->setDeparture();
        $this->setToday();
        $this->setRoomId();
    }
 
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////                           setters                                   ////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
 
    public function setClientId($client_id)
    {
        if ((is_int($client_id)) AND ($client_id > 0))
        {  
                $this->_client_id = $client_id;     
        }
    }
 
    public function setArrival()
    {
        $arrival = $_POST['arrival'];
        $this->_arrival = $arrival;
    }
 
    public function setDeparture()
    {
        $departure = $_POST['departure'];
        $this->_departure = $departure;
    }
 
    public function setToday()
    {
        $today = date("Y-m-d");
        $this->_today = $today;
    }
 
    public function setRoomId()
    {
        try
        {
            $dbh = new PDO('mysql:host=localhost;dbname=booking;charset=UTF8', 'root', '');
        }
        catch(Exception $e)
        {
            echo 'Message erreur SQL : ' .$e->getMessage(). '<br>';
            exit;
        }
 
        $resort_id = trim($_POST['resort']);
        $sql = 'SELECT number FROM rooms AS o
                INNER JOIN resorts AS r
                ON r.id=o.resort_id
                WHERE r.id="'.$resort_id.'" ';
        $stmnt = $dbh->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->fetchAll();
        $room_id = $result[array_rand($result)]['number'];
        $this->_room_id = $room_id;
    }
     
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////                           getters                                   ////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
 
    public function getClientId()
    {
        return $this->_client_id;
    }
 
    public function getArrival()
    {
        return $this->_arrival;
    }
 
    public function getDeparture()
    {
        return $this->_departure;
    }
 
    public function getToday()
    {
        return $this->_today;
    }
 
    public function getRoomId()
    {
        return $this->_room_id;
    }
}
?>