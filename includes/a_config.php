<?php
	switch ($_SERVER["SCRIPT_NAME"]) {
		case "/Project_daw/about.php":
			$CURRENT_PAGE = "About"; 
			$PAGE_TITLE = "About Us";
			break;
		case "/Project_daw/contact.php":
			$CURRENT_PAGE = "Contact"; 
			$PAGE_TITLE = "Contact Us";
			break;
		case "/Project_daw/login.php":
			$CURRENT_PAGE = "Login"; 
			$PAGE_TITLE = "Login";
			break;
		default:
			$CURRENT_PAGE = "Index";
			$PAGE_TITLE = "Welcome to MOVE!";
	}
?>