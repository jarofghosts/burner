<?php

	$message = $_GET['message'];
	$exp_time = $_GET['exp_time'];
	$exp_value = $_GET['exp_value'];
	$max_views = $_GET['max_views'];
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
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time DAY, :max_views )");
	    	} else if ( $exp_value == "MONTH") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time MONTH, :max_views )");
	    	} else if ( $exp_value == "HOUR") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time HOUR, :max_views )");
	    	} else if ( $exp_value == "MINUTE") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW() + INTERVAL :exp_time MINUTE, :max_views )");
	    	} else if ( $exp_value == "VIEWERS") {
	    		$stmt = $dbh->prepare("INSERT INTO messages ( public_id, message, expiration_date, max_views ) VALUES ( :public_id, :message, NOW(), :max_views )");
	    	}
    		$stmt->bindParam(':public_id', $public_id, PDO::PARAM_STR);
    		$stmt->bindParam(':message', $message, PDO::PARAM_STR);
    		$stmt->bindParam(':exp_time', $exp_time, PDO::PARAM_INT);
    		$stmt->bindParam(':max_views', $max_views, PDO::PARAM_INT);
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