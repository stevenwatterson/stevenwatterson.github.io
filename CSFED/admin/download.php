<?php
require_once "../res/x5engine.php";
require_once "../res/l10n.php";
require_once "../res/x5settings.php";
require_once "checkaccess.php";

if (!isset($_GET['what']))
	return;

// Let's provide a ice way to add more files

switch ($_GET['what']) {
	case "emaillibrary": 
		// Download the email.inc.php file
		if (!file_exists("../res/imemail.inc.php"))
			return;
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=imemail.inc.php");
		header("Content-Transfer-Encoding: text/plain");
		@readfile("../res/imemail.inc.php");
		break;
}

// End of file
