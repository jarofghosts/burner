<?php

	$id = $_GET['id'];
	$ip = $_SERVER['REMOTE_ADDR'];

	if ( ! isset($id) ) {
		echo 'No id#';
		exit;
	} else {

		$hostname = '';
		$username = '';
		$password = '';

		try {
		    $dbh = new PDO("mysql:host=$hostname;dbname=burner", $username, $password);
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    		$stmt = $dbh->prepare("SELECT * FROM messages WHERE ( public_id = :message_id AND expiration_date > NOW() ) OR ( public_id = :message_id AND max_views > 0 )");
    		$stmt->bindParam(':message_id', $id, PDO::PARAM_STR);
		    $stmt->execute();
		    $message = $stmt->fetch();

			echo $message['message'];

		    $origin_id = $message['id'];

		    if ($message['max_views'] > 0) {
			   	$stmt = $dbh->prepare("SELECT count(*) FROM access_log WHERE access_id = :origin_id AND ip = :access_ip");
			    $stmt->bindParam(':origin_id', $origin_id, PDO::PARAM_INT);
			    $stmt->bindParam(':access_ip', $ip, PDO::PARAM_STR);
			    $stmt->execute();

			    $has_viewed = (int) $stmt->fetchColumn();

			    if ($has_viewed == 0) {

			    		$stmt = $dbh->prepare("INSERT INTO access_log (access_id, ip) VALUES ( :origin_id, :access_ip )");
			    		$stmt->bindParam(':origin_id', $origin_id, PDO::PARAM_INT);
			    		$stmt->bindParam(':access_ip', $ip, PDO::PARAM_STR);
			    		$stmt->execute();

			    }

			    $stmt = $dbh->prepare("SELECT count(*) FROM access_log WHERE access_id = :origin_id");
			    $stmt->bindParam(':origin_id', $origin_id, PDO::PARAM_INT);
			    $stmt->execute();
			    $total_views = (int) $stmt->fetchColumn();
			    
			    if ($total_views == $message['max_views']) {

			    	$stmt = $dbh->prepare("UPDATE messages SET expiration_date = NOW(), max_views = 0 WHERE id = :origin_id");
			    	$stmt->bindParam(':origin_id', $message['id'], PDO::PARAM_INT);
			    	$stmt->execute();

			    }
		    }

		    $dbh = null; # close the connection
}
catch(PDOException $e)
    {
    echo $e->getMessage(); # for now, we're going to just print the error for debugging purposes.
    }
}
?>