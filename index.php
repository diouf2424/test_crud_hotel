<?php
require('Class/Client.php');
require('Class/Clientmanager.php');
 
require('Class/Booking.php');
require('Class/Bookingmanager.php');
 
 
 
if (isset($_POST['submitForm']))
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////                      clients informations                           ////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
 
    $name = $_POST['name'];
    $email = $_POST['email'];
    //création d'un objet client
    $client_data = array('name' => $name, 'email' => $email);
    $client = new Client($client_data);
 
    //affectation dans la varibale $db de la connexion
      $servername = 'localhost';
            $username = 'root';
            $password = 'root';
            
            //On établit la connexion
            //$db = new PDO("mysql:host=$servername;dbname=booking", $username, $password);
            
            //On vérifie la connexion
            try{
                $db = new PDO("mysql:host=$servername;dbname=booking", $username, $password);
                //On définit le mode d'erreur de PDO sur Exception
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Connexion réussie';
            }
            
            /*On capture les exceptions si une exception est lancée et on affiche
             *les informations relatives à celle-ci*/
            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }
    //$db = new PDO('mysql:host=localhost;dbname=booking;charset=UTF8','root','root');
 
    //instanciation de la classe clientManager, nous créons un objet clientManager
    //la connexion PDO est passée en paramètre au constructeur
    $clientManager = new clientManager($db);
 
    //appel à la méthode addClient, nous passons un ojet en argument.
    $client_id = $clientManager->addClient($client);
    var_dump($name);
    var_dump($email);
    var_dump($client_id);
    echo '<br>';
 
 
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////                      bookings informations                          ////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
 
    //création d'un objet booking
    $booking_data = array('client_id' => (int) $client_id);
    $booking = new Booking($booking_data);
    $bookingManager = new bookingManager($db);
    $booking_id = $bookingManager->addBooking($booking);
     
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////                      rooms informations                             ////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
 
    $resort_id = $_POST['resort'];
    $rooms = $bookingManager->getRoomsByResortId($resort_id);
    var_dump($rooms);
 
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="wrapper">
        <h1>Booking Application</h1>
        <nav class="main-nav" role="navigation">
            <ul>
                <li><a href="index.php" role="menuitem">Accueil</a></li>
                <li><a href="resorts.php" role="menuitem">Hôtels</a></li>
            </ul>
        </nav>
 
        <section>
            <div class="formulaire">
                <?php if(isset($error_msg)) : ?> 
                <p class="error_msg"><?php echo $error_msg ?></p>
                <?php endif ?>
 
                <?php if(isset($success_msg)) : ?>   
                <p class="success_msg"><?php echo $success_msg ?></p>
                <?php endif ?>
 
                <form method="post" action="Clientmanager.php'">
                    <h2>Réservez votre hôtel</h2>
                    <p>
                        Votre nom: <input type="text" name="name" value="<?php $name ?>" placeholder="Nom">
                    </p>
 
                    <p>
                        Votre email: <input type="email" name="email" value="" placeholder="votre@mail">
                    </p>
 
                    <p>
                        Votre hôtel:<select name="resort">
                                        <option value=""></option>
                                        <?php
                                            $resorts = array(1 => 'KIng fath palace, Dakar 5*',
                                                'trois-A hotel, Dakar 7*',
                                                'Kaay deuk, Dakar 4*',
                                                'Four Seasons, Bora Bora 4*',
                                                'Atlantis Paradise Island, Bahamas 4*');
                                            foreach ($resorts as $resort_id => $resort)
                                            {
                                                echo '<option value=" '.$resort_id.' ">' .$resort. '</option>';
                                            }
 
                                        ?>
                                    </select>
                         
                    </p>
 
                    <p>
                        Du: <input class="mr-30" type="date" name="arrival" value="">
                        Au: <input class="mr-30" type="date" name="departure" value="">
                    </p>
 
                    <p>
                        <?php $today = date("Y-m-d") ?>
                        <input type="hidden" name="bookingCreation" value="<?php echo $today ?>" >
                    </p>
 
                    <p>
                        <input class="submit-bt" type="submit" name="submitForm" value="Réserver">
                    </p>
                     
                     
                </form>
            </div>
        </section>
    </div>
</body>
</html>