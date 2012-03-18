<html>
	<head>
		<title>BURNER</title>
		<script src="/imf/js/burner.js"></script>
		<style type="text/css">
			@import url("css/default.css");
		</style>
		<link href='http://fonts.googleapis.com/css?family=Magra:700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<header><img src="images/header.png" alt="Burner"/></header>
		<div id="display" class="message"></div>
		<div id="url-box"><input id="url-form" type="text" class="url-box" onclick="this.select(); var r= this.createTextRange(); r.execCommand('copy');"/></div>
		<div id="form">
			<form name="main_form">
				<textarea name="message" id="message" placeholder="Type your message..."></textarea><br/>
				<span class="form_label">Expire In...</span><br/>
				<input type="text" name="exp_time" placeholder="#" class="time_box"/>
				<div class="select-box"><select name="exp_value" class="value_box">
					<option selected value="MINUTE">Minutes</option>
					<option selected value="HOUR">Hours</option>
					<option value="DAY">Days</option>
					<option value="MONTH">Months</option>
				</select></div>
				<button type="button" onclick="submitForm()" class="form_button">Submit</button>
			</form>
		</div>
	<?php

		$message_id = $_GET['x'];

		if ( ! isset($message_id) ) { 

		echo '<script language="javascript">showForm();</script>';

		 } else { 

		echo sprintf( '<script language="javascript">showMessage("%s");</script>', $message_id );

	}
		?>
		<div id="toast"></div>
	</body>
	<img src="images/burner-bg.png" class="bar-background" width="0" height="0"/>
</html>