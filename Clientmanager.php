<?php
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////                                                                           ///////////////////////
///////////////                         CLIENT MANAGER                                    ///////////////////////
///////////////                                                                           ///////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once 'index.php';
class clientManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        global $db;
        $this->_db = $db;
    }
 
    //insertion
    public function addclient(Client $client)
    {
        $sql = 'INSERT INTO clients (name, email) VALUES (:name, :email)';
        $stmnt = $this->_db->prepare($sql);
        $name = trim($client->getName());
        $email = trim($client->getEmail());
        $stmnt->bindParam(':name', $name);
        $stmnt->bindParam(':email', $email);
        if ($stmnt->execute())
        {
            return $this->_db->lastInsertId();
        }
        return false;
 
        //gestion des erreurs SQL
        echo "votre reservation a ete bien fait";
    }
}
?>