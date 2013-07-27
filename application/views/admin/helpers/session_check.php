<?php

/**
 * @author Litkovskiy
 * @copyright 2010
 */
 session_start();
 if((!isset($_SESSION['user']) && !isset($_SESSION['status_user'])) || (!isset($_SESSION['login']) && !isset($_SESSION['status_user'])))
 {
 	echo "<html><head>
			<meta http-equiv='Refresh' content='0; URL=http://www.homopsy.com/'>
			</head></html>";
			exit(session_destroy());
 }
?>
