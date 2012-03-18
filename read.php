<?php

	$id = $_GET['id'];
	if ( ! isset($id) ) {
		echo 'No id#';
		exit;
	} else {

		$hostname = 'localhost';
		$username = 'username';
		$password = 'password';

		try {
		    $dbh = new PDO("mysql:host=$hostname;dbname=dbname", $username, $password);
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    		$stmt = $dbh->prepare("SELECT * FROM messages WHERE public_id = :message_id AND expiration_date > NOW()");
    		$stmt->bindParam(':message_id', $id, PDO::PARAM_STR);
		    $stmt->execute();

		    while($message = $stmt->fetch()) {
		        echo $message['message'];
        	}

		    $dbh = null; # close the connection
}
catch(PDOException $e)
    {
    echo $e->getMessage(); # for now, we're going to just print the error for debugging purposes.
    }
}
?>