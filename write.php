<?php

	$message = $_GET['message'];
	$exp_time = $_GET['exp_time'];
	$exp_value = $_GET['exp_value'];

	if ( ! isset($message) ) {
		echo 'incomplete';
		exit;
	} else {
		
		$hostname = '';
		$username = '';
		$password = '';
		$public_id = sha1($_SERVER['REMOTE_ADDR'] . microtime() . (string)rand());

		try {
		    $dbh = new PDO("mysql:host=$hostname;dbname=burner", $username, $password);
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    		if ( $exp_value == "DAY") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time DAY )");
	    	} else if ( $exp_value == "MONTH") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time MONTH )");
	    	} else if ( $exp_value == "HOUR") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time HOUR )");
	    	} else if ( $exp_value == "MINUTE") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time MINUTE )");
	    	} else if ( $exp_value == "VIEWERS") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW(), :exp_time )");
	    	}
    		$stmt->bindParam(':public_id', $public_id, PDO::PARAM_STR);
    		$stmt->bindParam(':message', $message, PDO::PARAM_STR);
    		$stmt->bindParam(':exp_time', $exp_time, PDO::PARAM_INT);
		    $stmt->execute();

		    echo $public_id;

		    $dbh = null; # close the connection
}
catch(PDOException $e)
    {
    echo $e->getMessage(); # for now, we're going to just print the error for debugging purposes.
    }
}

?>